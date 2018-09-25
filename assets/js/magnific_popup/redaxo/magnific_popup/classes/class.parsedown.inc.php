<?php

#
#
# Parsedown
# http://parsedown.org
#
# (c) Emanuil Rusev
# http://erusev.com
#
# For the full license information, please view the LICENSE file that was
# distributed with this source code.
#
#

/**
 * Class Parsedown
 */
class Parsedown
{
    #
    # Multiton (http://en.wikipedia.org/wiki/Multiton_pattern)
    #

    /**
     * @param string $name
     * @return mixed|Parsedown
     */
    public static function instance($name = 'default')
    {
        if (isset(self::$instances[$name])) {
            return self::$instances[$name];
        }

        $instance = new Parsedown();

        self::$instances[$name] = $instance;

        return $instance;
    }

    private static $instances = [];

    #
    # Setters
    #

    private $break_marker = "  \n";

    /**
     * @param $breaks_enabled
     * @return $this
     */
    public function set_breaks_enabled($breaks_enabled)
    {
        $this->break_marker = $breaks_enabled ? "\n" : "  \n";

        return $this;
    }

    #
    # Fields
    #

    private $reference_map       = [];
    private $escape_sequence_map = [];

    #
    # Public Methods
    #

    /**
     * @param $text
     * @return mixed|string
     */
    public function parse($text)
    {
        # removes \r characters
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);

        # replaces tabs with spaces
        $text = str_replace("\t", '    ', $text);

        # encodes escape sequences

        if (false !== strpos($text, '\\')) {
            $escape_sequences = ['\\\\', '\`', '\*', '\_', '\{', '\}', '\[', '\]', '\(', '\)', '\>', '\#', '\+', '\-', '\.', '\!'];

            foreach ($escape_sequences as $index => $escape_sequence) {
                if (false !== strpos($text, $escape_sequence)) {
                    $code = "\x1A" . '\\' . $index . ';';

                    $text = str_replace($escape_sequence, $code, $text);

                    $this->escape_sequence_map[$code] = $escape_sequence;
                }
            }
        }

        # ~

        $text = trim($text, "\n");

        $lines = explode("\n", $text);

        $text = $this->parse_block_elements($lines);

        # decodes escape sequences

        foreach ($this->escape_sequence_map as $code => $escape_sequence) {
            $text = str_replace($code, $escape_sequence[1], $text);
        }

        # ~

        $text = rtrim($text, "\n");

