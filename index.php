<?php
$PAGE_TITLE = "ohnx's blog";
$PAGE_TAGLINE = "ohnx's mini blog ^.^";
$PAGE_POSTSPERPAGE = 3;
$PAGE_FOOTERTEXT = "Thanks to Squirrel Host for hosting this site. You can check out their banner below:";
include 'Parsedown.php';
$Parsedown = new Parsedown();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $PAGE_TITLE; ?></title>
		<link href='/style.css' rel='stylesheet' type='text/css'>
	</head>
<body>
	<div class="container">
		<header>
			<h1 class="headertitle"><a href="/"><?php echo $PAGE_TITLE; ?></a></h1>
			<h3 class="headertitle"><?php echo $PAGE_TAGLINE; ?></h3>
			<hr />
		</header>
		<article>
<?php
$pageMode = "all";

if(isset($_REQUEST['mode'])) {
    $pageMode = $_REQUEST['mode'];
}

if($pageMode === "single") {
	$file = "posts/".$_REQUEST['name'].".txt";
	$filedelims = explode("-", $_REQUEST['name']);
	if(file_exists($file)) {
		$fileHandle = fopen($file, "r") or die("Unable to open file!");
		$dateObj   = DateTime::createFromFormat('!m', $filedelims[1]);
		$monthName = $dateObj->format('F');
		echo "<h1 class=\"article-title\">".$filedelims[3]."</h1>";
		echo "<h3 class=\"article-date\">Posted ".$monthName." ".$filedelims[2].", ".$filedelims[0]."</h3>\n";
		echo "<h3 class=\"article-date\">Last edited: " . date( 'F d Y, H:i:s', filemtime($file) ) . "</h3>\n";
		echo $Parsedown->text(fread($fileHandle,filesize($file)));
		fclose($fileHandle);
	} else {
		echo "<h1>Couldn't find a post like that</h1><p>Oops! A post with the filename <b>".$file."</b> couldn't be found. Maybe you'll have better luck with <a href=\"/\">the main index</a>?</p>\n";
	}
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

		for(;$i<$maxi;++$i) {
			if($i >= count($files)) {break;}
			$file       = $files[$i];
			$filedelims = explode("-", $file);
			$dateObj    = DateTime::createFromFormat('!m', $filedelims[1]);
			$monthName  = $dateObj->format('F');
			if($i != ($maxi - $PAGE_POSTSPERPAGE)) echo "<hr />\n";
			echo "<h1 class=\"article-title\"><a href=\"/post/".preg_replace('/\.[^.]+$/','',implode($filedelims, "/"))."\">".preg_replace('/\.[^.]+$/','',$filedelims[3])."</a></h1>";
			echo "<h3 class=\"article-date\">Posted ".$monthName." ".$filedelims[2].", ".$filedelims[0]."</h3>\n";
			echo "<h3 class=\"article-date\">Last edited " . date( 'F d Y, H:i:s', filemtime($file) ) . "</h3>\n";
			echo $Parsedown->text(file_get_contents($file));
			echo '</article><article>'
		}

	echo '<table class="page-nav"><tr><td class="page-nav-cell align-left">';
	if($maxi < count($files)) {
		echo "<a href=\"/page/" . ($pageNum+1). "\">Older</a>";
	}
	echo '</td><td class="page-nav-cell align-center">Page '.($pageNum+1).' of '.ceil(count($files)/$PAGE_POSTSPERPAGE).'</td><td class="page-nav-cell align-right">';
	if($pageNum > 0) {
		echo "<a href=\"/page/" . ($pageNum-1). "\">Newer</a>";
	}
	echo "</td></tr></table>";
}
?>
		</article>
		<footer>
			<hr />
			<?php echo $PAGE_FOOTERTEXT; ?>
		</footer>
	</div>
</script>
</body>
</html>
