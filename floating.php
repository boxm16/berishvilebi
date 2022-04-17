<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <style>
            #sticky {
                padding: 0.5ex;
                width: 600px;
                background-color: #333;
                color: #fff;
                font-size: 2em;
                border-radius: 0.5ex;
            }

            #sticky.stick {
                margin-top: 0 !important;
                position: fixed;
                top: 0;
                z-index: 10000;
                border-radius: 0 0 0.5em 0.5em;
            }

            body {
                margin: 1em;
            }

            p {
                margin: 1em auto;
            }

        </style>
    </head>
    <body>
        <p>Made for my post: <a href="http://blog.yjl.im/2010/01/stick-div-at-top-after-scrolling.html">Stick div at top after scrolling</a>.</p>
        <p>
            <button onclick="autoscroll()">
                Auto-scroll
            </button>
        </p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque, lectus in pharetra blandit, augue mauris pulvinar erat, ut euismod nibh lectus sed diam. Nulla fringilla ultrices ligula. Aliquam vitae felis metus. Maecenas lacinia bibendum
            accumsan. Curabitur lobortis convallis purus non imperdiet. Morbi ut vulputate mauris. Curabitur lacinia faucibus volutpat. Nulla elit tortor, rhoncus ut luctus eget, blandit in risus. Integer accumsan ullamcorper lorem id porttitor. Aliquam vitae
            libero eget magna mollis gravida.
        </p>
        <div id="sticky-anchor"></div>
        <div id="sticky">This will stay at top of page</div>
        <p>Nunc eu sapien turpis. Proin non arcu orci, eget volutpat tellus. Maecenas tempor mattis risus, quis pellentesque eros imperdiet nec. Vestibulum porttitor, justo at ornare bibendum, magna lectus cursus felis, tristique consectetur arcu justo at augue.
            Mauris ultrices mollis sem eget elementum. Sed ipsum orci, tempus vel porttitor vel, tristique eu erat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis aliquam pulvinar nisl, vitae congue velit ultricies
            eget.
        </p>
        <p>Maecenas mollis arcu orci. Nam nec velit dolor, ut convallis augue. Morbi sed massa nunc. Vestibulum malesuada eros sed purus volutpat nec bibendum neque sodales. Nullam tincidunt quam sit amet lacus egestas vitae ultrices mauris porta. Duis vel neque
            ipsum. Vestibulum eu blandit ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec turpis leo, hendrerit quis elementum tincidunt, auctor ac augue. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis
            egestas.
        </p>
        <p>Sed in eleifend magna. Morbi faucibus eleifend nunc eu sagittis. Curabitur accumsan nulla in neque tempor eu lacinia elit consectetur. Nullam scelerisque ligula vitae nisi interdum pellentesque. Vivamus lobortis tempor pulvinar. Nunc sit amet nulla urna.
            Phasellus malesuada euismod lectus nec bibendum. Ut adipiscing dapibus ipsum nec iaculis. Donec quis dignissim tortor. Suspendisse molestie rhoncus enim hendrerit ultricies. Proin semper purus posuere urna porttitor suscipit.</p>
        <p>Curabitur odio dui, imperdiet sed sodales nec, aliquet id nisl. Mauris nec sapien nibh. Maecenas vel sem at felis posuere rutrum non non mauris. Maecenas at lectus ut ipsum iaculis lobortis. Vivamus ut porta nisi. Phasellus tempor accumsan urna eu faucibus.
            Duis sed ligula neque, pulvinar euismod velit. Donec tristique eros at dolor ornare sagittis. Vestibulum sodales imperdiet ante et tincidunt. Suspendisse malesuada tempor nisi ac accumsan. Pellentesque accumsan pulvinar odio, id adipiscing diam mollis
            eu. Nulla id mi rutrum elit rutrum ultrices. Maecenas viverra, est ut pellentesque ultricies, ligula nisi auctor tellus, vitae bibendum mi nunc non libero. Mauris in facilisis enim. Proin facilisis, risus et tempus accumsan, orci enim egestas arcu,
            sit amet sodales risus leo quis nisi.</p>
        <p>Nunc eu sapien turpis. Proin non arcu orci, eget volutpat tellus. Maecenas tempor mattis risus, quis pellentesque eros imperdiet nec. Vestibulum porttitor, justo at ornare bibendum, magna lectus cursus felis, tristique consectetur arcu justo at augue.
            Mauris ultrices mollis sem eget elementum. Sed ipsum orci, tempus vel porttitor vel, tristique eu erat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis aliquam pulvinar nisl, vitae congue velit ultricies
            eget.
        </p>
        <p>Maecenas mollis arcu orci. Nam nec velit dolor, ut convallis augue. Morbi sed massa nunc. Vestibulum malesuada eros sed purus volutpat nec bibendum neque sodales. Nullam tincidunt quam sit amet lacus egestas vitae ultrices mauris porta. Duis vel neque
            ipsum. Vestibulum eu blandit ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec turpis leo, hendrerit quis elementum tincidunt, auctor ac augue. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis
            egestas.
        </p>
        <p>Sed in eleifend magna. Morbi faucibus eleifend nunc eu sagittis. Curabitur accumsan nulla in neque tempor eu lacinia elit consectetur. Nullam scelerisque ligula vitae nisi interdum pellentesque. Vivamus lobortis tempor pulvinar. Nunc sit amet nulla urna.
            Phasellus malesuada euismod lectus nec bibendum. Ut adipiscing dapibus ipsum nec iaculis. Donec quis dignissim tortor. Suspendisse molestie rhoncus enim hendrerit ultricies. Proin semper purus posuere urna porttitor suscipit.</p>
        <p>Curabitur odio dui, imperdiet sed sodales nec, aliquet id nisl. Mauris nec sapien nibh. Maecenas vel sem at felis posuere rutrum non non mauris. Maecenas at lectus ut ipsum iaculis lobortis. Vivamus ut porta nisi. Phasellus tempor accumsan urna eu faucibus.
            Duis sed ligula neque, pulvinar euismod velit. Donec tristique eros at dolor ornare sagittis. Vestibulum sodales imperdiet ante et tincidunt. Suspendisse malesuada tempor nisi ac accumsan. Pellentesque accumsan pulvinar odio, id adipiscing diam mollis
            eu. Nulla id mi rutrum elit rutrum ultrices. Maecenas viverra, est ut pellentesque ultricies, ligula nisi auctor tellus, vitae bibendum mi nunc non libero. Mauris in facilisis enim. Proin facilisis, risus et tempus accumsan, orci enim egestas arcu,
            sit amet sodales risus leo quis nisi.</p>
        <p>Nunc eu sapien turpis. Proin non arcu orci, eget volutpat tellus. Maecenas tempor mattis risus, quis pellentesque eros imperdiet nec. Vestibulum porttitor, justo at ornare bibendum, magna lectus cursus felis, tristique consectetur arcu justo at augue.
            Mauris ultrices mollis sem eget elementum. Sed ipsum orci, tempus vel porttitor vel, tristique eu erat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis aliquam pulvinar nisl, vitae congue velit ultricies
            eget.
        </p>
        <p>Maecenas mollis arcu orci. Nam nec velit dolor, ut convallis augue. Morbi sed massa nunc. Vestibulum malesuada eros sed purus volutpat nec bibendum neque sodales. Nullam tincidunt quam sit amet lacus egestas vitae ultrices mauris porta. Duis vel neque
            ipsum. Vestibulum eu blandit ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec turpis leo, hendrerit quis elementum tincidunt, auctor ac augue. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis
            egestas.
        </p>
        <p>Sed in eleifend magna. Morbi faucibus eleifend nunc eu sagittis. Curabitur accumsan nulla in neque tempor eu lacinia elit consectetur. Nullam scelerisque ligula vitae nisi interdum pellentesque. Vivamus lobortis tempor pulvinar. Nunc sit amet nulla urna.
            Phasellus malesuada euismod lectus nec bibendum. Ut adipiscing dapibus ipsum nec iaculis. Donec quis dignissim tortor. Suspendisse molestie rhoncus enim hendrerit ultricies. Proin semper purus posuere urna porttitor suscipit.</p>
        <p>Curabitur odio dui, imperdiet sed sodales nec, aliquet id nisl. Mauris nec sapien nibh. Maecenas vel sem at felis posuere rutrum non non mauris. Maecenas at lectus ut ipsum iaculis lobortis. Vivamus ut porta nisi. Phasellus tempor accumsan urna eu faucibus.
            Duis sed ligula neque, pulvinar euismod velit. Donec tristique eros at dolor ornare sagittis. Vestibulum sodales imperdiet ante et tincidunt. Suspendisse malesuada tempor nisi ac accumsan. Pellentesque accumsan pulvinar odio, id adipiscing diam mollis
            eu. Nulla id mi rutrum elit rutrum ultrices. Maecenas viverra, est ut pellentesque ultricies, ligula nisi auctor tellus, vitae bibendum mi nunc non libero. Mauris in facilisis enim. Proin facilisis, risus et tempus accumsan, orci enim egestas arcu,
            sit amet sodales risus leo quis nisi.</p>

        <script>
            function sticky_relocate() {
                var window_top = $(window).scrollTop();
                var div_top = $('#sticky-anchor').offset().top;
                if (window_top > div_top) {
                    $('#sticky').addClass('stick');
                    $('#sticky-anchor').height($('#sticky').outerHeight());
                } else {
                    $('#sticky').removeClass('stick');
                    $('#sticky-anchor').height(0);
                }
            }

            $(function () {
                $(window).scroll(sticky_relocate);
                sticky_relocate();
            });

            var dir = 1;
            var MIN_TOP = 200;
            var MAX_TOP = 350;

            function autoscroll() {
                var window_top = $(window).scrollTop() + dir;
                if (window_top >= MAX_TOP) {
                    window_top = MAX_TOP;
                    dir = -1;
                } else if (window_top <= MIN_TOP) {
                    window_top = MIN_TOP;
                    dir = 1;
                }
                $(window).scrollTop(window_top);
                window.setTimeout(autoscroll, 100);
            }

        </script>
    </body>
</html>