        return $text;
    }

    #
    # Private Methods
    #

    /**
     * @param array  $lines
     * @param string $context
     * @return string
     */
    private function parse_block_elements(array $lines, $context = '')
    {
        $elements = [];

        $element = [
            'type' => ''
        ];

        foreach ($lines as $line) {
            # fenced elements

            switch ($element['type']) {
                case 'fenced block':

                    if (!isset($element['closed'])) {
                        if (preg_match('/^[ ]*' . $element['fence'][0] . '{3,}[ ]*$/', $line)) {
                            $element['closed'] = true;
                        } else {
                            '' !== $element['text'] and $element['text'] .= "\n";

                            $element['text'] .= $line;
                        }

                        continue 2;
                    }

                    break;

                case 'block-level markup':

                    if (!isset($element['closed'])) {
                        if (false !== strpos($line, $element['start'])) { # opening tag
                            $element['depth']++;
                        }

                        if (false !== strpos($line, $element['end'])) { # closing tag
                            $element['depth'] > 0 ? $element['depth']-- : $element['closed'] = true;
                        }

                        $element['text'] .= "\n" . $line;

                        continue 2;
                    }

                    break;
            }

            # *

            $deindented_line = ltrim($line);

            if ('' === $deindented_line) {
                $element['interrupted'] = true;

                continue;
            }

            # composite elements

            switch ($element['type']) {
                case 'blockquote':

                    if (!isset($element['interrupted'])) {
                        $line = preg_replace('/^[ ]*>[ ]?/', '', $line);

                        $element['lines'] [] = $line;

                        continue 2;
                    }

                    break;

                case 'li':

                    if (preg_match('/^([ ]{0,3})(\d+[.]|[*+-])[ ](.*)/', $line, $matches)) {
                        if ($element['indentation'] !== $matches[1]) {
                            $element['lines'] [] = $line;
                        } else {
                            unset($element['last']);

                            $elements [] = $element;

                            $element = [
                                'type'        => 'li',
                                'indentation' => $matches[1],
                                'last'        => true,
                                'lines'       => [
                                    preg_replace('/^[ ]{0,4}/', '', $matches[3])
                                ]
                            ];
                        }

                        continue 2;
                    }

                    if (isset($element['interrupted'])) {
                        if (' ' === $line[0]) {
                            $element['lines'] [] = '';

                            $line = preg_replace('/^[ ]{0,4}/', '', $line);

                            $element['lines'] [] = $line;

                            unset($element['interrupted']);

                            continue 2;
                        }
                    } else {
                        $line = preg_replace('/^[ ]{0,4}/', '', $line);

                        $element['lines'] [] = $line;

                        continue 2;
                    }

                    break;
            }

            # indentation sensitive types

            switch ($line[0]) {
                case ' ':

                    # code block

                    if (isset($line[3]) and ' ' === $line[3] and ' ' === $line[2] and ' ' === $line[1]) {
                        $code_line = substr($line, 4);

                        if ('code block' === $element['type']) {
                            if (isset($element['interrupted'])) {
                                $element['text'] .= "\n";

                                unset($element['interrupted']);
                            }

                            $element['text'] .= "\n" . $code_line;
                        } else {
                            $elements [] = $element;

                            $element = [
                                'type' => 'code block',
                                'text' => $code_line
                            ];
                        }

                        continue 2;
                    }

                    break;

                case '#':

                    # atx heading (#)

                    if (isset($line[1])) {
                        $elements [] = $element;

                        $level = 1;

                        while (isset($line[$level]) and '#' === $line[$level]) {
                            ++$level;
                        }

                        $element = [
                            'type'  => 'heading',
                            'text'  => trim($line, '# '),
                            'level' => $level
                        ];

                        continue 2;
                    }

                    break;

                case '-':
                case '=':

                    # setext heading

                    if ('paragraph' === $element['type'] and false === isset($element['interrupted'])) {
                        $chopped_line = rtrim($line);

                        $i = 1;

                        while (isset($chopped_line[$i])) {
                            if ($chopped_line[$i] !== $line[0]) {
                                break 2;
                            }

                            ++$i;
                        }

                        $element['type']  = 'heading';
                        $element['level'] = '-' === $line[0] ? 2 : 1;

                        continue 2;
                    }

                    break;
            }

            # indentation insensitive types

            switch ($deindented_line[0]) {
                case '<':

                    $position = strpos($deindented_line, '>');

                    if ($position > 1) { # tag
                        $name = substr($deindented_line, 1, $position - 1);
                        $name = rtrim($name);

                        if ('/' === substr($name, -1)) {
                            $self_closing = true;

                            $name = substr($name, 0, -1);
                        }

                        $position = strpos($name, ' ');

                        if ($position) {
                            $name = substr($name, 0, $position);
                        }

                        if (!ctype_alpha($name)) {
                            break;
                        }

                        if (in_array($name, $this->inline_tags)) {
                            break;
                        }

                        $elements [] = $element;

                        if (isset($self_closing)) {
                            $element = [
                                'type' => 'self-closing tag',
                                'text' => $deindented_line
                            ];

                            unset($self_closing);

                            continue 2;
                        }

                        $element = [
                            'type'  => 'block-level markup',
                            'text'  => $deindented_line,
                            'start' => '<' . $name . '>',
                            'end'   => '</' . $name . '>',
                            'depth' => 0
                        ];

                        if (strpos($deindented_line, $element['end'])) {
                            $element['closed'] = true;
                        }

                        continue 2;
                    }

                    break;

                case '>':

                    # quote

                    if (preg_match('/^>[ ]?(.*)/', $deindented_line, $matches)) {
                        $elements [] = $element;

                        $element = [
                            'type'  => 'blockquote',
                            'lines' => [
                                $matches[1]
                            ]
                        ];

                        continue 2;
                    }

                    break;

                case '[':

                    # reference

                    if (preg_match('/^\[(.+?)\]:[ ]*(.+?)(?:[ ]+[\'"](.+?)[\'"])?[ ]*$/', $deindented_line, $matches)) {
                        $label = strtolower($matches[1]);

                        $this->reference_map[$label] = [
                            '»' => trim($matches[2], '<>')
                        ];

                        if (isset($matches[3])) {
                            $this->reference_map[$label]['#'] = $matches[3];
                        }

                        continue 2;
                    }

                    break;

                case '`':
                case '~':

                    # fenced code block

                    if (preg_match('/^([`]{3,}|[~]{3,})[ ]*(\S+)?[ ]*$/', $deindented_line, $matches)) {
                        $elements [] = $element;

                        $element = [
                            'type'  => 'fenced block',
                            'text'  => '',
                            'fence' => $matches[1]
                        ];

                        isset($matches[2]) and $element['language'] = $matches[2];

                        continue 2;
                    }

                    break;

                case '*':
                case '+':
                case '-':
                case '_':

                    # hr

                    if (preg_match('/^([-*_])([ ]{0,2}\1){2,}[ ]*$/', $deindented_line)) {
                        $elements [] = $element;

                        $element = [
                            'type' => 'hr'
                        ];

                        continue 2;
                    }

                    # li

                    if (preg_match('/^([ ]*)[*+-][ ](.*)/', $line, $matches)) {
                        $elements [] = $element;

                        $element = [
                            'type'        => 'li',
                            'ordered'     => false,
                            'indentation' => $matches[1],
                            'last'        => true,
                            'lines'       => [
                                preg_replace('/^[ ]{0,4}/', '', $matches[2])
                            ]
                        ];

                        continue 2;
                    }
            }

            # li

            if ($deindented_line[0] <= '9' and $deindented_line[0] >= '0' and preg_match('/^([ ]*)\d+[.][ ](.*)/', $line, $matches)) {
                $elements [] = $element;

                $element = [
                    'type'        => 'li',
                    'ordered'     => true,
                    'indentation' => $matches[1],
                    'last'        => true,
                    'lines'       => [
                        preg_replace('/^[ ]{0,4}/', '', $matches[2])
                    ]
                ];

                continue;
            }

            # paragraph

            if ('paragraph' === $element['type']) {
                if (isset($element['interrupted'])) {
                    $elements [] = $element;

                    $element['text'] = $line;

                    unset($element['interrupted']);
                } else {
                    $element['text'] .= "\n" . $line;
                }
            } else {
                $elements [] = $element;

                $element = [
                    'type' => 'paragraph',
                    'text' => $line
                ];
            }
        }

        $elements [] = $element;

        unset($elements[0]);

        #
        # ~
        #

        $markup = '';

        foreach ($elements as $element) {
            switch ($element['type']) {
                case 'paragraph':

                    $text = $this->parse_span_elements($element['text']);

                    if ('li' === $context and '' === $markup) {
                        if (isset($element['interrupted'])) {
                            $markup .= "\n" . '<p>' . $text . '</p>' . "\n";
                        } else {
                            $markup .= $text;
                        }
                    } else {
                        $markup .= '<p>' . $text . '</p>' . "\n";
                    }

                    break;

                case 'blockquote':

                    $text = $this->parse_block_elements($element['lines']);

                    $markup .= '<blockquote>' . "\n" . $text . '</blockquote>' . "\n";

                    break;

                case 'code block':

                    $text = htmlspecialchars($element['text'], ENT_QUOTES | ENT_NOQUOTES, 'UTF-8');

                    false !== strpos($text, "\x1A\\") and $text = strtr($text, $this->escape_sequence_map);

                    $markup .= isset($element['language']) ? '<pre><code class="language-' . $element['language'] . '">' . $text . '</code></pre>' : '<pre><code>' . $text . '</code></pre>';

                    $markup .= "\n";

                    break;

                case 'fenced block':

                    $text = $element['text'];

                    false !== strpos($text, "\x1A\\") and $text = strtr($text, $this->escape_sequence_map);

                    $markup .= rex_highlight_string($text, true) . "\n";

                    $markup .= "\n";

                    break;

                case 'heading':

                    $text = $this->parse_span_elements($element['text']);

                    $markup .= '<h' . $element['level'] . '>' . $text . '</h' . $element['level'] . '>' . "\n";

                    break;

                case 'hr':

                    $markup .= '<hr >' . "\n";

                    break;

                case 'li':

                    if (isset($element['ordered'])) { # first
                        $list_type = $element['ordered'] ? 'ol' : 'ul';

                        $markup .= '<' . $list_type . '>' . "\n";
                    }

                    if (isset($element['interrupted']) and !isset($element['last'])) {
                        $element['lines'] [] = '';
                    }

                    $text = $this->parse_block_elements($element['lines'], 'li');

                    $markup .= '<li>' . $text . '</li>' . "\n";

                    isset($element['last']) and $markup .= '</' . $list_type . '>' . "\n";

                    break;

                case 'block-level markup':

                    $markup .= $element['text'] . "\n";

                    break;

                default:

                    $markup .= $element['text'] . "\n";
            }
        }

        return $markup;
    }

    /**
     * @param       $text
     * @param array $markers
     * @return string
     */
    private function parse_span_elements($text, $markers = ['![', '&', '*', '<', '[', '_', '`', 'http', '~~'])
    {
        if (false === isset($text[2]) or $markers === []) {
            return $text;
        }

        # ~

        $markup = '';

        while ($markers) {
            $closest_marker          = null;
            $closest_marker_index    = 0;
            $closest_marker_position = null;

            foreach ($markers as $index => $marker) {
                $marker_position = strpos($text, $marker);

                if (false === $marker_position) {
                    unset($markers[$index]);

                    continue;
                }

                if (null === $closest_marker or $marker_position < $closest_marker_position) {
                    $closest_marker          = $marker;
                    $closest_marker_index    = $index;
                    $closest_marker_position = $marker_position;
                }
            }

            # ~

            if (null === $closest_marker or false === isset($text[$closest_marker_position + 2])) {
                $markup .= $text;

                break;
            } else {
                $markup .= substr($text, 0, $closest_marker_position);
            }

            $text = substr($text, $closest_marker_position);

            # ~

            unset($markers[$closest_marker_index]);

            # ~

            switch ($closest_marker) {
                case '![':
                case '[':

                    if (strpos($text, ']') and preg_match('/\[((?:[^][]|(?R))*)\]/', $text, $matches)) {
                        $element = [
                            '!' => '!' === $text[0],
                            'a' => $matches[1]
                        ];

                        $offset = strlen($matches[0]);

                        $element['!'] and ++$offset;

                        $remaining_text = substr($text, $offset);

                        if ('(' === $remaining_text[0] and preg_match('/\([ ]*(.*?)(?:[ ]+[\'"](.+?)[\'"])?[ ]*\)/', $remaining_text, $matches)) {
                            $element['»'] = $matches[1];

                            if (isset($matches[2])) {
                                $element['#'] = $matches[2];
                            }

                            $offset += strlen($matches[0]);
                        } elseif ($this->reference_map) {
                            $reference = $element['a'];

                            if (preg_match('/^\s*\[(.*?)\]/', $remaining_text, $matches)) {
                                $reference = $matches[1] ?: $element['a'];

                                $offset += strlen($matches[0]);
                            }

                            $reference = strtolower($reference);

                            if (isset($this->reference_map[$reference])) {
                                $element['»'] = $this->reference_map[$reference]['»'];

                                if (isset($this->reference_map[$reference]['#'])) {
                                    $element['#'] = $this->reference_map[$reference]['#'];
                                }
                            } else {
                                unset($element);
                            }
                        } else {
                            unset($element);
                        }
                    }

                    if (isset($element)) {
                        $element['»'] = str_replace('&', '&amp;', $element['»']);
                        $element['»'] = str_replace('<', '&lt;', $element['»']);

                        if ($element['!']) {
                            $markup .= '<img alt="' . $element['a'] . '" src="' . $element['»'] . '" >';
                        } else {
                            $element['a'] = $this->parse_span_elements($element['a'], $markers);

                            $markup .= isset($element['#']) ? '<a href="' . $element['»'] . '" title="' . $element['#'] . '">' . $element['a'] . '</a>' : '<a href="' . $element['»'] . '">' . $element['a'] . '</a>';
                        }

                        unset($element);
                    } else {
                        $markup .= $closest_marker;

                        $offset = '![' === $closest_marker ? 2 : 1;
                    }

                    break;

                case '&':

                    if (preg_match('/^&#?\w+;/', $text, $matches)) {
                        $markup .= $matches[0];

                        $offset = strlen($matches[0]);
                    } else {
                        $markup .= '&amp;';

                        $offset = 1;
                    }

                    break;

                case '*':
                case '_':

                    if ($text[1] === $closest_marker and preg_match($this->strong_regex[$closest_marker], $text, $matches)) {
                        $matches[1] = $this->parse_span_elements($matches[1], $markers);

                        $markup .= '<strong>' . $matches[1] . '</strong>';
                    } elseif (preg_match($this->em_regex[$closest_marker], $text, $matches)) {
                        $matches[1] = $this->parse_span_elements($matches[1], $markers);

                        $markup .= '<em>' . $matches[1] . '</em>';
                    } elseif ($text[1] === $closest_marker and preg_match($this->strong_em_regex[$closest_marker], $text, $matches)) {
                        $matches[2] = $this->parse_span_elements($matches[2], $markers);

                        $matches[1] and $matches[1] = $this->parse_span_elements($matches[1], $markers);
                        $matches[3] and $matches[3] = $this->parse_span_elements($matches[3], $markers);

                        $markup .= '<strong>' . $matches[1] . '<em>' . $matches[2] . '</em>' . $matches[3] . '</strong>';
                    } elseif (preg_match($this->em_strong_regex[$closest_marker], $text, $matches)) {
                        $matches[2] = $this->parse_span_elements($matches[2], $markers);

                        $matches[1] and $matches[1] = $this->parse_span_elements($matches[1], $markers);
                        $matches[3] and $matches[3] = $this->parse_span_elements($matches[3], $markers);

                        $markup .= '<em>' . $matches[1] . '<strong>' . $matches[2] . '</strong>' . $matches[3] . '</em>';
                    }

                    if (isset($matches) and $matches) {
                        $offset = strlen($matches[0]);
                    } else {
                        $markup .= $closest_marker;

                        $offset = 1;
                    }

                    break;

                case '<':

                    if (false !== strpos($text, '>')) {
                        if ('h' === $text[1] and preg_match('/^<(https?:[\/]{2}[^\s]+?)>/i', $text, $matches)) {
                            $element_url = $matches[1];
                            $element_url = str_replace('&', '&amp;', $element_url);
                            $element_url = str_replace('<', '&lt;', $element_url);

                            $markup .= '<a href="' . $element_url . '">' . $element_url . '</a>';

                            $offset = strlen($matches[0]);
                        } elseif (preg_match('/^<\/?\w.*?>/', $text, $matches)) {
                            $markup .= $matches[0];

                            $offset = strlen($matches[0]);
                        } else {
                            $markup .= '&lt;';

                            $offset = 1;
                        }
                    } else {
                        $markup .= '&lt;';

                        $offset = 1;
                    }

                    break;

                case '`':

                    if (preg_match('/^`(.+?)`/', $text, $matches)) {
                        $element_text = $matches[1];
                        $element_text = htmlspecialchars($element_text, ENT_QUOTES | ENT_NOQUOTES, 'UTF-8');

                        if ($this->escape_sequence_map and false !== strpos($element_text, "\x1A")) {
                            $element_text = strtr($element_text, $this->escape_sequence_map);
                        }

                        $markup .= '<code>' . $element_text . '</code>';

                        $offset = strlen($matches[0]);
                    } else {
                        $markup .= '`';

                        $offset = 1;
                    }

                    break;

                case 'http':

                    if (preg_match('/^https?:[\/]{2}[^\s]+\b/i', $text, $matches)) {
                        $element_url = $matches[0];
                        $element_url = str_replace('&', '&amp;', $element_url);
                        $element_url = str_replace('<', '&lt;', $element_url);

                        $markup .= '<a href="' . $element_url . '">' . $element_url . '</a>';

                        $offset = strlen($matches[0]);
                    } else {
                        $markup .= 'http';

                        $offset = 4;
                    }

                    break;

                case '~~':

                    if (preg_match('/^~~(?=\S)(.+?)(?<=\S)~~/', $text, $matches)) {
                        $matches[1] = $this->parse_span_elements($matches[1], $markers);

                        $markup .= '<del>' . $matches[1] . '</del>';

                        $offset = strlen($matches[0]);
                    } else {
                        $markup .= '~~';

                        $offset = 2;
                    }

                    break;
            }

            if (isset($offset)) {
                $text = substr($text, $offset);
            }

            $markers[$closest_marker_index] = $closest_marker;
        }

        $markup = str_replace($this->break_marker, '<br >' . "\n", $markup);

        return $markup;
    }

    #
    # Read-only
    #

    private $inline_tags = [
        'a',
        'abbr',
        'acronym',
        'b',
        'bdo',
        'big',
        'br',
        'button',
        'cite',
        'code',
        'dfn',
        'em',
        'i',
        'img',
        'input',
        'kbd',
        'label',
        'map',
        'object',
        'q',
        'samp',
        'script',
        'select',
        'small',
        'span',
        'strong',
        'sub',
        'sup',
        'textarea',
        'tt',
        'var'
    ];

    # ~

    private $strong_regex = [
        '*' => '/^[*]{2}([^*]+?)[*]{2}(?![*])/s',
        '_' => '/^__([^_]+?)__(?!_)/s'
    ];

    private $em_regex = [
        '*' => '/^[*]([^*]+?)[*](?![*])/s',
        '_' => '/^_([^_]+?)[_](?![_])\b/s'
    ];

    private $strong_em_regex = [
        '*' => '/^[*]{2}(.*?)[*](.+?)[*](.*?)[*]{2}/s',
        '_' => '/^__(.*?)_(.+?)_(.*?)__/s'
    ];

    private $em_strong_regex = [
        '*' => '/^[*](.*?)[*]{2}(.+?)[*]{2}(.*?)[*]/s',
        '_' => '/^_(.*?)__(.+?)__(.*?)_/s'
    ];
}
