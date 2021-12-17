<!DOCTYPE html>
<html>

    <body>

        <h1>Draggable SVG Circle</h1>

        <p>Click and hold the mouse button down while moving the SVG Circle </p>


        <svg width="500" height="500">

        <circle id="myCircle" cx="50" cy="50" r="40" stroke="green" stroke-width="4" fill="yellow" />
        </svg>

        <script>

            //Make the DIV element draggagle:
           
            
            dragCirlce(document.getElementById("myCircle"));



            function dragCirlce(elmnt) {

                var mousePosStartX = 0, mousePosStartY = 0, mousePosEndX = 0, mousePosEndY = 0;
                var circlePosStartX = 0, circlePosStartY = 0, circlePosEndX = 0, circlePosEndY = 0;

                var diffPosX = 0, diffPosY = 0;

                elmnt.onmousedown = dragMouseDown;


                function dragMouseDown(e) {

                    e = e || window.event;
                    e.preventDefault();
                    // get the mouse cursor position at startup:
                    mousePosStartX = e.clientX;
                    mousePosStartY = e.clientY;
                    circlePosStartX = elmnt.getAttribute("cx");
                    circlePosStartY = elmnt.getAttribute("cy");
                    diffPosX = circlePosStartX - mousePosStartX;
                    diffPosY = circlePosStartY - mousePosStartY;

                    document.onmouseup = closeDragElement;
                    // call a function whenever the cursor moves:
                    document.onmousemove = elementDrag;
                }

                function elementDrag(e) {
                    e = e || window.event;
                    e.preventDefault();
                    // calculate the new cursor position:

                    mousePosEndX = e.clientX;
                    mousePosEndY = e.clientY;

                    circlePosEndX = mousePosEndX + diffPosX;
                    circlePosEndY = mousePosEndY + diffPosY;
                    // set the element's new position:
                    elmnt.setAttribute("cx", circlePosEndX);
                    elmnt.setAttribute("cy", circlePosEndY);

                }

                function closeDragElement() {
                    /* stop moving when mouse button is released:*/
                    document.onmouseup = null;
                    document.onmousemove = null;
                }
            }




        </script>

    </body>
</html>
