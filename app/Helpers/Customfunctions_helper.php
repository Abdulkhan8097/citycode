<?php
/*Check user is online or not and send his online/offline image */
function userOnlineImage($userId){
	$onlineImage = '<img src="'.base_url().'images/online.gif" title="Online" alt="Online">';
	return $onlineImage;
}

/* Date format */

function displayDateTime($date){
	return date("M j, Y h:i A", strtotime($date));
}
/* Generate Randmo Key */
function generateKey($length = 10){
	$characters = '09824675134AzPqOaIwUsYcTvRfEdWeMrNgBbVnChXtZtLyKjJmAkSuDiFlGoQp';
	$string = '';
	for ($p = 0; $p < $length; $p++) {
		$string .= @$characters[mt_rand(0, strlen($characters))];
	}
	return $string;
}
/* Return Upload path*/
function getUploadPath(){
	$userPath 	= SITE_ROOT_PATH."/assets/upload/";
	return $userPath;
}
/* Crate Thumbnail */
function makeThumbnails($source,$dest,$MaxWe=100,$MaxHe=150){
//	if(SITE_HOST == "LOCAL"){//LOCAL WORK
		$Object = &get_instance();
		
		$config['image_library'] 	= 'gd2';
		$config['source_image'] 	= $source;
		$config['create_thumb'] 	= TRUE;
		$config['maintain_ratio'] 	= FALSE;
		$config['width'] 			= $MaxWe;
		$config['height'] 			= $MaxHe;
		$config['new_image'] 		= $dest;
		$config['thumb_marker']  	= '';
		
		//$Object->load->library('image_lib', $config);
		
		if ($Object->load->is_loaded('image_lib') === false) {
			$Object->load->library('image_lib');
		}
		
		$Object->image_lib->initialize($config);
		if ( ! $Object->image_lib->resize())
		{
			echo $Object->image_lib->display_errors(); exit;
		}
		$Object->image_lib->clear();

}


/* Get Extenstion of image */
function getFileExtension($file){
	$tempArray 	= explode(".",$file);
	$count 		= count($tempArray);
	$fileExt	= $tempArray[$count-1];
	return $fileExt;
}
