<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">



    </head>
    <body>
        <div>laputa</div>

    <lable ></lable>


    <script>
        const div = document.querySelector('div')
        const {
            top: t,
            left: l
        } = div.getBoundingClientRect();
        const {
            scrollX,
            scrollY
        } = window
        const topPos = t + scrollX
        const leftPos = l + scrollY
        console.log(topPos, leftPos);
        document.querySelector('lable').innerHTML=topPos+'-'+leftPos;
    </script>
</body>
</html>
