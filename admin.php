<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>easypage admin</title>
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/styles/default.min.css">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>
		<link href='/style.css' rel='stylesheet' type='text/css'>
	</head>
<body>
<?php
if(isset($_GET['mode'])) {
	$mode = $_GET['mode'];
} else  {
	
}
if(file_exists('settings.php')) {
	require 'settings.php';
} else {
	$mode ='setup';
}
?>
    
    
</body>
</htl>