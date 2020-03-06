<?php

namespace App\Http\Controllers\API;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends APIController
{
    /**
     * get_all_notifications api
     * @return \Illuminate\Http\Response
     */
    public function get_all_notifications(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $notifications = Notification::query()->where('user_id', $user->id)->with('sender')->get();
        return response()->json(['status'=>true, 'data'=>$notifications], $this-> successStatus);
    }

    /**
     * remove_notification api
     * @return \Illuminate\Http\Response
     */
    public function remove_notification(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $noti = Notification::find($input['id']);
        if ($noti){
            $noti->delete();
            return response()->json(['status'=>true], $this-> successStatus);
        } else{
            return response()->json(['status'=>false], $this-> successStatus);
        }
    }
    /**
     * push_chat_notification api
     * @return \Illuminate\Http\Response
     */
    public function push_chat_notification(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'msg' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $other = User::find($input['user_id']);
        if(isset($other)){
            $content = $user->username.' sent message to you.';
            $noti = [
                'content_msg' => $content,
                'user_id' => $other->id,
                'type' => 'chat',
                'sender_id' => $user->id,
                'timestamp' => time(),
            ];
            $cond = "user_id = ".$other->id." and type like 'chat' and sender_id = ".$user->id;
            $dd = Notification::query()->whereRaw($cond)->first();
            if (isset($dd)){
                $dd = Notification::find($dd->id);
                $dd->delete();
            }
            $dd = Notification::create($noti);
            $pusher = new PushController();
            $pusher->sendPush([$other->id], $content, $dd);
            return response()->json(['status' => true], $this->successStatus);
        }
        return response()->json(['status' => false], $this->successStatus);
    }
}
