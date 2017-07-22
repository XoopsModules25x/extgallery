<div class="rex-addon-output">
    <h2 class="rex-hl2"><?php echo $I18N->msg('magnific_popup_start_headline'); ?></h2>
    <div class="rex-area-content">
        <div id="logo">
            <canvas id="broken-glass"></canvas>
            <h1 id="logo-title"><?php echo $I18N->msg('magnific_popup_start_magnific_popup'); ?></h1>
        </div>
        <br>
        <ul>
            <li><a class="extern" target="_blank" href="http://dimsemenov.com/plugins/magnific-popup/documentation.html"><?php echo $I18N->msg('magnific_popup_start_docs'); ?></a></li>
            <li><a class="extern" target="_blank" href="http://dimsemenov.com/plugins/magnific-popup/"><?php echo $I18N->msg('magnific_popup_start_homepage'); ?></a></li>
            <li><?php echo $I18N->msg('magnific_popup_start_examples1'); ?> <a class="extern" target="_blank" href="http://codepen.io/collection/nLcqo"><?php echo $I18N->msg('magnific_popup_start_examples2'); ?></a></li>
        </ul>
    </div>
</div>

<style type="text/css">
    #logo {
        cursor: pointer;
        text-align: center;
        margin-top: 30px;
    }

    #logo h1 {
        -moz-user-select: none;
        cursor: pointer;
        font-weight: 700;
        left: 0;
        position: absolute;
        text-align: center;
        width: 100%;
        font-family: Calibri, "PT Sans", "Trebuchet MS", 'Helvetica Neue', Arial, sans-serif;
        margin: 0;
        text-rendering: optimizelegibility;
        font-size: 49px;
        line-height: 1.4;
        margin-top: 111px;
        top: 0;
    }
</style>

<script type="text/javascript">
    (function () {

        var isCanvasSupported = function () {
            var elem = document.createElement('canvas');

            return !!(elem.getContext && elem.getContext('2d'));
        };

        if (isCanvasSupported()) {

            var canvas = document.getElementById('broken-glass'),
                context = canvas.getContext('2d'),
                width = canvas.width = Math.min(600, window.innerWidth),
                height = canvas.height,
                numTriangles = 100,
                rand = function (min, max) {
                    return Math.floor((Math.random() * (max - min + 1) ) + min);
                };

            window.drawTriangles = function () {
                context.clearRect(0, 0, width, height);
                var hue = rand(0, 360);
                var increment = 80 / numTriangles;
                for (var i = 0; i < numTriangles; i++) {
                    context.beginPath();
                    context.moveTo(rand(0, width), rand(0, height));
                    context.lineTo(rand(0, width), rand(0, height));
                    context.lineTo(rand(0, width), rand(0, height));
                    context.globalAlpha = 0.5;
                    context.fillStyle = 'hsl(' + Math.round(hue) + ', ' + rand(15, 60) + '%, ' + rand(10, 60) + '%)';
                    context.closePath();
                    context.fill();

                    hue += increment;
                    if (hue > 360) hue = 0;
                }
                canvas.style.cssText = '-webkit-filter: contrast(115%);';
            };

            document.getElementById('logo-title').style.color = 'rgba(250, 250, 250, 0.95)';
            drawTriangles();

            var el = document.getElementById('logo');
            el.onclick = function () {
                drawTriangles();
            };
        }

    })();
</script>
