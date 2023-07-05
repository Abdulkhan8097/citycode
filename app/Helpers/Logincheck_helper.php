<?php
function frontendLoginCheck($redirect =0){
	$Object = &get_instance();
	
	$sessionData = $Object->session->userdata('sessionData');	
	if(count($sessionData)>0 && $sessionData['userId']>0){
		if($redirect ==1)			return 1;//user login
	}else{		if($redirect ==1)			return 0;// user not login		else
			redirect("dashboard");
	}
}
/* This function redirect if user is login and has not access to view this page eg. Forgot Password */
function loginNotCheck(){
	$Object = &get_instance();
	$sessionData = $Object->session->userdata('sessionData');
	if(count($sessionData)>0){
		redirect("dashboard");
	}
}
?>