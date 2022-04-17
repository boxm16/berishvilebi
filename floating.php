<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            html {
                font-size: 200%;
            }
            #target, #target2 , #target3{
                background: #ccc;
            }
            .circle {
                height: 5vh;
                width: 5vw;
                border-radius: 50%;
                background-color: blue;
            }
        </style>
    </head>
    <body style="width:1000px">
        <div id="anchor">A</div>
        <div class="circle"></div>
        <p>Etiam porta sem malesuada magna mollis euismod. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Sed posuere consectetur est at lobortis. Donec id elit non mi porta gravida at eget metus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.</p><p>Etiam porta sem malesuada magna mollis euismod. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Sed posuere consectetur est at lobortis. Donec id elit non mi porta gravida at eget metus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.</p><p>Etiam porta sem malesuada magna mollis euismod. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Sed posuere consectetur est at lobortis. Donec id elit non mi porta gravida at eget metus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.</p>

        <p id="target">Target element</p>
        <p id="target2">Target 2 element</p>

        <p>Etiam porta sem malesuada magna mollis euismod. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Sed posuere consectetur est at lobortis. Donec id elit non mi porta gravida at eget metus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.</p><p>Etiam porta sem malesuada magna mollis euismod. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Sed posuere consectetur est at lobortis. Donec id elit non mi porta gravida at eget metus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.</p><p>Etiam porta sem malesuada magna mollis euismod. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Sed posuere consectetur est at lobortis. Donec id elit non mi porta gravida at eget metus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.</p>
        <p id="target3">Target 3 element</p>
        <script>
            var viewportHeight = window.innerHeight;
            var viewportWidth = window.innerWidth;

            let myCircle = document.querySelector('.circle');
            var anchorDistanceFromTopAtStart;
            var anchorDistanceFromLeftAtStart;
            window.addEventListener('load', () => {
                let anchor = document.getElementById('anchor');
                var anchorRect = anchor.getBoundingClientRect();
                anchorDistanceFromTopAtStart = anchorRect.top;
                anchorDistanceFromLeftAtStart = anchorRect.left;




                myCircle.style.position = 'absolute';
                myCircle.style.left = 0;
                myCircle.style.top = 0;
            });



// Set event listener for window resize
            window.addEventListener('resize', () => {
                checkTargetPosition();
            });
// Set event listener for device orientation change
            window.addEventListener('orientationchange', () => {
                checkTargetPosition();
            });

            var checkTargetPosition = () => {
                viewportHeight = window.innerHeight;
                viewportWidth = window.innerWidth;
                // get bounding client rect from element
                var element = document.getElementById('target')
                var rect = element.getBoundingClientRect();
                // grab measurements and percentage conversion
                var fromTop = rect.top;
                var fromLeft = rect.left;
                var fraction = rect.top / viewportHeight;
                var percentage = fraction * 100;
                //      console.log('target scroll:', fromTop, 'px from top.', fraction, '/', percentage, '%');
                document.getElementById('target').innerHTML = 'target scroll:' + fromTop + 'px from top.';
                document.getElementById('target2').innerHTML = 'target scroll:' + fromLeft + 'px from left.';
                var targetElement = document.getElementById('target3');
                targetElement.style.top = '500';


                let anchor = document.getElementById('anchor');
                var anchorRect = anchor.getBoundingClientRect();
                var anchorDistanceFromTop = anchorRect.top;
                var anchorDistanceFromLeft = anchorRect.left;


                myCircle.style.top = fromTop + 'px';
            }

// Listen for scroll event and check position
            window.addEventListener('scroll', () => {
                checkTargetPosition();
            });

        </script>
    </body>
</html>