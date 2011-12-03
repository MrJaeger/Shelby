<?php
session_start();
if(isset($_SESSION['oauth_token']) && isset($_SESSION['oauth_token_secret'])) {
	header("Location: ./callback.php");
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Andrew's Shelby Ouath Test</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
		<h2>This is my attempt to Oauth with Shelby</h2>
		<?php print_r($_SESSION['oauth_token']) ?>
   	    <p>
     	  <pre>
      	     <a href="Oauth/redirect.php">Connect with Shelby</a>
     	  </pre>
    	</p>
    </body>
</html>