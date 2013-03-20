<?php 

require 'facebook/facebook.php';

$app_id = "551406854880927";
$app_secret = "13e35a0667d10fa5af7ec8db822304fe";
$facebook = new Facebook(array(
    'appId' => $app_id,
    'secret' => $app_secret,
    'cookie' => true
));
 

$signed_request = $facebook->getSignedRequest();
$user = $facebook->getUser();

?>

<!DOCTYPE html>
<html style="overflow: hidden" class="no-js">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>TESZT</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        
        <style>
            
            .container {
                width: 800px;
                margin: 0 auto;
            }
            
        </style>
    </head>
    <body>
        
        <div class="container">
            <div id="fb-root"></div>
            <script>
                window.fbAsyncInit =function(){
                    FB.init({
                        appId  :'551406854880927',
                        status :true,// check login status
                        cookie :true,// enable cookies to allow the server to access the session
                        xfbml  :true  // parse XFBML
                    });
                    FB.Canvas.setSize();
                };

                (function(){
                    var e = document.createElement('script');
                    e.src = document.location.protocol +'//connect.facebook.net/hu_HU/all.js';
                    e.async =true;
                    document.getElementById('fb-root').appendChild(e);
                }());



            </script>

            <?php if($user): ?>
            
                <?php 
                
                $fb_user_profile = $facebook->api('/1204770767');
                // print_r($fb_user_profile);
                $access_token = $facebook->getAccessToken();
                echo "Rövid acccess token:";
                echo '<br />';
                echo $access_token;
                echo '<br />';
                echo '<br />';

                // meghosszabítva
                $extend_url = "https://graph.facebook.com/oauth/access_token?client_id=551406854880927&client_secret=13e35a0667d10fa5af7ec8db822304fe&grant_type=fb_exchange_token&fb_exchange_token=$access_token";
                $resp = file_get_contents($extend_url);
                parse_str($resp,$output);
                $extended_token = $output['access_token'];
                echo 'Meghosszabítva:';
                echo '<br />';
                echo $extended_token;
                echo '<br />';
                echo '<br />';
                
                ?>

                <?php 
                
                $ret_obj = $facebook->api('/me/feed', 'POST',
                array(
                  'access_token' => $extended_token,
                  'link' => 'http://test.hu',
                  'message' => 'Ismét tesztelek, juhúúúú! Ádámmal írtam.'
                ));
                ?>

            <?php else: ?>

                <?php $loginUrl = $facebook->getLoginUrl(array('scope' => 'publish_stream, email, offline_access','redirect_uri' => 'http://www.facebook.com/pages/Brandlift-Teszt/201768299840670?id=201768299840670&sk=app_551406854880927')); ?>
                <a id="login-btn" href="<?php echo $loginUrl ?>">Login</a>

            <?php endif; ?>
            
        </div>
    </body>
</html>