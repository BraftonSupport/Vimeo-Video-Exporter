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
        array_push($braftonIds,$video->tags[0]->name);
    }    
}


foreach($list as $a){
    if(in_array($a['brafton-id'],$braftonIds)){
        echo 'video '.$a['brafton-id'].' already exists';
    } else{
        //echo '<br />'.$a['brafton-id']. $a['title'].$brafton->getVideoSource($a['brafton-id']);
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