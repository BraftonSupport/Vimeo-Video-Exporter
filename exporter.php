<?php 

require_once 'RCClientLibrary/AdferoArticlesVideoExtensions/AdferoVideoClient.php';
require_once 'RCClientLibrary/AdferoArticles/AdferoClient.php';
require_once 'RCClientLibrary/AdferoPhotos/AdferoPhotoClient.php';

include './classes/BraftonClient.php';
include './classes/VimeoPost.php';

$brafton = new BraftonClient();
$list = $brafton->getBraftonVideos();
$vimeo = new VimeoPost('https://api.vimeo.com/users/92409741');
$group = $vimeo->checkVideos();
foreach($group as $video){
    echo '<br />'.$video->tags[0]->name;
}
var_dump($group);