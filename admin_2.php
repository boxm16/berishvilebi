
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Drag/Swipe To Scroll Example</title>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        *{ margin: 0; padding: 0 }
        body { background: #fafafa; }
        .container { margin: 150px auto; max-width: 960px; text-align: center; }
        .drag-box{
            width: 400px;
            height: 300px;
            margin: 20px auto;
            overflow: hidden;
            border: 3px dotted #222;
            background: #f8f8f8;
            line-height: 25px;
            font-size: 14px;
        }
        .drag{
            width: 150%;
            padding: 10px;
            cursor: grab;
            -moz-user-select:none;
            -webkit-user-select:none;
            -ms-user-select:none;
            -khtml-user-select:none;
            user-select:none;
        }
        .drag-x{
            width: 150%;
            padding: 10px;
            cursor: grab;
            -moz-user-select:none;
            -webkit-user-select:none;
            -ms-user-select:none;
            -khtml-user-select:none;
            user-select:none;
        }
        .drag-y{
            padding: 10px;
            cursor: grab;
            -moz-user-select:none;
            -webkit-user-select:none;
            -ms-user-select:none;
            -khtml-user-select:none;
            user-select:none;
        }
    </style>
</head>
<body><div id="jquery-script-menu">
<div class="jquery-script-center">
<ul>
<li><a href="https://www.jqueryscript.net/other/drag-swipe-scroll.html">Download This Plugin</a></li>
<li><a href="https://www.jqueryscript.net/">Back To jQueryScript.Net</a></li>
</ul>
<div class="jquery-script-ads"><script type="text/javascript"><!--
google_ad_client = "ca-pub-2783044520727903";
/* jQuery_demo */
google_ad_slot = "2780937993";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="https://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
<div class="jquery-script-clear"></div>
</div>
</div>
    <div class="container">
        <h1>Drag/Swipe To Scroll Example</h1>
    <div class="drag-box">
        <div class="drag"><img src="https://source.unsplash.com/ogLJ4BusYzE/1600x900"></div>
    </div>
<h2>direction: 'scrollLeft'</h2>
    <div class="drag-box">
        <div class="drag-x"><img src="https://source.unsplash.com/ExVr8jODhyo/1600x900"></div>
    </div>
<h2>direction: 'scrollTop'</h2>
    <div class="drag-box">
        <div class="drag-y"><img src="https://source.unsplash.com/wEy8TRGUuLY/1600x900"></div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="js/jquery.dragscroll.js"></script>
    <script type="text/javascript">
        $('.drag').dragScroll({
            onStart: function($this) {
                console.log($this);
            },
            onMove: function($this) {
                console.log($this);
            },
            onEnd: function($this) {
                console.log($this);
            }
        });
        // $('.drag').dragscroll('destroy');

        $('.drag-x').dragScroll({
            direction: 'scrollLeft'
        });
        $('.drag-y').dragScroll({
            direction: 'scrollTop'
        });
    </script>
    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
