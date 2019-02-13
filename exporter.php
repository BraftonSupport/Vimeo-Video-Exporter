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
$braftonIds = array();
foreach($group as $video){
    if(sizeOf($video->tags)>0){
        //echo '<br />'.$video->tags[0]->name;
        array_push($braftonIds,$video->tags[0]->name);
    }    
}
var_dump($list[0]->id);
foreach($list as $item){
    if(in_array($item->id,$braftonIds)){
        echo 'video '.$item->id.' already exists';
    }
}