<?php

namespace App\Libraries;

/* * ***************************************************************************\
  +-----------------------------------------------------------------------------+
  | Project        : pushnotification                                           |
  | FileName       : pushnotification.php                                       |
  | Version        : 1.0                                                        |
  | Developer      : --                                                         |
  | Created On     : 22-02-2021                                                 |
  | Modified On    :                                                            |
  | Modified   By  :                                                            |
  | Authorised By  :  --                                                        |
  | Comments       :  This class used for sending notication                    |
  | Email          : subedar2507@gmail.com                                      |
  +-----------------------------------------------------------------------------+
  \**************************************************************************** */

class Pushnotification {
    /*     * * variable for android setting ** */

    private $android_google_url;
    private $android_google_authorized_key;
    private $android_google_content_type;

    /*     * ** variable for iphone setting** */
    private $iphone_passphrase;
    private $iphone_apple_url;

    /*     * **
     * Function to initialize value
     */

    public function __construct() {
        // $this->android_google_url = "https://android.googleapis.com/gcm/send";
        $this->android_google_content_type = "application/json";
        $this->iphone_apple_url = "ssl://gateway.push.apple.com:2195";
        $this->android_google_authorized_key = "AAAA9Rs0U4Y:APA91bGnleKimaRudVxVlxRq89OLu6iUtI-Y_Wj7obupGp5rkGOHDP9HxfpUb_bnqVAIj5ZP9DNIWxtP9kP7F4YvyD7sToQ1ZzbcD1e2CtT--319yPWLkS8JjITDche58EYEGfNGn5Ar";
        $this->android_google_url = "https://fcm.googleapis.com/fcm/send";
        $this->iphone_passphrase = "pushnotificationcitycode";
    }

    /**
     * function for setting android variable
     */
    public function setAndroidSetting($param = array()) {

        if (isset($param['google_key'])) {
            $this->android_google_authorized_key = $param['google_key'];
        }
        if (isset($param['content_type'])) {
            $this->android_google_content_type = $param['content_type'];
        }
        if (isset($param['google_url'])) {
            $this->android_google_url = $param['google_url'];
        }
    }

    /**
     * function for setting iphone variable
     */
    public function setIphoneSetting($param = array()) {

        if (isset($param['iphone_passphrase'])) {
            $this->iphone_passphrase = $param['iphone_passphrase'];
        }
        if (isset($param['iphone_url'])) {
            $this->iphone_apple_url = $param['iphone_url'];
        }
    }

    /*     * *
     * Function for send android notification
     *  take $gcmIds as array
     * $message  take message as array
     */

    public function sendAndroidNotification($fcm_reg_id = "",$message="", $title="" ) {

         
        //if array then assign it else create array for message
        if(is_array($message))
        {
            $fcmMsg = $message;
        }
        else
        {
                    $fcmMsg = array(
                               'body' => $message,
                               'title' => $title,
                               'sound' => "default",
                               'color' => "#203E78"
                           );
        }
                           $fcmFields = array(
                               'to' => $fcm_reg_id,
                               'priority' => 'high',
                               "data" => $fcmMsg,
                               "notification" => $fcmMsg
                           );
        

                           $headers = array(
                               'Authorization: key=' . $this->android_google_authorized_key,
                               'Content-Type: application/json'
                           );
                           

                    
                if (extension_loaded('curl')) { 
                    $ch = curl_init();
                           curl_setopt($ch, CURLOPT_URL, $this->android_google_url);
                           curl_setopt($ch, CURLOPT_POST, true);
                           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
                           $result = curl_exec($ch);
                           curl_close($ch);
//                           echo $result . "\n\n";
                }
            
        
    }

    
     public function sendNotificationtest($fcm_reg_id = "",$message="", $title="" ) {

         
        //if array then assign it else create array for message
        if(is_array($message))
        {
            $fcmMsg = $message;
        }
        else
        {
                    $fcmMsg = array(
                               'body' => $message,
                               'title' => $title,
                               'sound' => "default",
                               'color' => "#203E78"
                           );
        }
        
                           $fcmFields = array(
                               'to' => $fcm_reg_id,
                               'priority' => 'high',
                               "data" => $fcmMsg,
                               "notification" => $fcmMsg,
                           );
        

                           $headers = array(
                               'Authorization: key=' . $this->android_google_authorized_key,
                               'Content-Type: application/json'
                           );
                           
//echo json_encode($fcmFields);
                    
                if (extension_loaded('curl')) { 
                    $ch = curl_init();
                           curl_setopt($ch, CURLOPT_URL, $this->android_google_url);
                           curl_setopt($ch, CURLOPT_POST, true);
                           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
                           $result = curl_exec($ch);
                           curl_close($ch);
                       //    echo $result . "\n\n";
                }
            
        
    }
    
    
     public function sendNotification($fcm_reg_id = "",$message="", $title="" ) {

         
        //if array then assign it else create array for message
        if(is_array($message))
        {
            $fcmMsg = $message;
        }
        else
        {
                    $fcmMsg = array(
                               'body' => $message,
                               'title' => $title,
                               'sound' => "default",
                               'color' => "#203E78"
                           );
        }
                           $fcmFields['message'] = array(
                               'token' => $fcm_reg_id,
                               'android' => array("ttl"=>"86400s","notification"=>array("click_action"=>"OPEN_ACTIVITY_1")),
                               "notification" => $fcmMsg,
                               "apns" => array("headers"=>array("apns-priority"=>5),"payload"=>array("aps"=>array("alert"=>array("title"=>"Game Request","subtitle"=>"Five Card Draw","body"=>"Bob wants to play poker"),"category"=>"NEW_MESSAGE_CATEGORY"))),
                           );
        

                           $headers = array(
                               'Authorization: key=' . $this->android_google_authorized_key,
                               'Content-Type: application/json'
                           );
                           
//echo json_encode($fcmFields);die;
                    
                if (extension_loaded('curl')) { 
                    $ch = curl_init();
                           curl_setopt($ch, CURLOPT_URL, $this->android_google_url);
                           curl_setopt($ch, CURLOPT_POST, true);
                           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
                           $result = curl_exec($ch);
                           curl_close($ch);
//                           echo $result . "\n\n";
                }
            
        
    }
    
    /**
     * Send iphone notification
     * @param <string> $deviceToken device of iphone
     * @param <string> $message message which nees to send
     */
    public function sendIphoneNotification($arrDeviceToken, $message, $id='', $keyword_id = null, $date = null) {
        $passphrase = $this->iphone_passphrase;

        foreach ($arrDeviceToken as $deviceToken) {
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', getcwd() . '/iphonepushnotification/ck.pem');
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

            // Open a connection to the APNS server
            $fp = stream_socket_client(
                    $this->iphone_apple_url, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

            if (!$fp)
                exit("Failed to connect: $err $errstr" . PHP_EOL);

            'Connected to APNS' . PHP_EOL;

            if (is_array($message)) {
                $body['aps'] = $message;
            } else {

                $body['aps'] = array(
                    'alert' => $message,
                    'id' => $id,
                    //'lang_id' => $lang_id,
                    'id' => $keyword_id,
                    'date' => $date,
                    'sound' => 'default',
                    'badge' => 1
                );
            }

            // Encode the payload as JSON
            $payload = json_encode($body);

            // Build the binary notification
            @$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
            // print_r($msg);exit;
            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));
//             echo $result;die;
            if (!$result)
                echo 'Message not delivered' . PHP_EOL;
            else
                fclose($fp);
        }
    }

}

?>
