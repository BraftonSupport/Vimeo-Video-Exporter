<?php 

require_once 'RCClientLibrary/AdferoArticlesVideoExtensions/AdferoVideoClient.php';
require_once 'RCClientLibrary/AdferoArticles/AdferoClient.php';
require_once 'RCClientLibrary/AdferoPhotos/AdferoPhotoClient.php';

include './classes/BraftonClient.php';

$brafton = new BraftonClient();
$list = $brafton->getBraftonVideos();
var_dump($list);