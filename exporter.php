<?php 
//declare(strict_types=1);

require_once 'RCClientLibrary/AdferoArticlesVideoExtensions/AdferoVideoClient.php';
require_once 'RCClientLibrary/AdferoArticles/AdferoClient.php';
require_once 'RCClientLibrary/AdferoPhotos/AdferoPhotoClient.php';

spl_autoload_register(function ($class_name) {
    include 'classes/'.$class_name .'.php';
});

$creds = file_get_contents('creds.json');
$creds = json_decode($creds);
//set up connection to AWS db
$braftondb = BraftonConnection::getCreation($creds->server,$creds->user,$creds->code,'vimeo');
$connection = $braftondb->getConnection();
$user_data = BraftonConnection::getClientData($connection,'James Allan');
var_dump($user_data);
die();
define('VIMEO_LINK',user_data['link']);
define('VIMEO_TOKEN',user_data['token']);
define('VIMEO_PRIVACY',user_data['privacy']);


class VimeoExporter extends MasterExporter{

}
$exporter = new VimeoExporter();