<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" >
        
        <title><?=TITLE?>!</title>
        <!-- General meta -->
        <meta name="description" content="<?=SHARE_TXT?>">
        <meta name="keywords" content="<?=KEYWORDS?>">
        <link type="text/plain" rel="author" href="humans.txt" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=no"/>
        <meta http-equiv="x-ua-compatible" content="IE=edge" />
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="msapplication-tap-highlight" content="no"/>

        <!-- OG Facebook -->
        <meta property="og:title" content="<?=TITLE?>">
        <meta property="og:url" content="<?=$server_url?>">
        <meta property="og:site_name" content="<?=TITLE?>">
        <meta property="og:description" content="<?=SHARE_TXT?>">
        <meta property="og:image" content="<?=$server_url?>img/facebook.jpg">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="200">
        <meta property="og:image:height" content="200">
        <meta property="og:type" content="website">

        <!-- Google+ Metadata /-->
        <meta itemprop="name" content="<?=TITLE?>">
        <meta itemprop="description" content="<?=SHARE_TXT?>">
        <meta itemprop="image" content="<?=$server_url?>img/facebook.jpg">

         <!-- Draugiem Metadata /-->
        <meta name="dr:say:img" content="<?=$server_url?>img/facebook.jpg" />
        <meta name="dr:say:title" content="<?=SHARE_TXT?>" />


        <link rel="shortcut icon" href="/favicon/favicon.ico">
        <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-touch-icon-152x152.png">
        <link rel="icon" type="image/png" href="/favicon/favicon-196x196.png" sizes="196x196">
        <link rel="icon" type="image/png" href="/favicon/favicon-160x160.png" sizes="160x160">
        <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="/favicon/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="/favicon/favicon-32x32.png" sizes="32x32">
        <meta name="msapplication-TileColor" content="#63625f">
        <meta name="msapplication-TileImage" content="/favicon/mstile-144x144.png">
        <meta name="msapplication-config" content="/favicon/browserconfig.xml">
        <!-- GENERATED http://realfavicongenerator.net -->


        <!-- build:css /styles/vendor.css -->
        <!-- bower:css -->
        <!-- endbower -->
        <!-- endbuild -->

        <!-- build:css(.tmp) /styles/main.css -->
        <link rel="stylesheet" href="/styles/main.css">
        <!-- endbuild -->

        <!-- build:js /scripts/vendor/modernizr.js -->
        <script src="/../bower_components/modernizr/modernizr.js"></script>
        <!-- endbuild -->

    </head>
    <body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
     js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=801883376497329&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
        <!--[if lt IE 10]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->


        <div class="hero-unit">
          <div class="logo"></div>
          <h1>Ullasoc</h1>
          <p>You now have</p>
          <ul>
            <li>HTML5 Boilerplate</li>
            <li>Sass</li>
            <li>Modernizr</li>
            <li><a href="/login-facebook.php">Facebook</a>  </li>
            <li><a href="/login-twitter.php">Twitter</a>    </li>
            <li><a href="/login-draugiem.php">Draugiem</a>  </li>
          </ul>
        </div>


<div class="modal" id="warning">
    <div class="content">
        <a class="close switch" modal-trigger="|#warning"><button title="Aizvērt" type="button" class="mfp-close">×</button></a>
      
        <div class="text-center">
            <h3>Ai Ai Ai</h3>
            <p>Lai apskatītu šo lapu, lūdzu, atjauno pārlūkprogrammas versiju uz jaunāku!</p>
            <div class="browsers">
                <a href="http://www.mozilla.org/en-US/firefox/new/" class="browser_ico" target="_blank" ><img src="/images/ff.png" alt=""></a>
                <a href="https://www.google.com/intl/en/chrome/browser/" class="browser_ico" target="_blank" ><img src="/images/chrome.png" alt=""></a>
                <a href="http://support.apple.com/downloads/#safari" target="_blank" class="browser_ico"><img src="/images/safari.png" alt=""></a>
            </div>
        </div>
    
    </div>
</div>


        <script type="text/javascript">
            <?=($_SESSION["id"]?'var session = '.$_SESSION["id"].';':"")?>

             if (!console) console = {
                 log: function () {}
             };


             function DraugiemSay(url) {
                var titlePrefix = encodeURIComponent('<?=SHARE_TXT?>');
                 window.open('http://www.draugiem.lv/say/ext/add.php?title=' + encodeURIComponent('<?=TITLE?>') + '&link=' + encodeURIComponent(url) + (titlePrefix ? '&titlePrefix=' + titlePrefix : ''), '', 'location=1,status=1,scrollbars=0,resizable=0,width=530,height=400');
                 return false;
             }

             function Fb(url) {
                 var width = 575,
                     height = 400,
                     left = ($(window).width() - width) / 2,
                     top = ($(window).height() - height) / 2,
                     url = "http://www.facebook.com/sharer.php?s=100&p[title]="+encodeURIComponent('<?=TITLE?>')+"&p[url]=" + url + "&p[images[]=<?=$server_url?>images/facebook.png";
                   var  opts = 'status=1' + ',width=' + width + ',height=' + height + ',top=' + top + ',left=' + left;
                 window.open(url, 'facebook', opts);
             }

             function Tw(url) {
                 var width = 575,
                     height = 400,
                     left = ($(window).width() - width) / 2,
                     top = ($(window).height() - height) / 2,
                     url = "http://twitter.com/share?url=" + url + "&text="+encodeURIComponent('<?=SHARE_TXT?>');
                    var opts = 'status=1' + ',width=' + width + ',height=' + height + ',top=' + top + ',left=' + left;
                     window.open(url, 'twitter', opts);
             }
        </script>


        <!-- build:js /scripts/vendor.js -->
        <!-- bower:js -->
        <script src="/../bower_components/jquery/dist/jquery.js"></script>
        <!-- endbower -->
        <!-- endbuild -->

        <script type="text/javascript">var _gaq=_gaq||[];
        _gaq.push(['_setAccount','<?=GOOGLE?>']);
        _gaq.push(['_trackPageview']);
        (function(){var ga=document.createElement('script');ga.type='text/javascript';ga.async =true;ga.src=('https:'==document.location.protocol?'https://ssl':'http://www')+'.google-analytics.com/ga.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(ga,s);})();
        </script>

        <!-- build:js({_dev,.tmp}) /scripts/main.js -->
        <script src="/scripts/main.js"></script>
        <!-- endbuild -->


        <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
        chromium.org/developers/how-tos/chrome-frame-getting-started -->
        <!--[if lt IE 7 ]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
        <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
        <![endif]-->
</body>
</html>
