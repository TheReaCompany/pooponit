<?php
// Settings
define('TITLE','Overlay'); // Site Title
define('SUBDIR',''); // Path from document root, use leading slashes
define('PAGE_INDEX','http://'.$_SERVER['SERVER_NAME'].SUBDIR.'/index.php'); // URL to redirect people to index
define('PAGE_ERROR','http://'.$_SERVER['SERVER_NAME'].SUBDIR.'/error.php'); // URL to redirect people on error

$filename = basename(__FILE__,'.php');
$base_offset = strlen(SUBDIR.'/'.$filename.'/');

// Check URL
if (empty($_SERVER['REQUEST_URI']) || strlen($_SERVER['REQUEST_URI']) <= $base_offset) {
	header('Location: '.PAGE_INDEX);
	exit();
}

// Get URL
$url =  substr($_SERVER['REQUEST_URI'],$base_offset);
$url_parts = parse_url($url);
$url_parts['scheme'] = (empty($url_parts['scheme']))? 'http://' : $url_parts['scheme'].'://';
$url_parts['path'] = (empty($url_parts['path']))? '' : $url_parts['path'];
$url_parts['query'] = (empty($url_parts['query']))? '' : '?'.$url_parts['query'];

// Check host
if (empty($url_parts['host']) && empty($url_parts['path'])) {
	header('Location: '.PAGE_ERROR);
	exit();
}

// Reassemble target
$site = $url_parts['scheme'].$url_parts['host'].$url_parts['path'].$url_parts['query'];
?>
<!-- IE 7 Fix -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title><?=htmlentities(TITLE.' - '.$url_parts['host'].$url_parts['path']);?></title>
	<meta name="generator" content="BBEdit 9.3">
	<link rel="stylesheet" href="<?=SUBDIR;?>/css/overlay.css" type="text/css" media="all">
<!--[if lte IE 7]>
	<link rel="stylesheet" type="text/css" href="<?=SUBDIR;?>/css/ie.css" media="all">
<![endif]-->
</head>
<body>
	<div id="overlay"></div>
	<div id="body">
		<iframe src="<?=$site;?>"></iframe>
	</div>
	<div id="footer">
		<p>Copyright goes here. <a href="<?=$site;?>" title="Click to remove frame">Remove Frame</a></p>
	</div>
</body>
</html>