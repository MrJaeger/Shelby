<!DOCTYPE html>
<html>
	<head>
		<title>Andrew's Shelby Ouath Test</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
		<h2>This is my attempt to Oauth with Shelby</h2>
		<?php if (isset($menu)) { ?>
        <?php echo $menu; ?>
      	<?php } ?>
      	<?php if (isset($status_text)) { ?>
      	<?php echo '<h3>'.$status_text.'</h3>'; ?>
   	    <?php } ?>
   	    <p>
     	  <pre>
      	     <a href="Oauth/redirect.php">Connect with Shelby</a>
     	  </pre>
    	</p>
    </body>
</html>