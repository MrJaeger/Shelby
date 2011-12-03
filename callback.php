<?php
session_start();
?>
<html>
	<head>
		<title>Andrew's Shelby Ouath Test</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>
		<h1>OUATH TOKEN: <?= $_SESSION['oauth_token'] ?></h1>
		<h2>OAUTH SECRET TOKEN: <?= $_SESSION['oauth_token_secret'] ?></h2>
		<a href="./logout.php">Log Out</a>
	</body>
</html>