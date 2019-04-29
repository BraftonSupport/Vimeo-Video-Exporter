<?php 
/* extendable base class for all client exporters */

abstract class MasterExporter{

    public function __construct(){
        $this->commence();
    }

    public function commence(){
        $brafton = new \BraftonVimeo\BraftonClient();
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
        //determine whether or not to port video from feed to Vimeo by checking the tag and comparing it to brafton id
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
    }
}