/*	
 *	jQuery Touch Optimized Sliders "R"Us 1.4.0
 *	
 *	Copyright (c) 2013 Fred Heusschen
 *	www.frebsite.nl
 *
 *	Plugin website:
 *	tosrus.frebsite.nl
 *
 *	Dual licensed under the MIT and GPL licenses.
 *	http://en.wikipedia.org/wiki/MIT_License
 *	http://en.wikipedia.org/wiki/GNU_General_Public_License
 */
 
 
 //	Whishlist
 //	- drag image around if zoomed

(function( $ )
{
	if ( $.fn.TosRUs )
	{
		return;
	}

	var $window, $html, $body;
	var _viewScale = false,
		_isTouch = ( 'ontouchstart' in window ),
		_duration = 400;


	$.fn.TosRUs = $.fn.tosrus = function( oDefault, oDesktop, oTouch )
	{

		if ( this.length == 0 )
		{
			return this;
		}


		/*
			GLOBAL VARS
		*/
		var $tos = this,
			_tos = this[ 0 ];

		oDefault = complObject( oDefault, {} );
		oDefault = ( _isTouch )
			? $.extend( true, {}, oDefault, oTouch )
			: $.extend( true, {}, oDefault, oDesktop );

		var opts = complementOptions( oDefault, $tos, _tos ),
			_fixed = ( opts.wrapper.target == 'window' ),
			_index = 0,
			_total = 0,
			_scrollPosition = 0;

		$window = $(window);
		$html 	= $('html');
		$body 	= $('body');

		if ( !_viewScale && _isTouch && typeof FlameViewportScale != 'undefined' )
		{
			_viewScale = new FlameViewportScale();
		}


		/*
			MARKUP
		*/
		var $wrpr = $('<div class="' + cls( 'wrapper' ) + '" />'),
			$sldr = $('<div class="' + cls( 'slider' ) + '" />').appendTo( $wrpr ),
			$clse = null,
			$capt = null,
			$prev = null,
			$next = null;

		$wrpr
			.css( opts.wrapper.css )
			.addClass( cls( _fixed ? 'fixed' : 'inline' ) )
			.addClass( cls( _isTouch ? 'touch' : 'desktop' ) )
			.addClass( cls( opts.slides.scale ) );

		if ( opts.caption )
		{
			$capt = $('<div class="' + cls( 'caption' ) + '" />').appendTo( $wrpr );
		}
		if ( opts.prev.button )
		{
			$prev = ( opts.prev.button instanceof $ )
				? opts.prev.button
				: $('<a class="' + cls( 'prev' ) + '" href="#" />').appendTo( $wrpr );
		}
		if ( opts.next.button )
		{
			$next = ( opts.next.button instanceof $ )
				? opts.next.button
				: $('<a class="' + cls( 'next' ) + '" href="#" />').appendTo( $wrpr );
		}
		if ( opts.close.button )
		{
			$clse = ( opts.close.button instanceof $ )
				? opts.close.button
				: $('<a class="' + cls( 'close' ) + '" href="#" />').appendTo( $wrpr );
		}


		/*
			ADD SLIDES
		*/
		var $anchors = getValidAnchors( $tos, opts ),
			$slides = _initSlides( $tos, $anchors, $wrpr, $sldr, opts );


		_total = $slides.length;
		_index = setIndex( _index, $wrpr );


		/*
			EVENTS
		*/
		$wrpr
			.bind(
				evt( '' ),
				function( e )
				{
					e.stopPropagation();
				}
			)

			//	Open event, opens the gallery and slides to the designated slide
			.bind(
				evt( 'open' ),
				function( e, index, direct )
				{
					if ( !_opened )
					{
						if ( _fixed )
						{
							_scrollPosition = $window.scrollTop();
						}

						$wrpr
							.show()
							.css( 'opacity', 0 )
							.addClass( cls( 'hover' ) );

						animate(
							$wrpr,
							{ 'opacity': 1 },
							direct
						);


						//	scale buttons
						scaleButtons( [ $prev, $next, $clse ], $capt );

						//	callback event
						$wrpr.trigger( evt( 'opening' ), [ index, direct ] );
					}

					loadContents( $sldr, _index, opts );

 					direct = ( direct || !_opened );

					_opened = setOpened( true, $wrpr );

					if ( $.isNumeric( index ) )
					{
						$wrpr.trigger( evt( 'slideTo' ), [ index, direct ] );
					}
				}
			)

			//	Close event, closes the gallery
			.bind(
				evt( 'close' ),
				function( e, direct )
				{
					if ( _opened )
					{
						$wrpr.removeClass( cls( 'hover' ) );

      stopVideo( $wrpr.find( '.' + cls( 'video' ) ), 'stop' );

						if ( typeof direct == 'undefined' )
						{
							direct = _duration / 2;
						}

						animate(
							$('div.' + cls ( 'wrapper' ) ), //$wrpr, // PATCH
							{ 'opacity': 0 },
							direct,
							function()
							{
                                $('div.' + cls ( 'wrapper' ) ).hide(); //$wrpr.hide(); // PATCH
							}
						);

						//	callback event
						$wrpr.trigger( evt( 'closing' ), [ direct ] );
					}
					_opened = setOpened( false, $wrpr );
				}
			)

			//	Prev + Prev events, slides to the previous / next set of slides
			.bind(
				evt( 'prev' ) + ' ' + evt( 'next' ),
				function( e, slides, duration, easing )
				{
					if ( !$.isNumeric( slides ) )
					{
						slides = opts[ e.type ].slides;
					}
					$wrpr.trigger( evt( 'slideTo' ), [ ( e.type == 'prev' ) ? _index - slides : _index + slides, duration, easing ] );
				}
			)

			//	SlideTo event, slides to the designated slide
			.bind(
				evt( 'slideTo' ),
				function( e, slide, duration, easing )
				{
					if ( !_opened )
					{
						return false;
					}
					if ( !$.isNumeric( slide ) )
					{
						return false;
					}

					var doSlide = true;

					//	Less then first
					if ( slide < 0 )
					{
						slide = 0;
						if ( _index == 0 )
						{
							doSlide = false;
						}
					}

					//	More then last
					else if ( slide + opts.slides.visible > _total )
					{
						slide = _total - opts.slides.visible;
						if ( _index + opts.slides.visible >= _total )
						{
							doSlide = false;
						}
					}

					var $curSlide = $sldr.children().eq( _index );

					_index = setIndex( slide, $wrpr );

					loadContents( $sldr, _index, opts );
					setButtons( $prev, $next, _index, _total, opts );

					if ( doSlide )
					{
						//	Slide
						var left = 0 - ( _index * opts.slides.width ) + opts.slides.offset;
						if ( opts.slidesWidthPercentage )
						{
							left += '%';
						}
						animate(
							$sldr,
							{ 'left': left },
							duration,
							null,
							easing
						);

						//	Get caption
						if ( opts.caption )
						{
							var caption = $sldr.children().eq( _index ).data( dta( 'caption' ) );
							$capt
								.text( caption )
								[ ( caption.length > 0 ) ? 'show' : 'hide' ]();
						}

						stopVideo( $curSlide.filter( '.' + cls( 'video' ) ), 'pause' );

						//	callback event
						$wrpr.trigger( evt( 'sliding' ), [ _index, duration ] );
					}
				}
			)

			//	Toggle UI
			.bind(
				evt( 'click' ),
				function( e )
				{
					$wrpr.toggleClass( cls( 'hover' ) );
				}
			);


		/*
			BUTTONS
		*/
		setButtons( $prev, $next, _index, _total, opts );
		_initButtons(
			$wrpr,
			{
				'prev'	: $prev,
				'next'	: $next,
				'close'	: $clse
			}
		);
		$window.bind(
			evt( 'orientationchange' ),
			function()
			{
				if ( _opened )
				{
					scaleButtons( [ $prev, $next, $clse ], $capt, 250 );
				}
			}
		);


		/*
			KEYPRESSES
		*/
		_initKeys( $wrpr, opts );


		/*
			DRAGGING
		*/
		if ( opts.touch.drag )
		{
			$.fn.TosRUs.dragSlide( $wrpr, opts.slides.visible, _total );
		}


		/*
			PREVENT SCROLLING
		*/
		if ( _fixed )
		{
			$window.bind(
				evt( 'scroll' ),
				function( e )
				{
					if ( _opened )
					{
						window.scrollTo( 0, _scrollPosition );
						e.preventDefault();
						e.stopImmediatePropagation();
					}
				}
			);
		}


		/*
			START
		*/
		var _opened = setOpened( true, $wrpr );

		if ( _fixed )
		{
			$wrpr
				.appendTo( $body )
				.trigger( evt( 'close' ), [ true ] );
		}
		else
		{
			$wrpr.appendTo( opts.wrapper.target );

			if ( opts.show )
			{
				_opened = setOpened( false, $wrpr );
				$wrpr.trigger( evt( 'open' ), [ 0, true ] );
			}
			else
			{
				$wrpr.trigger( evt( 'close' ), [ true ] );
			}
		}

		return $wrpr;
	};


	/*
		Public variables
	*/
	$.fn.TosRUs.isTouch = _isTouch;


	/*
		Public methods
	*/
	$.fn.TosRUs.dragSlide = function( $wrpr, _visible, _total )
	{
		var $sldr = $wrpr.find( '> .' + cls( 'slider' ) );

		var _distance = 0,
			_direction = false,
			_swiping = false;

		$wrpr
			.hammer()
			.on(
				evt( 'dragleft' ) + ' ' + evt( 'dragright' ),
				function( e )
				{
					e.gesture.preventDefault();
			        e.stopPropagation();

					_distance = e.gesture.deltaX;
					_direction = e.gesture.direction;
					_swiping = false;

					if ( ( _direction == 'left' && $wrpr.data( dta( 'index' ) ) + _visible >= _total  ) ||
						( _direction == 'right' && $wrpr.data( dta( 'index' ) ) == 0 ) )
					{
						_distance /= 2.5;
					}

					$sldr.css( 'marginLeft', Math.round( _distance ) );
				}
			)
			.on(
				evt( 'swipeleft' ) + ' ' + evt( 'swiperight' ),
				function( e )
				{
					e.gesture.preventDefault();
			        e.stopPropagation();
			        _swiping = true;
				}
			)
			.on(
				evt( 'dragend' ),
				function( e )
				{
					e.gesture.preventDefault();
			        e.stopPropagation();

					var duration = _duration / 2;

					if ( _direction == 'left' || _direction == 'right' )
					{
						var easing = null;
						if ( _swiping )
						{
							var slides = _visible;
							easing = 'swipeOutTos';
						}
						else
						{
							var slideWidth = $sldr.children().first().width(),
								slides = Math.floor( ( Math.abs( _distance ) + ( slideWidth / 2 ) ) / slideWidth );	
						}

						if ( slides > 0 )
						{
							$wrpr.trigger( evt( _direction == 'left' ? 'next' : 'prev' ), [ slides, duration, easing ] );
						}
					}

					animate(
						$sldr,
						{ 'marginLeft': 0 },
						duration,
						null,
						easing
					);

					_direction = false;
				}
			)
			.on(
				evt( 'pinch' ),
				function( e )
				{
					e.gesture.preventDefault();
					e.stopPropagation();
				}
			);
	}
	$.fn.TosRUs.pinchZoom = function( $img )
	{
		var _endScale = 1,
			_curScale = 1,
			_oldScale = 1,
			_newScale = 1;

		$img
			.hammer()
			.on(
				evt( 'pinch' ),
				function(e)
				{
					e.gesture.preventDefault();
					e.stopPropagation();

					_endScale = ( e.gesture.scale - _curScale ) * _oldScale;
					_curScale = e.gesture.scale;
					_newScale = restrictMinMax( _newScale + _endScale, 0.5, 4 );

					$img.css({
						'transform': 'scale( ' + _newScale + ' )'
					});
				}
			)
			.on(
				evt( 'doubletap' ),
				function( e )
				{
					e.gesture.preventDefault();
					e.stopPropagation();

					_endScale = 0;
					_curScale = 1;
					_newScale = ( _oldScale > 1 ) ? 1 : 3;
					_oldScale = animateScale(
						$img,
						_oldScale, 
						_newScale
					);
				}
			)
			.on(
				evt( 'release' ),
				function( e )
				{
					e.gesture.preventDefault();
					e.stopPropagation();

					_endScale = 0;
					_curScale = 1;
					_oldScale = _newScale;

					//	After scaled < 1, animate to 1
					if ( _oldScale < 1 )
					{
						_newScale = 1;
						_oldScale = animateScale(
							$img,
							_oldScale, 
							_newScale
						);
					}
				}
			);
	}


	/*
		SWIPE EASING		
	*/
	jQuery.extend( jQuery.easing,
	{
		swipeOutTos: function (x, t, b, c, d) {
			return c * Math.sin( t / d * ( Math.PI / 2 ) ) + b;
		}
	});


	/*
		INIT FUNCTIONS
	*/
	function _initSlides( $tos, $anchors, $wrpr, $sldr, opts )
	{
		if ( opts.slides.collect )
		{
			_initSlidesFromAnchors( $tos, $anchors, $wrpr, $sldr, opts );
		}
		else
		{
			_initSlidesFromContent( $tos, $anchors, $wrpr, $sldr, opts );
		}

		var $slides = $sldr.children();

		//	CSS
		if ( opts.slides.css )
		{
			$slides.css( opts.slides.css );
		}

		var width = opts.slides.width;
		if ( opts.slidesWidthPercentage )
		{
			width += '%';
		}
		$slides.css( 'width', width );

		return $slides;
	}
	function _initSlidesFromAnchors( $tos, $anchors, $wrpr, $sldr, opts )
	{
		getZoomAnchors( $anchors, opts ).addClass( cls( 'zoom' ) );

		$anchors
			.css( opts.anchors.css )
			.each(
				function( index )
				{
					var $anchor = $(this);

					//	Create the slide
					var $slide = $('<div class="' + cls( 'slide' ) + ' ' + cls( 'loading' ) + '" />')
						.data( dta( 'anchor' ), $anchor )
						.data( dta( 'content' ), $anchor.attr( 'href' ) )
						.appendTo( $sldr );
	
					//	Clicking an achor opens the slide
					$anchor
						.data( dta( 'slide' ), $slide )
						.bind(
							evt( opts.anchors.event ),
							function( e )
							{
								e.preventDefault();
								$wrpr.trigger( evt( 'open' ), [ index ] );
							}
						);

					//	Get caption
					if ( opts.caption )
					{
						$slide.data( dta( 'caption' ), '' );
						for ( var c = 0, l = opts.caption.length; c < l; c++ )
						{
							var caption = $anchor.attr( opts.caption[ c ] );
							if ( caption && caption.length )
							{
								$slide.data( dta( 'caption' ), caption );
								break;
							}
						}
					}
				}
			);
	}
	function _initSlidesFromContent( $tos, $anchors, $wrpr, $sldr, opts )
	{
		$tos.children().each(
			function( index )
			{
				var $slide = $(this);

				$('<div class="' + cls( 'slide' ) + '" />')
					.append( $slide )
					.appendTo( $sldr );

				$slide = $slide.parent();
				$slide.data( dta( 'caption' ), '' );

				var $content = $slide.children(),
					contenttype = 'html',
					videotype = 'youtube';
				
				//	IMAGE
				if ( $content.is( 'img' ) )
				{
					contenttype = 'image';
				}
				
				//	(video)
				else if ( $content.is( 'iframe' ) && $content.attr( 'src' ) )
				{
					var src = $content.attr( 'src' ).toLowerCase();

					//	YOUTUBE
					if ( src.indexOf( 'youtube.com/embed/' ) > -1 )
					{
						contenttype = 'video';
					}
					
					//	VIMEO
					else if ( src.indexOf( 'vimeo.com/video/' ) > -1 )
					{
						contenttype = 'video';
						videotype = 'vimeo';
					}
				}

				$slide.data( dta( 'contenttype' ), contenttype );

				switch ( contenttype )
				{

					//	IMAGE
					case 'image':
						if ( opts.touch.zoom )
						{
							$.fn.TosRUs.pinchZoom( $content );
						}
						break;


					//	HTML NODE
					case 'html':
						$content.wrap( '<div class="' + cls( 'content' ) + '" />' );
						break;


					//	VIDEO
					case 'video':
						$slide.data( dta( 'videotype' ), videotype );
						_initResizeVideo(
							$slide,
							opts.video.ratio,
							opts.video.maxWidth,
							opts.video.maxHeight
						);
						break;
				}
			}
		);
	}
	function _initResizeVideo( $slide, ratio, maxWidth, maxHeight )
	{
		var $video = $slide.children();

		$slide
			.addClass( cls( 'video' ) )
			.bind(
				evt( 'resizeVideo' ),
				function()
				{
					$video.removeAttr( 'style' );
					var _w = $slide.width(),
						_h = $slide.height();
	
					if ( maxWidth && _w > maxWidth )
					{
						_w = maxWidth;
					}
					if ( maxHeight && _h > maxHeight )
					{
						_h = maxHeight;
					}
	
					if ( _w / _h < ratio )
					{
						_h = _w / ratio;
					}
					else
					{
						_w = _h * ratio;
					}
	
					$video.width( _w );	
					$video.height( _h );
				}
			);

		$window.bind(
			evt( 'resize' ),
			function( e )
			{
				$slide.trigger( evt( 'resizeVideo' ) );
			}
		);
	}

	function _initButtons( $wrpr, btns )
	{
		$.each(
			btns,
			function( index, value )
			{
				if ( value )
				{
					value.bind(
						evt( 'click' ),
						function( e )
						{
							e.stopPropagation();
							e.preventDefault();
							$wrpr.trigger( evt( index ) );
						}
					);
				}
			}
		);
	}
	function _initKeys( $wrpr, opts )
	{
		if ( opts.prev.key || opts.next.key || opts.close.key )
		{
			$(document).bind(
				evt( 'keyup' ),
				function( e )
				{
					var k = e.keyCode;

					if ( k == 27 || k == 37 || k == 39 )
					{
						if ( $wrpr.data( dta( 'opened' ) ) )
						{
							if ( k == 27 && opts.close.key )
							{
								e.preventDefault();
								$wrpr.trigger( evt( 'close' ) );
							}
							else if ( 
								( k == 37 && opts.prev.key ) ||
								( k == 39 && opts.next.key )
							) {
								e.preventDefault();
								$wrpr.trigger( evt( k == 37 ? 'prev' : 'next' ) );
							}
						}
					}
				}
			);
		}
	}


	/*
		GENERAL FUNCTIONS
	*/
	function animate( $element, properties, direct, callback, easing )
	{
		var duration = _duration;

		if ( $.isNumeric( direct ) )
		{
			duration = direct;
			direct = false;
		}

		if ( direct )
		{
			$element.css( properties );
		}
		else
		{
			setTimeout(
				function()
				{
					$element.animate(
						properties,
						{
							duration: duration,
							complete: callback,
							easing: easing,
							queue: false
						}
					);
				}, 1
			);
		}
	}
	function animateScale( $element, startScale, endScale )
	{
		$('<div />').css('width', startScale).animate({
			'width': endScale
		}, {
			duration: _duration / 2,
			step: function( now )
			{
				$element.css({
					'transform': 'scale(' + now + ')'
				});
			}
		});
		return endScale;
	}
	function restrictMinMax( val, min, max )
	{
		if ( typeof min == 'number' && val < min )
		{
			val = min;
		}
		if ( typeof max == 'number' && val > max )
		{
			val = max;
		}
		return val;
	}
	function setIndex( _index, $wrpr )
	{
		$wrpr.data( dta( 'index' ), _index );
		return _index;
	}
	function setOpened( _opened, $wrpr )
	{
		$wrpr.data( dta( 'opened' ), _opened );
		return _opened;
	}
	function setButtons( $prev, $next, _index, _total, opts )
	{
		if ( $prev )
		{
			$prev[ ( ( _index < 1 ) ? 'add' : 'remove' ) + 'Class' ]( cls( 'disabled' ) );
		}
		if ( $next )
		{
			$next[ ( ( _index >= _total - opts.slides.visible ) ? 'add' : 'remove' ) + 'Class' ]( cls( 'disabled' ) );
		}
	}
	function scaleButtons( $btns, $capt, timeout )
	{
		if ( _viewScale )
		{
			var scale = _viewScale.getScale();

			if ( typeof scale != 'undefined' )
			{

				scale = 1 / scale;

				var $buttons = $();
				for ( var a = 0, l = $btns.length; a < l; a++ )
				{
					if ( $btns[ a ] )
					{
						$buttons = $buttons.add( $btns[ a ] );
					}
				}
				setTimeout(
					function()
					{
						if ( $capt )
						{
							$capt.css({
								'text-size-adjust': Math.ceil( 100 * restrictMinMax( scale, 1, 3 ) ) + '%'
							});
						}
						$buttons.css({
							'transform': 'scale(' + restrictMinMax( scale, 1, 2 ) + ')'
						});
					}, timeout || 1
				);
			}
		}
	}
	function loadContents( $sldr, _index, opts )
	{
		//	Preload current
		loadContent( $sldr, _index, _index + opts.slides.visible, opts );

		//	Preload prev + next
		setTimeout(
			function()
			{
				loadContent( $sldr, _index - opts.slides.visible, _index, opts );									//	prev
				loadContent( $sldr, _index + opts.slides.visible, _index + ( opts.slides.visible * 2 ), opts );		//	next
			}, 500
		);
	}
	function loadContent( $sldr, start, end, opts )
	{
		$sldr.children().slice( start, end ).each(
			function()
			{
				var $slide = $(this);
				if ( $slide.children().length == 0 )
				{

					var content = $slide.data( dta( 'content' ) ),
						orgContent = content,
						contenttype = false,
						videotype = 'youtube';

					//	IMAGES
					if ( $.inArray( content.toLowerCase().split( '.' ).pop().split( '?' )[ 0 ], [ 'jpg', 'jpe', 'jpeg', 'gif', 'png' ] ) > -1 )
					{
						contenttype = 'image';
					}

					//	HTML NODE
					else if ( content.indexOf( '#' ) == 0 )
					{
						content = $(content);
						contenttype = 'html';
					}

					//	YOUTUBE (video)
					else if ( content.toLowerCase().indexOf( 'youtube.com/watch' ) > -1 )
					{
						content = content.split( '?v=' )[ 1 ].split( '&' )[ 0 ];
						if ( opts.video.imageLink )
						{
							content = 'http://img.youtube.com/vi/' + content + '/0.jpg';
							contenttype = 'videolink';
						}
						else
						{
							content = 'http://www.youtube.com/embed/' + content;
							contenttype = 'video';
						}
					}

					//	VIMEO (video)
					else if ( content.toLowerCase().indexOf( 'vimeo.com/' ) > -1  )
					{
						content = 'http://player.vimeo.com/video/' + content.split( 'vimeo.com/' )[ 1 ].split( '?' )[ 0 ] + '?api=1';
						contenttype = 'video';
						videotype = 'vimeo';
					}

					$slide.data( dta( 'contenttype' ), contenttype );

					switch ( contenttype )
					{

						//	IMAGE
						case 'image':
						case 'videolink':
							$('<img border="0" />')
								.bind(
									evt( 'load' ),
									function( e )
									{
										e.stopPropagation();
										$slide.removeClass( cls( 'loading' ) );

										if ( contenttype == 'videolink' )
										{
											$('<a href="' + orgContent + '" class="' + cls( 'play' ) + '" />')
												.appendTo( $slide );
										}
										else
										{
											if ( opts.touch.zoom )
											{
												$.fn.TosRUs.pinchZoom( $(this) );
											}
										}
									}
								)
								.appendTo( $slide )
								.attr( 'src', content );

							break;


						//	HTML NODE
						case 'html':
							$slide.removeClass( cls( 'loading' ) );
							$('<div class="' + cls( 'content' ) + '" />')
								.append( content )
								.appendTo( $slide );

							break;


						//	VIDEO
						case 'video':
							$slide.data( dta( 'videotype' ), videotype );

							var $anchor = $slide.data( dta( 'anchor' ) );

							$('<iframe src="' + content + '" frameborder="0" allowfullscreen />')
								.appendTo( $slide );

							_initResizeVideo(
								$slide,
								$anchor.data( dta( 'ratio' ) ) || opts.video.ratio,
								$anchor.data( dta( 'maxWidth' ) ) || opts.video.maxWidth,
								$anchor.data( dta( 'maxHeight' ) ) || opts.video.maxHeight
							);

							setTimeout(
								function()
								{
									$slide.removeClass( cls( 'loading' ) );
								}, 2500
							);

							break;

					}
					$sldr.parent().trigger( 'loading', [ $slide.data( dta( 'anchor' ) ), $slide ] );
				}

				if ( $slide.data( dta( 'contenttype' ) ) == 'video' )
				{
					$slide.trigger( evt( 'resizeVideo' ) );
				}
			}
		);
	}
	function stopVideo( $slides, fn )
	{
		$slides.each(
			function()
			{
				var $slide = $(this),
					iframe = $slide.find( 'iframe' )[ 0 ];

				switch ( $slide.data( dta( 'videotype' ) ) )
				{
					case 'youtube':
						iframe.contentWindow.postMessage( '{ "event": "command", "func": "' + fn + 'Video" }', '*' );
						break;
					
					case 'vimeo':
						if ( fn == 'stop' )
						{
							fn = 'unload';
						}
						iframe.contentWindow.postMessage( '{ "method": "' + fn + '" }', '*' );
						break;
				}
			}
		);
	}

	function getValidAnchors( $org, opts )
	{
		var $anchors = $();

		if ( opts.slides.collect )
		{
			$anchors = $anchors.add( $org.filter( 'a[href*=".gif"]' ) );					//	gif
			$anchors = $anchors.add( $org.filter( 'a[href*=".png"]' ) );					//	png
			$anchors = $anchors.add( $org.filter( 'a[href*=".jpg"]' ) );					//	jpg
			$anchors = $anchors.add( $org.filter( 'a[href*=".jpe"]' ) );
			$anchors = $anchors.add( $org.filter( 'a[href*=".jpeg"]' ) );
			$anchors = $anchors.add( $org.filter( 'a[href^="#"][href!="#"]' ) );			//	hidden content
			$anchors = $anchors.add( $org.filter( 'a[href*="youtube.com/watch?v="]' ) );	//	youtube
			$anchors = $anchors.add( $org.filter( 'a[href*="vimeo.com/"]' ) );				//	vimeo	
		}
		return $anchors;
	}
	function getZoomAnchors( $org, opts )
	{
		var $anchors = $();
		if ( opts.anchors.zoomIcon )
		{
			$org.each(
				function()
				{
					var $t = $(this),
						$i = $t.children();

					if ( $i.length == 1 && $i.is( 'img' ) && $i.width() > 99 && $i.height() > 99 )
					{
						$anchors = $anchors.add( $t );
					}
				}
			);
		}
		return $anchors;
	}

/*
	$.fn.TosRUs.defaults = {
		show: false,
		draggable: {
			drag: false,
			zoom: false
		},
		buttons: true,
		keys: false,
		caption: ["rel", "title"],
		wrapper: {
			target: 'window',
			css: {
			}
		},
		slides: {
			visible: 1,
			collect: true,
			css: {
			}
		},
		anchors: {
			event: "click",
			zoomIcon: true,
			css: {
			}
		},
		prev: {
			slides: 1,
			button: true,
			key: false
		},
		next: {
			slides: 1,
			button: true,
			key: false
		},
		close: {
			button: true,
			key: false
		},
		video: {
			ratio: 16 / 9,
			maxWidth: false,
			maxHeight: false
		}
	};
*/
	function complementOptions( o, $tos, _tos )
	{

		//	Complement objects

		//	wrapper
		if ( $.isFunction( o.wrapper ) )
		{
			o.wrapper = {
				target: o.wrapper.call( _tos )
			};
		}
		else if ( typeof o.wrapper == 'string' )
		{
			o.wrapper = {
				target: $(o.wrapper)
			}
		}
		o.wrapper = complObject( o.wrapper, {} );

		if ( typeof o.touch == 'boolean' )
		{
			o.touch = {
				drag: o.touch,
				zoom: o.touch
			};
		}
		o.touch = complObject( o.touch, {} );

		//	slides
		if ( $.isNumeric( o.slides ) )
		{
			o.slides = {
				visible: o.slides
			};
		}
		else if ( typeof o.slides == 'string'  )
		{
			o.slides = {
				scale: o.slides
			};
		}
		o.slides = complObject( o.slides, {} );

		//	anchors
		if ( typeof o.anchors == 'boolean' )
		{
			o.anchors = {
				zoomIcon: o.anchors
			};
		}
		else if ( typeof o.anchors == 'string' )
		{
			o.anchors = {
				event: o.anchors
			}
		}
		o.anchors = complObject( o.anchors, {} );

		//	video
		if ( $.isNumeric( o.video ) )
		{
			o.video = {
				ratio: o.video
			};
		}
		o.video = complObject( o.video, {} );


		//	Fill options

		//	wrapper
		o.wrapper.css = complObject( o.wrapper.css, {} );
		if ( $.isFunction( o.wrapper.target ) )
		{
			o.wrapper.target = o.wrapper.target.call( _tos );
		}
		if ( typeof o.wrapper.target == 'string' )
		{
			o.wrapper.target = $(o.wrapper.target);
		}
		if ( !(o.wrapper.target instanceof $) || o.wrapper.target.length == 0 )
		{
			o.wrapper.target = ( o.slides.collect === false ) ? $tos : 'window';
		}

		//	show, touch, buttons, keys
		o.show = complBoolean(  o.show, !( o.wrapper.target == 'window' ) );
		o.touch = ( $.fn.hammer )
			? {
				drag: complBoolean( o.touch.drag, _isTouch ),
				zoom: complBoolean( o.touch.zoom, _isTouch && o.wrapper.target == 'window' )
			} : {
				drag: false,
				zoom: false
			};

		o.buttons = complBoolean( o.buttons, !o.touch.drag );
		o.keys = complBoolean( o.keys, ( !o.touch.drag && !o.buttons ) );

		//	caption
		if ( typeof o.caption == 'string' )
		{
			o.caption = [ o.caption ];
		}
		if ( o.caption !== false && !$.isArray( o.caption ) )
		{
			o.caption = ( o.wrapper.target == 'window' || o.caption === true ) ? [ 'rel', 'title' ] : false;
		}

		//	slides
		if ( $.isNumeric( o.slides.width ) )
		{
			o.slidesWidthPercentage = false;
			o.slides.visible = complNumber( o.slides.visible, 1 );
		}
		else
		{
			var percWidth = ( isPercentage( o.slides.width ) ) ? getPercentage( o.slides.width ) : false;

			o.slidesWidthPercentage = true;
			o.slides.visible = complNumber( o.slides.visible, ( percWidth ) ? Math.floor( 100 / percWidth ) : 1 );
			o.slides.width = ( percWidth ) ? percWidth : Math.ceil( 100 * 100 / o.slides.visible ) / 100;
		}

		o.slides.offset = ( isPercentage( o.slides.offset ) ) ? getPercentage( o.slides.offset ) : complNumber( o.slides.offset, 0 );
		o.slides.collect = complBoolean( o.slides.collect, o.wrapper.target == 'window' );
		o.slides.scale = complString( o.slides.scale, 'fit' );
		o.slides.css = complObject( o.slides.css, {} );

		//	anchors
		o.anchors.zoomIcon = complBoolean( o.anchors.zoomIcon, ( !_isTouch && o.wrapper.target == 'window' ) );
		o.anchors.event = complString( o.anchors.event, 'click' );
		o.anchors.css = complObject( o.anchors.css, {} );

		//	prev, next, close
		o = complButton( 'prev', o );
		o = complButton( 'next', o );
		o = complButton( 'close', o );

		//	video
		o.video.ratio = complNumber( o.video.ratio, 16 / 9 );
		o.video.maxWidth = complNumber( o.video.maxWidth, false );
		o.video.maxHeight = complNumber( o.video.maxHeight, false );
		o.video.imageLink = complBoolean( o.video.imageLink, _isTouch );

		return o;
	}
	function complButton( btn, o )
	{
		var navi = ( btn != 'close' );

		if ( navi && $.isNumeric( o[ btn ] ) )
		{
			o[ btn ] = {
				slides: o[ btn ]
			};
		}
		switch( typeof o[ btn ] )
		{
			case 'boolean':
			case 'string':
				o[ btn ] = {
					button: o[ btn ]
				};
				break;
		}

		if ( !$.isPlainObject( o[ btn ] ) )
		{
			o[ btn ] = {};
		}
		if ( navi && ( !$.isNumeric( o[ btn ].slides ) || o[ btn ].slides < 1 ) )
		{
			o[ btn ].slides = o.slides.visible;
		}

		if ( typeof o[ btn ].button == 'string' )
		{
				o[ btn ].button = $(o[ btn ].button);
		}
		if ( !( o[ btn ].button instanceof $ ) )
		{
			var defaultBtn = ( navi )
				? o.buttons
				: ( o.wrapper.target == 'window' );

			o[ btn ].button = complBoolean( o[ btn ].button, defaultBtn );
		}

		var defaultKey = ( navi )
			? o.keys
			: ( o.wrapper.target == 'window' && ( o.keys || !o[ btn ].button ) )

		o[ btn ].key = complBoolean( o[ btn ].key, defaultKey );

		return o;
	}
	function complObject( option, defaultVal )
	{
		if ( !$.isPlainObject( option ) )
		{
			option = defaultVal;
		}
		return option;
	}
	function complBoolean( option, defaultVal )
	{
		if ( typeof option != 'boolean' )
		{
			option = defaultVal;
		}
		return option;
	}
	function complNumber( option, defaultVal )
	{
		if ( !$.isNumeric( option ) )
		{
			option = defaultVal;
		}
		return option;
	}
	function complString( option, defaultVal )
	{
		if ( typeof option != 'string' )
		{
			option = defaultVal;
		}
		return option;
	}

	function isPercentage( value )
	{
		return ( typeof value == 'string' && value.slice( -1 ) == '%' );
		{
			value = parseInt( value.slice( 0, -1 ) );
		}
		return !isNaN( value );
	}
	function getPercentage( value )
	{
		return parseInt( value.slice( 0, -1 ) );
	}

	var cls = function( cls )
	{
		return 'tos-' + cls;
	};
	var dta = function( dta )
	{
		return 'tos-' + dta;
	};
	var evt = function( evt )
	{
		return evt + '.tos';
	};


})( jQuery );