<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'username';
$DATABASE_PASS = 'password';
$DATABASE_NAME = 'database_name';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Cannot establish connection to MySQL: ' . mysqli_connect_error());
}
if (!isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['first_name'], $_POST['last_name'], $_POST['bio'], $_POST['favorite_number']) ) {
	exit('You must enter in all of your information before you can register.');
}
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['bio']) || empty($_POST['favorite_number']) ) {
	exit('You must enter in all of your information before you can register.');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Please enter a valid email address.');
}
if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
    exit('This username is not valid. A valid username must only contain uppercase letters, lowercase letters, and positive integers.');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('This password is not valid. A valid password must be between 5 and 20 characters long.');
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		echo 'This username is currently unavailable. Please enter a different username.';
	} 
	else {
		if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, first_name, last_name, bio, favorite_number) VALUES (?, ?, ?, ?, ?, ?, ?)')) {
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$stmt->bind_param('sssssss', $_POST['username'], $password, $_POST['email'], $_POST['first_name'], $_POST['last_name'], $_POST['bio'], $_POST['favorite_number']);
			$stmt->execute();
			echo 'You have successfully registered, you may now login with your username and password.<br><a href="index.html">Login</a>';
		} 
		else {
			echo 'Could not prepare statement.';
		}
	}
} 
else {

	echo 'Could not prepare statement.';
}
?>