<?php

namespace App\Http\Controllers\API;

use App\Models\Feed;
use App\Models\Report;
use App\Models\Story;
use App\Models\StoryReply;
use App\Models\StoryView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class StoryController extends APIController
{
    const STORY_PATH = '/uploads/stories/';

    /**
     * report_story api
     * @return \Illuminate\Http\Response
     */
    public function report_story(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'story_id' => 'required',
            'report' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $story = Story::find($input['story_id']);
        $other = User::find($story->user_id);
        $user = User::find($user->id);
        //=========send email ======================
        $to = "help.aggone@gmail.com"; // Send email to our user
        $subject = 'Report for story of '.$other->username; // Give the email a subject
        $message = '<center>
  				<h2>Report for story of '.$other->username.'</h2><br>
				<p>'.$input['report'].'</p>
				<h4>From '.$user->username.'</h4>
				</center>';

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: '.$user->email. "\r\n" .
            'Reply-To: '.$user->email. "\r\n" .
            'X-Mailer: PHP/' . phpversion();// Set from headers
        mail($to, $subject, $message, $headers); // Send our email
        $report = Report::create([
            'user_id' => $user->id,
            'type' => 3,//user->1, feed->2 (default), story->3
            'rep_id' => $story->id,
            'description' => $input['report'],
        ]);
        return response()->json(['status' => true], $this->successStatus);
    }
    /**
     * delete_story api
     * @return \Illuminate\Http\Response
     */
    public function delete_story(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'story_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $story = Story::find($input['story_id']);
        if (isset($story)){
            $story->delete();
            return response()->json(['status' => true], $this->successStatus);
        } else{
            return response()->json(['status' => false], $this->successStatus);
        }
    }
    /**
     * get_story_msg api
     * @return \Illuminate\Http\Response
     */
    public function get_story_msg(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'story_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $story = Story::find($input['story_id']);
        if (isset($story)){
            $con = 'story_id = '.$story->id.' and reply_type <> 0 and user_id = '.$input['user_id'];
            $storymsg = StoryReply::query()->whereRaw($con)->with('user')->get();
            return response()->json(['status' => true, 'storymsg' => $storymsg], $this->successStatus);
        } else{
            return response()->json(['status' => false], $this->successStatus);
        }
    }

    /**
     * reply_story api
     * @return \Illuminate\Http\Response
     */
    public function reply_story(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'story_id' => 'required',
            'reply_type' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $user = User::find($user->id);
        $story = Story::find($input['story_id']);
        if (isset($story)){
            $sreply = StoryReply::create([
                'story_id' => $input['story_id'],
                'user_id' => $user->id,
                'reply_type' => $input['reply_type'],
                'content' =>$input['content'],
                'timestamp' => time(),
            ]);

            $content = $user->username.' replied to your story.';
            $noti = [
                'content_msg' => $content,
                'type' => 'reply story',
                'sender_id' => $user->id,
                'timestamp' => time(),
            ];

            $pusher = new PushController();
            $pusher->sendPush([$story->user_id], $content, $noti);

            return response()->json(['status' => true], $this->successStatus);
        } else{
            return response()->json(['status' => false], $this->successStatus);
        }
    }

    /**
     * view_story api
     * @return \Illuminate\Http\Response
     */
    public function view_story(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'story_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $user = User::find($user->id);
        $story = Story::find($input['story_id']);
//        $cond = 'story_id = '.$story->id.' and user_id = '.$user->id;
//        $sView = StoryView::query()->whereRaw($cond)->first();
//        if(isset($sView)){
//            $sView = StoryView::find($sView->id);
//            $sView->view_count++;
//            $sView->timestamp = time();
//            $sView->save();
//        } else{
//            $storyview = StoryView::create([
//                'story_id' => $input['story_id'],
//                'user_id' => $user->id,
//                'view_count' => 1,
//                'timestamp' => time(),
//            ]);
//        }
        $storyview = StoryView::create([
            'story_id' => $input['story_id'],
            'user_id' => $user->id,
            'view_count' => 1,
            'timestamp' => time(),
        ]);
//        $content = $user->username.' viewed your story.';
//        $noti = [
//            'content_msg' => $content,
//            'type' => 'reply story',
//            'sender_id' => $user->id,
//            'timestamp' => time(),
//        ];
//
//        $pusher = new PushController();
//        $pusher->sendPush([$story->user_id], $content, $noti);
        return response()->json(['status' => true], $this->successStatus);
    }

    /**
     * get_story_views api
     * @return \Illuminate\Http\Response
     */
    public function get_story_views(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'story_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $story = Story::find($input['story_id']);
        $storyviews = array();
        if (isset($story)){
            $viewids = StoryView::query()->where('story_id', $story->id)->select('user_id')->groupBy('user_id')->get();
            foreach ($viewids as $ss){
                $viewer = User::find($ss->user_id);
                if(isset($viewer)){
                    $one['story_id'] = $story->id;
                    $one['user'] = $viewer;
                    $cond3 = 'story_id = '.$story->id.' and reply_type <> 0 and user_id = '.$ss->user_id;
                    $tempviews = StoryReply::query()->whereRaw($cond3)->get();
                    $one['reply_count'] = count($tempviews);
                    $storyviews[] = $one;
                }
            }

            $sviews = StoryView::query()->where('story_id', $story->id)->sum('view_count');

            return response()->json(['status' => true, 'view_count' => $sviews, 'storyviews' => $storyviews], $this->successStatus);
        } else{
            return response()->json(['status' => false], $this->successStatus);
        }
    }

    /**
     * get_stories_by_user api
     * @return \Illuminate\Http\Response
     */
    public function get_stories_by_user(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $cur_t = time();
        $cond = 'timeend > '.$cur_t.' and user_id = '.$input['user_id'];
        $stories = Story::query()->whereRaw($cond)->orderBy('timeend', 'desc')->with('user')->get();
        return response()->json(['status' => true, 'story' => $stories], $this->successStatus);
    }

    /**
     * get_all_story api
     * @return \Illuminate\Http\Response
     */
    public function get_all_story(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $cur_t = time();
        $cond = 'timeend > '.$cur_t;
        $stories = Story::query()->whereRaw($cond)->with('user')->get();
        $result = array();
        foreach ($stories as $story){
            $cond = 'story_id = '.$story->id.' and user_id = '.$user->id;
            $sviews = StoryView::query()->whereRaw($cond)->get();
            if (count($sviews) == 0){
                $result[] = $story;
            }
        }
        return response()->json(['status' => true, 'story' => $result], $this->successStatus);
    }
    /**
     * save_story api
     * @return \Illuminate\Http\Response
     */
    public function save_story(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $story = Story::create([
            'user_id' => $user->id,
            'image' => $input['image'],
            'timebeg' => time(),
            'timeend' => time() + 24*60*60,
        ]);
        $story = Story::find($story->id);

        if (isset($input['tags'])){
            $story->tags = $input['tags'];
            $story->save();
            if ($input['tags'] != ''){
                $user_ids = explode(",", $input['tags']);
                $content = $user->username.' posted new story';
                $noti = [
                    'content_msg' => $content,
                    'type' => 'new story',
                    'sender_id' => $user->id,
                    'timestamp' => time(),
                ];

                $pusher = new PushController();
                $pusher->sendPush([$user_ids], $content, $noti);
            }
        }
        $user = User::Find($user->id);
        $story['user'] = $user;
        return response()->json(['status' => true, 'story' => $story], $this->successStatus);
    }

    /**
     * get_view_statics api
     * @return \Illuminate\Http\Response
     */
    public function get_view_statics(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'basetime' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);

        $timebeg = time() - 24*60*60;
        $weekbeg = time() - 7*24*60*60;
        $monthbeg = time() - 30*24*60*60;
        $total = 0;
        $today_count = 0;
        $week_count = 0;
        $month_count = 0;
        $stories = Story::query()->where('user_id', $user->id)->get();
        foreach ($stories as $story){
            $cond = 'story_id = '.$story->id.' and timestamp > '.$timebeg;
            $stt = StoryView::query()->where('story_id', $story->id)->get();
            $total += count($stt);
            $today_st = StoryView::query()->whereRaw($cond)->get();
            $today_count += count($today_st);
            $cond = 'story_id = '.$story->id.' and timestamp > '.$weekbeg;
            $week_st = StoryView::query()->whereRaw($cond)->get();
            $week_count += count($week_st);
            $cond = 'story_id = '.$story->id.' and timestamp > '.$monthbeg;
            $month_st = StoryView::query()->whereRaw($cond)->get();
            $month_count += count($month_st);
        }

        $result['total'] = $total;
        $result['ntoday'] = $today_count;
        $result['nweek'] = $week_count;
        $result['nmonth'] = $month_count;

        return response()->json(['status' => true, 'result' => $result], $this->successStatus);
    }

    /**
     * upload_story api
     * @return \Illuminate\Http\Response
     */
    public function upload_story(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing filename'], $this->failedStatus);
        }
        if ($request->hasFile('image')){
            $ifile = $request->file('image');
            $ifilename = $request->get('name').".".$ifile->extension();
            $ipath = public_path().self::STORY_PATH;
            if (!File::isDirectory($ipath)){
                File::makeDirectory($ipath, 0777, true, true);
            }
            $ifile->move($ipath, $ifilename);
            return response()->json(['status' => true, 'image_url' => $ifilename], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'error' => 'Missing files'], $this->failedStatus);
        }
    }
}
