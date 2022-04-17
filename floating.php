<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">



    </head>
    <body>
        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>



        a<br/>

        a<br/>

        a<br/>


        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>
        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>

        a<br/>




        <div id="apa" style="position:absolute">apa!</div>




        <script>
            var mesr =
                    {
                        Metrics: {
                            px: 1,
                            measureUnits: function (target) {
                                if (typeof (target) == 'undefined')
                                    target = document.getElementsByTagName('body')[0];
                                mesr.Metrics.measureUnit("em", target);
                                mesr.Metrics.measureUnit("pt", target);
                                mesr.Metrics.measureUnit("%", target);
                            },
                            measureUnit: function (unit, target) {
                                if (typeof (target.Metrics) == 'undefined')
                                    target.Metrics = {};
                                var measureTarget = target;
                                if (target.tagName == 'IMG' && typeof (target.parentNode) != 'undefined')
                                    measureTarget = target.parentNode;
                                var measureElement = document.createElement("div");
                                measureElement.style.width = "1" + unit;
                                measureElement.style.cssFloat = "left";
                                measureElement.style.styleFloat = "left";
                                measureElement.style.margin = "0px";
                                measureElement.style.padding = "0px";
                                measureTarget.appendChild(measureElement);
                                target.Metrics[unit] = measureElement.offsetWidth;
                                measureElement.parentNode.removeChild(measureElement);
                                return target.Metrics[unit];
                            },
                            getUnitPixels: function (unitString, target) {
                                if (typeof (target) == 'undefined')
                                    target = document.getElementsByTagName('body')[0];
                                if (typeof (target.Metrics) == 'undefined')
                                    mesr.Metrics.measureUnits(target);
                                var unit = unitString.replace(/[0-9\s]+/ig, '').toLowerCase();
                                var size = Number(unitString.replace(/[^0-9]+/ig, ''));
                                if (typeof (target.Metrics[unit]) == 'undefined')
                                    return 0;
                                var metricSize = target.Metrics[unit];
                                var pixels = Math.floor(Number(metricSize * size));
                                return pixels;
                            }
                        },
                        getElementOffset: function (target) {
                            var pos = [target.offsetLeft, target.offsetTop];
                            if (target.offsetParent != null) {
                                var offsetPos = mesr.getElementOffset(target.offsetParent);
                                pos = [
                                    pos[0] + offsetPos[0],
                                    pos[1] + offsetPos[1]
                                ];
                            }
                            return pos;
                        },
                        getElementPosition: function (target) {

                            var offset = mesr.getElementOffset(target);
                            var x = offset[0] +
                                    mesr.Metrics.getUnitPixels(target.style.paddingLeft, target) +
                                    mesr.Metrics.getUnitPixels(target.style.borderLeftWidth, target);
                            var y = offset[1] +
                                    mesr.Metrics.getUnitPixels(target.style.paddingTop, target) +
                                    mesr.Metrics.getUnitPixels(target.style.borderTopWidth, target);
                            return [x, y];
                        },
                        getElementSize: function (target) {
                            var size = [target.offsetWidth, target.offsetHeight];
                            size[0] -= mesr.Metrics.getUnitPixels(target.style.paddingLeft, target) +
                                    mesr.Metrics.getUnitPixels(target.style.paddingRight, target) +
                                    mesr.Metrics.getUnitPixels(target.style.borderLeftWidth, target) +
                                    mesr.Metrics.getUnitPixels(target.style.borderRightWidth, target);
                            size[1] -= mesr.Metrics.getUnitPixels(target.style.paddingTop, target) +
                                    mesr.Metrics.getUnitPixels(target.style.paddingBottom, target) +
                                    mesr.Metrics.getUnitPixels(target.style.borderTopWidth, target) +
                                    mesr.Metrics.getUnitPixels(target.style.borderBottomWidth, target);
                            return size;
                        },
                        getViewPortSize: function () {
                            var myWidth = 0, myHeight = 0;
                            if (typeof (window.innerWidth) == 'number') {
                                myWidth = window.innerWidth;
                                myHeight = window.innerHeight;
                            } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
                                myWidth = document.documentElement.clientWidth;
                                myHeight = document.documentElement.clientHeight;
                            } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
                                myWidth = document.body.clientWidth;
                                myHeight = document.body.clientHeight;
                            }
                            return [myWidth, myHeight];
                        },
                        getViewPortScrollPosition: function () {
                            var scrOfX = 0, scrOfY = 0;
                            if (typeof (window.pageYOffset) == 'number') {
                                scrOfY = window.pageYOffset;
                                scrOfX = window.pageXOffset;
                            } else if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
                                scrOfY = document.body.scrollTop;
                                scrOfX = document.body.scrollLeft;
                            } else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
                                scrOfY = document.documentElement.scrollTop;
                                scrOfX = document.documentElement.scrollLeft;
                            }
                            return [scrOfX, scrOfY];
                        },
                        attachEvent: function (target, eventList, func) {
                            if (typeof (target) == "undefined" || target == null)
                                return;
                            var events = eventList.split(",");
                            for (var i = 0; i < events.length; i++) {
                                var event = events[i];
                                if (typeof (target.addEventListener) != 'undefined') {
                                    target.addEventListener(event, func);
                                } else if (typeof (target.attachEvent) != 'undefined') {
                                    target.attachEvent('on' + event, func);
                                } else {
                                    console.log("unable to attach event listener");
                                }
                            }
                        }
                    }

            function position() {
                var viewPortSize = mesr.getViewPortSize();
                var viewPortScrollPos = mesr.getViewPortScrollPosition();
                var size = mesr.getElementSize(document.getElementById('apa'));
                document.getElementById('apa').style.left = Math.floor((viewPortSize[0] / 2) - (size[0] / 2) + viewPortScrollPos[0]) + "px";
                document.getElementById('apa').style.top = Math.floor((viewPortSize[1] / 2) - (size[1] / 2) + viewPortScrollPos[1]) + "px";
            }

            mesr.attachEvent(window, "resize,scroll,load", position);
            mesr.attachEvent(document, "load", position);



        </script>
    </body>
</html>
