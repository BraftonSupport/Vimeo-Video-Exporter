<?php

namespace Brafton\Vimeo;

class VimeoPost {
	public $videoPath;
	public $braftonId;
	public $userUri;

	public function __construct($id,$uri){
		$this->braftonId = $id;
		$this->userUri = $uri;
	}

	/**
     * Post Brafton video to Vimeo user account
     *
     * @param json $obj video data to be posted
     * 
     **/
	public function postVideo($obj){
		$crl = curl_init();
		curl_setopt($crl, CURLOPT_URL, $this->buildPostUrl());
		curl_setopt($crl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($crl, CURLOPT_POSTFIELDS, $obj);                                                                                                        
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($crl, CURLOPT_HTTPHEADER, array(  
				'Authorization: Bearer 3dcd1068806e597d1cbce38dd50106c7',                                                                       
			    'Content-Type: application/json',
			    'Accept: application/vnd.vimeo.*+json;version=3.4'
			)                                                                                                                                
		);
		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, true);     
		$result = curl_exec($crl);
		$this->videoPath = $result->uri;
		$this->addTag();
	}

	/**
     * Add brafton id as a tag to newly created Vimeo video
     * 
     **/
	public function addTag(){
		$crl = curl_init();
		curl_setopt($crl, CURLOPT_URL, $this->buildTagUrl() );
		curl_setopt($crl, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($crl, CURLOPT_POSTFIELDS, $obj);                                                                                                        
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($crl, CURLOPT_HTTPHEADER, array(  
				'Authorization: Bearer 3dcd1068806e597d1cbce38dd50106c7',                                                                       
			    'Content-Type: application/json',
			    'Accept: application/vnd.vimeo.*+json;version=3.4'
			)                                                                                                                                
		);
		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, true);     
		$result = curl_exec($crl);
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
	public function buildTagUrl($path,$braftonId){
		return $this->videoPath.'/tags/'.$this->braftonId;
	}

}
