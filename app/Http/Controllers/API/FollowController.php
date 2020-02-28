<?php

namespace App\Http\Controllers\API;


use App\Models\Alarm;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FollowController extends APIController
{
    /**
     * add_follow api
     * @return \Illuminate\Http\Response
     */
    public function add_follow(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        if ($user->id != $input['user_id']) {
            $follow = Follow::create([
                'user_id' => $user->id,
                'follow_id' => $input['user_id'],
            ]);

            if ($follow) {
                $other = User::find($input['user_id']);
                if (isset($other) && $other->id != $user->id) {
                    $content = $user->username . ' followed you.';
                    $noti = Alarm::create([
                        'content_msg' => $content,
                        'user_id' => $other->id,
                        'type' => 'follow',
                        'sender_id' => $user->id,
                        'timestamp' => time(),
                    ]);

                    $pusher = new PushController();
                    $pusher->sendPush([$other->id], $content, $noti);
                }
                return response()->json(['status' => true], $this->successStatus);
            }
        }

        return response()->json(['status' => false, 'error' => 'Failed follow'], $this->failedStatus);
    }

    /**
     * delete_follow api
     * @return \Illuminate\Http\Response
     */
    public function delete_follow(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $follows = Follow::query()->where([['user_id', $user->id], ['follow_id', $input['user_id']]])->get();

        foreach ($follows as $follow){
            $ff = Follow::find($follow->id);
            $ff->delete();
        }
        return response()->json(['status' => true], $this->successStatus);
    }

    /**
     * check_follow api
     * @return \Illuminate\Http\Response
     */
    public function check_follow(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $follows = Follow::query()->where([['user_id', $user->id], ['follow_id', $input['user_id']]])->get();

        if(count($follows) > 0)
            return response()->json(['status' => true, 'result' => true], $this->successStatus);
        else
            return response()->json(['status' => true, 'result' => false], $this->successStatus);
    }

    /**
     * get_following api
     * @return \Illuminate\Http\Response
     */
    public function get_following()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }

        $follows = Follow::query()->where('user_id', $user->id)->get();

        $followings = array();
        $count = 0;
        foreach ($follows as $follow){
            $user = User::find($follow->follow_id);
            if($user)
            {
                $count++;
                array_push($followings, $user);
            }
        }

        return response()->json(['status' => true, 'count' =>$count, 'followings' => $followings], $this->successStatus);
    }

    /**
     * get_follower api
     * @return \Illuminate\Http\Response
     */
    public function get_follower()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }

        $follows = Follow::query()->where('follow_id', $user->id)->get();

        $followers = array();
        $count = 0;
        foreach ($follows as $follow){
            $user = User::find($follow->user_id);
            if($user){
                $count++;
                array_push($followers, $user);
            }

        }

        return response()->json(['status' => true, 'count' => $count, 'followers' => $followers], $this->successStatus);
    }
}
