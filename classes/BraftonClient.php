<?php 

class BraftonClient {

    public $d = "api.brafton.com";
    public $pb = "-----------";
    public $pv = "---------------------";

    public function __construct(){

    }


    public function getBraftonVideos() {

        $domain = preg_replace('/https:\/\//','',"api.brafton.com");
        echo '<br />'.$domain;
        $baseURL = 'http://livevideo.'.str_replace('http://', '',$domain).'/v2/';
        echo '<br />'.$baseURL;
        //die();
        $videoClient = new AdferoVideoClient($baseURL, $this->pb, $this->pv);
        $client = new AdferoClient($baseURL, $this->pb, $this->pv);
        $videoOutClient = $videoClient->videoOutputs();

        $photos = $client->ArticlePhotos();
        $photoURI = 'http://'.str_replace('api', 'pictures',$domain).'/v2/';
        $photoClient = new AdferoPhotoClient($photoURI);
        $feeds = $client->Feeds();
        $feedList = $feeds->ListFeeds(0,10);

        $articleClient=$client->Articles();

        //CHANGE FEED NUM HERE
        $articles = $articleClient->ListForFeed($feedList->items[0]->id,'live',0,100);
        $articles_imported = 0;
        $articles->items = array_reverse($articles->items);
        return $articles->items;
    }
}