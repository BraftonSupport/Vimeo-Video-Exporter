<?php 
declare(strict_types=1);

require_once 'RCClientLibrary/AdferoArticlesVideoExtensions/AdferoVideoClient.php';
require_once 'RCClientLibrary/AdferoArticles/AdferoClient.php';
require_once 'RCClientLibrary/AdferoPhotos/AdferoPhotoClient.php';

spl_autoload_register(function ($class_name) {
    include 'classes/'.$class_name .'.php';
});

define('VIMEO_TOKEN','XXXXXXX');

$brafton = new BraftonClient();
$list = $brafton->getBraftonVideos();
$pushOptions = new VimeoOptions();

$vimeo = new VimeoPost('https://api.vimeo.com/users/92409741',VIMEO_TOKEN);
$group = $vimeo->checkVideos();
$braftonIds = array();
foreach($group as $video){
    if(sizeOf($video->tags)>0){
        array_push($braftonIds,$video->tags[0]->name);
    }    
}


foreach($list as $a){
    if(in_array($a['brafton-id'],$braftonIds)){
        echo 'video '.$a['brafton-id'].' already exists';
    } else{
        $obj = array(
            "upload"=> array(
                "approach"=>"pull",
                "link"=> $brafton->getVideoSource($a['brafton-id'])
            ),
            "name"=> $a['title']
        );
        $vimeo->postVideo(json_encode($obj),$a['brafton-id']);
        die();
    }
}