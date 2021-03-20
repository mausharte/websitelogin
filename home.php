<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Evan's Website</h1>
				<a href="profile.php">
				<a href="logout.php">
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome, <?=$_SESSION['name']?>.</p>
		</div>
	</body>
</html> 