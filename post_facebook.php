<?php
  require_once("src/facebook.php");

	  $config = array();
	  $config['appId'] 		= '337775549681320';
	  $config['secret'] 	= '7e3b9213a42fbc447dfeb5ef914c7dd2';
	  $config['fileUpload'] = false; // optional

	  $facebook = new Facebook($config);

    $user_id = $facebook->getUser();
     if($user_id) {
    
          // We have a user ID, so probably a logged in user.
          // If not, we'll get an exception, which we handle below.
          try {
            $access_token = $facebook->getAccessToken();
            echo $access_token;
            $ret_obj = $facebook->api('/me/feed', 'POST',
              array(
                'name'          => 'Handshake',
                'link'          => 'http://handshake.dev/profile/n.t.hoang.phuong',
                'message'       => 'View my Awsome Resume here:',
                'picture'       => 'https://fbcdn-sphotos-h-a.akamaihd.net/hphotos-ak-prn1/155770_174518325901468_8020860_n.jpg',
                'caption'       => 'http://handshake.dev/profile/n.t.hoang.phuong',
                'description'   => 'This is Phuong Resume on HandShake website, Please check it 
                to get best profile, best persion for your company.',
                'access_token'  => $access_token
           ));
    
            // Give the user a logout link 
            echo '<br /><a href="' . $facebook->getLogoutUrl() . '">logout</a>';
          } catch(FacebookApiException $e) {
            // If the user is logged out, you can have a 
            // user ID even though the access token is invalid.
            // In this case, we'll get an exception, so we'll
            // just ask the user to login again here.
            $login_url = $facebook->getLoginUrl( array(
                           'scope' => 'publish_stream'
                           )); 
            echo 'Please <a href="' . $login_url . '">login.</a>';
            echo 'error type: ' . $e->getType();
            echo 'error message: ' . $e->getMessage();
            error_log($e->getType());
            error_log($e->getMessage());
          }   
        } else {
    
          // No user, so print a link for the user to login
          // To post to a user's wall, we need publish_stream permission
          // We'll use the current URL as the redirect_uri, so we don't
          // need to specify it here.
          $login_url = $facebook->getLoginUrl( array( 'scope' => 'publish_stream' ) );
          echo 'Please <a href="' . $login_url . '">login.</a>';
    
        } 
?>
