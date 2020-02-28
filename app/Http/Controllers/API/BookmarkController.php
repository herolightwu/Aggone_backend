<?php

namespace App\Http\Controllers\API;


use App\Models\Bookmark;
use App\Models\Feed;
use App\Models\Feed_like;
use App\Models\Recommend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends APIController
{
    /**
     * save_bookmark api
     * @return \Illuminate\Http\Response
     */
    public function save_bookmark(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'feed_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $cond = 'user_id = '.$user->id.' and feed_id = '.$input['feed_id'];
        $book = Bookmark::query()->whereRaw($cond)->first();
        if(isset($book)){
            $bookmark = Bookmark::find($book->id);
            $bookmark->delete();
            return response()->json(['status' => false], $this->successStatus);
        } else{
            $bookmark = Bookmark::create([
                'user_id' => $user->id,
                'feed_id' => $input['feed_id'],
            ]);
            return response()->json(['status' => true], $this->successStatus);
        }
    }

    /**
     * get_bookmarks api
     * @return \Illuminate\Http\Response
     */
    public function get_bookmarks()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }

        $feedids = Bookmark::query()->where('user_id', $user->id)->get();

        $bookmarks = array();
        $count = 0;
        foreach ($feedids as $feedid){
            $feed = Feed::find($feedid->feed_id);
            if($feed){
                $likes = Feed_like::query()->where('feed_id', $feed->id)->get();
                $feed['like_count'] = count($likes);
                $con_feed = 'feed_id = '.$feed->id.' and user_id = '.$user->id;
                $user_likes = Feed_like::query()->whereRaw($con_feed)->get();
                $feed['like'] = count($user_likes) > 0 ? true : false;
                $user_bookmarks = Bookmark::query()->whereRaw($con_feed)->get();
                $feed['bookmark'] = count($user_bookmarks) > 0 ? true : false;
                $other = User::find($feed->user_id);
                if (isset($other)){
                    $recommends = Recommend::query()->where('user_id', $other->id)->get();
                    $other['recommends'] = count($recommends);
                    $feed['user'] = $other;
                }
                $bookmarks[] = $feed;
            }

        }

        return response()->json(['status' => true, 'count' => count($bookmarks), 'bookmarks' => $bookmarks], $this->successStatus);
    }
}
