<?php 
declare(strict_types=1);

namespace BraftonVimeo;

class BraftonClient {

    public $d = "api.brafton.com";
    public $pb = "9UREC71R"; //Brafton public key
    public $pv = "3a66f24b-5306-46b1-ba74-bd21700e573c"; //Brafton private key
    public $videos  = array();

    public function __construct(){

    }

    /**
     * @return $videos array of brafton ids from live XML feed
     */
    public function getBraftonVideos(): array {

        $domain = preg_replace('/https:\/\//','',"api.brafton.com");
        $baseURL = 'http://livevideo.'.str_replace('http://', '',$domain).'/v2/';      
        $client = new \AdferoClient($baseURL, $this->pb, $this->pv);        
        $photos = $client->ArticlePhotos();
        $photoURI = 'http://'.str_replace('api', 'pictures',$domain).'/v2/';
        $photoClient = new \AdferoPhotoClient($photoURI);
        $feeds = $client->Feeds();
        $feedList = $feeds->ListFeeds(0,10);
        $articleClient=$client->Articles();

        //CHANGE FEED NUM HERE
        $articles = $articleClient->ListForFeed($feedList->items[0]->id,'live',0,100);
        $articles_imported = 0;
        $articles->items = array_reverse($articles->items);
        
        foreach($articles->items as $item){

            $article = $client->Articles()->Get($item->id);
            array_push($this->videos,array(
                        'brafton-id'=>$item->id,
                        'title'=>$article->fields['title']
            ));
        }
        return $this->videos;
    }
    /**
     * @param $brafton_id string
     * @return $path string,  url of video hosted on brafton server
     */
    public function getVideoSource($brafton_id){
        $domain = preg_replace('/https:\/\//','',"api.brafton.com");
        $baseURL = 'http://livevideo.'.str_replace('http://', '',$domain).'/v2/';
        $videoClient = new \AdferoVideoClient($baseURL, $this->pb, $this->pv);
        $videoOutClient = $videoClient->videoOutputs();
        $videoList=$videoOutClient->ListForArticle($brafton_id,0,10);
        $list=$videoList->items;
        foreach($list as $listItem){
            $output=$videoOutClient->Get($listItem->id);
            $type = $output->type;
            $path = $output->path;
            $resolution = $output->height;
            continue;
        }
        return $path;
    }
    /**
     * function not in use
     */
    public function getVideoTitle($client){
        
        var_dump($client);
    }
}