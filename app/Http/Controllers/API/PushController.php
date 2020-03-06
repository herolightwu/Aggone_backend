<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;

class PushController extends APIController
{
    protected $appid = "6a92ec76-96b7-43ee-ab0a-b22fec69a176";
    protected $pushUrl = "https://onesignal.com/api/v1/notifications";

    public function getPushUserIdOfUser($user_id){

        $user = User::find($user_id);
        if(isset($user)){
            if (isset($user->push_token))
                return $user->push_token;
            else
                return null;
        }else{
            return null;
        }

    }

    public function sendPush($userIdList, $contentMsg, $data){
        $pushIdList = [];
        foreach ($userIdList as $one){
            $pushId = $this->getPushUserIdOfUser($one);
            if(isset($pushId)){
                $pushIdList[] = $pushId;
            }
        }

        return $this->sendPushToUser($pushIdList, $contentMsg, $data);
    }

    public function sendPushToUser($include_player_ids, $contentMsg, $data ){

        $content = array(
            "en" => $contentMsg
        );
        $hashes_array = array();
        array_push($hashes_array, array(
            "id" => "like-button",
            "text" => "Accept",
            "icon" => "http://i.imgur.com/N8SN8ZS.png",
            "url" => "https://aggone.org"
        ));
        array_push($hashes_array, array(
            "id" => "like-button-2",
            "text" => "Decline",
            "icon" => "http://i.imgur.com/N8SN8ZS.png",
            "url" => "https://aggone.org"
        ));
        $fields = array(
            'app_id' => $this->appid,
            'include_player_ids' => $include_player_ids,
            'data' => $data,
            'contents' => $content,
            'web_buttons' => $hashes_array,
            'ios_badgeType'=>'SetTo',
            'ios_badgeCount'=>1

        );

        $fields = json_encode($fields);
            
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->pushUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic NGFiOTI2ZDUtMjgzZC00Y2U1LWJmMjUtNmE3MWRlZTZmNWU5'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
