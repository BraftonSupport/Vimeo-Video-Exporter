<?php 
/* To be implemented later.  
The idea will be to have the user set these values universally for all videos if they so choose after completing two step authentication.  
A script will be called from the redirect url to poll the client. */
declare(strict_types=1);

class VimeoOptions {
    private $privacyOverride;
    private $privacyView;
    private $privacyEmbed;
    private $privacyAdd;

    public function __construct($override=false,$view=null,$embed=null,$add=null){
        if($override==false){
            return;
        }
        $this->privacyView = $view;
        $this->privacyEmbed = $view;
        $this->privacyAdd = $view;
    }
    /**
     * Returns value set for video privacy option, default = anybody
     * @return $privacyView string
     */
    public function getPrivacyView() : string {
        return $this->privacyView;
    }
    /**
     * Returns universal value set for video embed settings, public private or whitelist to set eligible domains
     * @return $privacyEmbed string
     */
    public function getPrivacyEmbed() : string {
        return $this->privacyEmbed;
    }
    /**
     * Whether a user can add the video to an album, channel, or group. 
     * @return $privacyAdd boolean
     */
    public function getPrivacyAdd() : boolean {
        return $this->privacyAdd;
    }

}