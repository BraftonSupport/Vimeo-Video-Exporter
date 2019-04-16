<?php
declare(strict_types=1);

class VimeoPost {
	public $videoPath;
	public $braftonId;
	public $userUri;
	private $token;

	public function __construct($uri,$token){
		$this->userUri = $uri;
		$this->token = $token;

	}

	/**
	 * @return string $token Vimeo authentication token
	 * 
	 */
	private function getToken() : string{
		return $this->token;
	}

	/**
     * Post Brafton video to Vimeo user account
     *
     * @param json $obj video data to be posted
     * 
     **/
	public function postVideo($obj,$id){
		$crl = curl_init();
		curl_setopt($crl, CURLOPT_URL, $this->buildPostUrl());
		curl_setopt($crl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($crl, CURLOPT_POSTFIELDS, $obj);                                                                                                        
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($crl, CURLOPT_HTTPHEADER, array(  
				'Authorization: Bearer '.$this->getToken(),                                                                       
			    'Content-Type: application/json',
			    'Accept: application/vnd.vimeo.*+json;version=3.4'
			)                                                                                                                                
		);
		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, true);     
		$result = curl_exec($crl);
		$decoded = json_decode($result);
		$this->videoPath = $decoded->uri;
		$this->addTag($id);
	}

	/**
     * Add brafton id as a tag to newly created Vimeo video
     * @param $id string
     **/
	public function addTag($id){
		$crl = curl_init();
		curl_setopt($crl, CURLOPT_URL, $this->buildTagUrl($id) );
		curl_setopt($crl, CURLOPT_CUSTOMREQUEST, "PUT");                                                                                                       
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($crl, CURLOPT_HTTPHEADER, array(  
				'Authorization: Bearer '.$this->getToken(),                                                                       
			    'Content-Type: application/json',
			    'Accept: application/vnd.vimeo.*+json;version=3.4'
			)                                                                                                                                
		);
		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, true);     
		$result = curl_exec($crl);
	}
	/**
     * Retrieve list of user's videos and search for brafton id in tag list
     * @return $test boolean 
     **/
	public function checkVideos(){
		$crl = curl_init();
		curl_setopt($crl, CURLOPT_URL, $this->buildPostUrl());
		curl_setopt($crl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($crl, CURLOPT_HTTPHEADER, array(  
				'Authorization: Bearer '.$this->getToken(),                                                                       
			    'Content-Type: application/json',
			    'Accept: application/vnd.vimeo.*+json;version=3.4'
			)                                                                                                                                
		);
		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, true);     
		$result = curl_exec($crl);
		$fixed = json_decode($result);
		$videos = $fixed->data;
		return $videos;
	}

	/**
     * Build url endpoint for posting a video to a particular Vimeo user account
     *
     * @param string $link users home url /users/xxxxxx/
     * @return string /users/xxxxxx/videos
     **/
	public function buildPostUrl(){
		return $this->userUri.'/videos';
	}

	/**
     * Build url endpoint for adding a tag to an existing video 
     *
     * @param string $userId users account id 
     * @return string /videos/{video-id}/tags/{string}
     **/
	public function buildTagUrl($id){
		echo $this->videoPath.'/tags/'.$id;
		return 'https://api.vimeo.com'.$this->videoPath.'/tags/'.$id;
	}

}
