<?php
if (file_exists("settings.php")) {
	//header("Location: /admin.php");
	echo 'Please go to the <a href="/admin.php">Admin page</a> to set up easypage.';
	//die();
}
require 'settings.php';
require 'Parsedown.php';

$PAGE_TITLE = "Balderdash";
$PAGE_TAGLINE = "senseless talk or writing; nonsense";
$PAGE_POSTSPERPAGE = 3;
$Parsedown = new Parsedown();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $PAGE_TITLE; ?></title>
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/styles/default.min.css">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>
		<link href='/style.css' rel='stylesheet' type='text/css'>
	</head>
<body>
	<aside>
		<h1 class="headertitle"><a href="/"><?php echo $PAGE_TITLE; ?></a></h1>
		<h3 class="headertitle"><?php echo $PAGE_TAGLINE; ?></h3>
		<p class="description">
			Mason's blog on everything, nothing, and all the things in between.
		</p>
	</aside>
	<section id="content">
<?php
$pageMode = "all";

if(isset($_REQUEST['mode'])) {
    $pageMode = $_REQUEST['mode'];
}

if($pageMode === "single") {
	echo '<article class="post">';
	$file = "posts/".$_REQUEST['name'].".txt";
	$filedelims = explode("-", $_REQUEST['name']);
	if(file_exists($file)) {
		$fileHandle = fopen($file, "r") or die("Unable to open file!");
		$dateObj   = DateTime::createFromFormat('!m', $filedelims[1]);
		$monthName = $dateObj->format('F');
		echo "<h1 class=\"article-title\">".$filedelims[3]."</h1>";
		echo "<div class=\"article-date\">Posted ".$monthName." ".$filedelims[2].", ".$filedelims[0]."</div>\n";
		echo "<div class=\"article-date\">Last edited " . date( 'F d Y, H:i:s', filemtime($file) ) . "</div>\n<div class=\"post-text\">";
		echo $Parsedown->text(fread($fileHandle,filesize($file)));
		fclose($fileHandle);
	} else {
		echo "<h1>Couldn't find a post like that</h1><p>Oops! A post with the filename <b>".$file."</b> couldn't be found. Maybe you'll have better luck with <a href=\"/\">the main index</a>?</p>\n<div>";
	}
	echo '</div><a href="javascript:void;" onclick="print();" class="printbtn">Print</a></article>';
} else {
	if(isset($_REQUEST['page'])) {
		$pageNum = $_REQUEST['page'];
	} else {
		$pageNum = 0;
	}
	$dir = 'posts/'; // Leave as blank for current

	if($dir) chdir($dir);
		$files = array_reverse(glob('*.txt'));

		$maxi = ($pageNum+1)*$PAGE_POSTSPERPAGE;
		$i = $pageNum*$PAGE_POSTSPERPAGE;
		$maxcount = count($files);
		
		for(;$i<$maxi;++$i) {
			if($i >= $maxcount) break;
			echo '<article class="post">';
			$file       = $files[$i];
			$filedelims = explode("-", $file);
			$dateObj    = DateTime::createFromFormat('!m', $filedelims[1]);
			$monthName  = $dateObj->format('F');
			echo "<h1 class=\"article-title\"><a href=\"/post/".preg_replace('/\.[^.]+$/','',implode($filedelims, "/"))."\">".preg_replace('/\.[^.]+$/','',$filedelims[3])."</a></h1>";
			echo "<div class=\"article-date\">Posted ".$monthName." ".$filedelims[2].", ".$filedelims[0]."</div>\n";
			echo "<div class=\"article-date\">Last edited " . date('F d Y, H:i:s', filemtime($file)) . "</div>\n<div class=\"post-text\">";
			echo $Parsedown->text(file_get_contents($file));
			echo '</div></article>';
		}
	echo '<footer>';
	if($pageNum > 0) {
		echo "<a href=\"/page/" . ($pageNum-1). "\" class=\"pagination-arrow newer\">Newer</a>";
	}
	echo '<div class="page-count">Page '.($pageNum+1).' of '.ceil(count($files)/$PAGE_POSTSPERPAGE).'</div>';
	if($maxi < count($files)) {
		echo "<a href=\"/page/" . ($pageNum+1). "\" class=\"pagination-arrow older\">Older</a>";
	}
	echo "</footer>";
}
?>

	</section>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/highlight.min.js"></script>
<script src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
<script>
	/* global hljs */
	hljs.initHighlightingOnLoad();
	function makePrintable() {
		window.print();
	}
</script>
</body>
</html>
