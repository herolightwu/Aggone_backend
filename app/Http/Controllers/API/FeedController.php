<?php

namespace App\Http\Controllers\API;

use App\Models\Alarm;
use App\Models\Feed;
use App\Models\Feed_like;
use App\Models\Bookmark;
use App\Models\Follow;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class FeedController extends APIController
{
    const PERPAGE = 20;
    const VIDEO_PATH = '/uploads/videos/';
    const IMAGE_PATH = '/uploads/images/';
    const ARTICLES_PATH = '/uploads/articles/';

    /**
     * report_feed api
     * @return \Illuminate\Http\Response
     */
    public function report_feed(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'feed_id' => 'required',
            'report' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $feed = Feed::find($input['feed_id']);
        $user = User::find($user->id);
        //=========send email ======================
        $to = "help.aggone@gmail.com"; // Send email to our user
        $subject = 'Report for '.$feed->title; // Give the email a subject
        $message = '<center>
  				<h2>Report for '.$feed->title.'</h2><br>
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
            'type' => 2,//user->1, feed->2 (default), story->3
            'rep_id' => $feed->id,
            'description' => $input['report'],
        ]);
        return response()->json(['status' => true], $this->successStatus);
    }

    /**
     * search_video_feeds api
     * @return \Illuminate\Http\Response
     */
    public function search_video_feeds(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $con = "title like '%".$input['name']."%' and (type = 0 or type = 1)";
        $feeds = Feed::query()->whereRaw($con)->orderBy('title')->with('user')->get();
        foreach ($feeds as $feed){
            $likes = Feed_like::query()->where('feed_id', $feed->id)->get();
            $feed['like_count'] = count($likes);
            $con_feed = 'feed_id = '.$feed->id.' and user_id = '.$user->id;
            $user_likes = Feed_like::query()->whereRaw($con_feed)->get();
            $feed['like'] = count($user_likes) > 0 ? true : false;
            $user_bookmarks = Bookmark::query()->whereRaw($con_feed)->get();
            $feed['bookmark'] = count($user_bookmarks) > 0 ? true : false;
        }
        return response()->json(['status' => true, 'count' => count($feeds), 'feeds' => $feeds], $this->successStatus);
    }

    /**
     * get_sports_feeds api
     * @return \Illuminate\Http\Response
     */
    public function get_sports_feeds(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'page' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        if($input['sport_id'] == ''){
            $feeds = Feed::query()->where('mode', 0)->with('user')->orderBy('timestamp', 'desc')->paginate(self::PERPAGE, ['*'], 'page', $input['page']);
        } else{
            $con = "locate(sport_id, '".$input['sport_id']."') > 0 and mode = 0";
            $feeds = Feed::query()->whereRaw($con)->with('user')->orderBy('timestamp', 'desc')->paginate(self::PERPAGE, ['*'], 'page', $input['page']);
        }

        foreach ($feeds as $feed){
            $likes = Feed_like::query()->where('feed_id', $feed->id)->get();
            $feed['like_count'] = count($likes);
            $con_feed = 'feed_id = '.$feed->id.' and user_id = '.$user->id;
            $user_likes = Feed_like::query()->whereRaw($con_feed)->get();
            $feed['like'] = count($user_likes) > 0 ? true : false;
            $user_bookmarks = Bookmark::query()->whereRaw($con_feed)->get();
            $feed['bookmark'] = count($user_bookmarks) > 0 ? true : false;
        }
        return response()->json(['status' => true, 'count' => count($feeds), 'feeds' => $feeds], $this->successStatus);
    }

    /**
     * get_my_feeds api
     * @return \Illuminate\Http\Response
     */
    public function get_my_feeds(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'page' => 'required',
            //'sport_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $con = $con = "locate(sport_id, '".$input['sport_id']."') > 0";
        $follows = Follow::query()->where('user_id', $user->id)->get();
        $follow_indexs = ",".$user->id.",";
        foreach ($follows as $follow){
            $follow_indexs.= $follow['follow_id'].",";
        }
        if ($input['sport_id'] == ''){
            $raw_query = "locate(user_id, '".$follow_indexs."') > 0";
        } else{
            $raw_query = $con." and locate(user_id, '".$follow_indexs."') > 0";
        }

        $feeds = Feed::query()->whereRaw($raw_query)->with('user')->orderBy('timestamp', 'desc')->paginate(self::PERPAGE, ['*'], 'page', $input['page']);
        foreach ($feeds as $feed){
            $likes = Feed_like::query()->where('feed_id', $feed->id)->get();
            $feed['like_count'] = count($likes);
            $con_feed = 'feed_id = '.$feed->id.' and user_id = '.$user->id;
            $user_likes = Feed_like::query()->whereRaw($con_feed)->get();
            $feed['like'] = count($user_likes) > 0 ? true : false;
            $user_bookmarks = Bookmark::query()->whereRaw($con_feed)->get();
            $feed['bookmark'] = count($user_bookmarks) > 0 ? true : false;
        }
        return response()->json(['status' => true, 'count' => count($feeds), 'feeds' => $feeds], $this->successStatus);
    }
    /**
     * get_my_feeds api
     * @return \Illuminate\Http\Response
     */
    public function get_all_feeds_by_user(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'page' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $feeds = Feed::query()->where('user_id', $input['user_id'])->with('user')->orderBy('timestamp', 'desc')->paginate(self::PERPAGE, ['*'], 'page', $input['page']);
        foreach ($feeds as $feed){
            $likes = Feed_like::query()->where('feed_id', $feed->id)->get();
            $feed['like_count'] = count($likes);
            $con_feed = 'feed_id = '.$feed->id.' and user_id = '.$user->id;
            $user_likes = Feed_like::query()->whereRaw($con_feed)->get();
            $feed['like'] = count($user_likes) > 0 ? true : false;
            $user_bookmarks = Bookmark::query()->whereRaw($con_feed)->get();
            $feed['bookmark'] = count($user_bookmarks) > 0 ? true : false;
        }
        return response()->json(['status' => true, 'count' => count($feeds), 'feeds' => $feeds], $this->successStatus);
    }

    /**
     * save_feed api
     * @return \Illuminate\Http\Response
     */
    public function save_feed(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'type' => 'required|numeric',
            'title' => 'required',
            'sport_id' => 'required',
            'view_count' => 'required',
            'timestamp' => 'required',
            'shared' => 'required',
            'mode' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $feed = Feed::create([
            'type' => $input['type'],
            'user_id' => $user->id,
            'title' => $input['title'],
            'sport_id' => $input['sport_id'],
            'view_count' => $input['view_count'],
            'timestamp' => $input['timestamp'],
            'shared' => $input['shared'],
            'mode' => $input['mode'],
        ]);
        $feed = Feed::find($feed->id);
        if (isset($input['video_url'])){
            $feed->video_url = $input['video_url'];
            $feed->save();
        }
        if (isset($input['thumbnail_url'])){
            $feed->thumbnail_url = $input['thumbnail_url'];
            $feed->save();
        }
        if (isset($input['articles'])){
            $feed->articles = $input['articles'];
            $feed->save();
        }
        if (isset($input['tagged'])){
            $feed->tagged = $input['tagged'];
            $feed->save();
        }
        if (isset($input['desc_str'])){
            $feed->desc_str = $input['desc_str'];
            $feed->save();
        }

        $followers = Follow::query()->where('user_id', $user->id)->get('follow_id');
        if(isset($followers)){
            $content = $user->username.' posted '.$input['title'];
            $noti = [
                'content_msg' => $content,
                'user_id' => $feed->user_id,
                'type' => 'post',
                'sender_id' => $user->id,
                'timestamp' => time(),
            ];

            $pusher = new PushController();
            $pusher->sendPush([$followers], $content, $noti);
        }
        $followeds = Follow::query()->where('follow_id', $user->id)->get('user_id');
        if(isset($followeds)){
            $content = $user->username.' posted '.$input['title'];
            $noti = [
                'content_msg' => $content,
                'user_id' => $feed->user_id,
                'type' => 'post',
                'sender_id' => $user->id,
                'timestamp' => time(),
            ];

            $pusher = new PushController();
            $pusher->sendPush([$followeds], $content, $noti);
        }

        return response()->json(['status' => true, 'feed' => $feed], $this->successStatus);
    }

    /**
     * add_view_feed api
     * @return \Illuminate\Http\Response
     */
    public function add_view_feed(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'id' => 'required',
            'type' => 'required|numeric',
            'title' => 'required',
            'view_count' => 'required',
            'timestamp' => 'required',
            'shared' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $feed = Feed::find($input['id']);
        $feed->view_count++;
        $feed->save();
        return response()->json(['status' => true, 'feed' => $feed], $this->successStatus);
    }

    /**
     * delete_feed api
     * @return \Illuminate\Http\Response
     */
    public function delete_feed(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'feed_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $feed = Feed::find($input['feed_id']);
        if ($feed->user_id == $user->id){
            $feed->delete();
            return response()->json(['status' => true], $this->successStatus);
        } else{
            return response()->json(['status' => false, 'error' => 'Can\'t delete other\'s feed'], $this->failedStatus);
        }
    }

    /**
     * like_feed api
     * @return \Illuminate\Http\Response
     */
    public function like_feed(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'feed_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $con_feed = 'feed_id = '.$input['feed_id'].' and user_id = '.$user->id;
        $like = Feed_like::query()->whereRaw($con_feed)->first();
        if (isset($like)){
            $flike = Feed_like::find($like->id);
            $flike->delete();
            return response()->json(['status' => true, 'result' => false], $this->successStatus);
        } else{
            $like = Feed_like::create([
                'feed_id' => $input['feed_id'],
                'user_id' => $user->id,
            ]);

            $feed = Feed::find($input['feed_id']);
            if($feed->user_id != $user->id){
                $content = $user->username.' liked your video/news.';
                $noti = Alarm::create([
                    'content_msg' => $content,
                    'user_id' => $feed->user_id,
                    'type' => 'like',
                    'sender_id' => $user->id,
                    'timestamp' => time(),
                ]);

                $pusher = new PushController();
                $pusher->sendPush([$feed->user_id], $content, $noti);
            }
            return response()->json(['status' => true, 'result' => true], $this->successStatus);
        }
    }

    /**
     * private_feed api
     * @return \Illuminate\Http\Response
     */
    public function private_feed(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'feed_id' => 'required',
            'val' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $feed = Feed::find($input['feed_id']);
        if($feed){
            $feed->mode = $input['val'];
            $feed->save();
        }
        return response()->json(['status' => true, 'result' => true], $this->successStatus);
    }

    /**
     * upload_file api
     * @return \Illuminate\Http\Response
     */
    public function upload_file(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing filename'], $this->failedStatus);
        }
        if ($request->hasFile('video') && $request->hasFile('thumbnail')){
            $vfile = $request->file('video');
            $vfilename = $request->get('name').".".$vfile->extension();
            $vpath = public_path().self::VIDEO_PATH;
            if (!File::isDirectory($vpath)){
                File::makeDirectory($vpath, 0777, true, true);
            }
            $vfile->move($vpath, $vfilename);
            $pfile = $request->file('thumbnail');
            $pfilename = $request->get('name').".".$pfile->extension();
            $ppath = public_path().self::IMAGE_PATH;
            if (!File::isDirectory($ppath)){
                File::makeDirectory($ppath, 0777, true, true);
            }
            $pfile->move($ppath, $pfilename);
            return response()->json(['status' => true, 'video_url' => $vfilename, 'thumbnail_url' => $pfilename], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'error' => 'Missing files'], $this->failedStatus);
        }
    }

    /**
     * upload_articles api
     * @return \Illuminate\Http\Response
     */
    public function upload_articles(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing filename'], $this->failedStatus);
        }

        $ret_path = "";
        for($i=0; $i<3; $i++){
            if($request->hasFile('image'.$i)) {
                $pfile = $request->file('image'.$i);
                $pfilename = $request->get('name').$i.".".$pfile->extension();
                $ppath = public_path().self::ARTICLES_PATH;
                if (!File::isDirectory($ppath)){
                    File::makeDirectory($ppath, 0777, true, true);
                }
                $pfile->move($ppath, $pfilename);
                if ($ret_path == "")
                    $ret_path = $pfilename;
                else
                    $ret_path = $ret_path.",".$pfilename;
            }
        }
        if($ret_path != "")
            return response()->json(['status' => true, 'paths' => $ret_path], $this->successStatus);
        else
            return response()->json(['status' => false, 'error' => 'Failed upload'], $this->failedStatus);
    }
}
