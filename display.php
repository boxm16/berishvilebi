<?php
include_once 'Controller/PersonController.php';
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>



        <button onclick="myFunction()">Scroll</button>


        <svg width="8800" height="8800">
       <!-- <circle id="myID" cx="1700" cy="65" r="60" stroke="black" stroke-width="3" fill="red" /> --> 
        <ellipse  id="myID"  cx="1700" cy="65" rx="80" ry="50"  style="fill:red;stroke:purple;stroke-width:2" />
        <text x='1700' y='45' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
        $firstName 
        </text>;
        <text x='1700' y='65' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
        $secondName      
        </text>"
        <path d="M1550 0 A50 50, 0, 0 0, 1850 0" stroke="black" stroke-width="1" fill="none"/>

        <ellipse cx="1500" cy="125" rx="80" ry="50"  style="fill:yellow;stroke:purple;stroke-width:2" />
        <text x='1500' y='105' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
        $firstName 
        </text>;
        <text x='1500' y='125' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
        $secondName      
        </text>"

        <ellipse cx="1900" cy="125" rx="80" ry="50"  style="fill:yellow;stroke:purple;stroke-width:2" />

        <path d="M1350 0 A50 40, 0, 0 0, 2050 0" stroke="black" stroke-width="1" fill="none"/>

        </svg>

        <script>
            myFunction();
            function myFunction() {
                document.getElementById('myID').scrollIntoView({
                    behavior: 'auto',
                    block: 'center',
                    inline: 'center'
                });
            }
        </script>

    </body>
</html>