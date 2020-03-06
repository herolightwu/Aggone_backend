<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('user/signup_email_password', 'API\UserController@sign_up');
Route::post('user/get_user_by_email', 'API\UserController@get_user_by_email');
//Route::post('user/update_user', 'API\UserController@update_user');
Route::post('user/login_email_password', 'API\UserController@login');
Route::post('user/login_social', 'API\UserController@login_social');
Route::post('user/forgot_password', 'API\UserController@forgot_password');
Route::post('user/get_user_by_filter', 'API\UserController@get_users_by_filter');
Route::post('user/search_users', 'API\UserController@search_users');
Route::post('user/upload_image', 'API\UserController@upload_image');

Route::post('feed/upload_file', 'API\FeedController@upload_file');
Route::post('feed/upload_articles', 'API\FeedController@upload_articles');
Route::post('story/upload_story', 'API\StoryController@upload_story');

//Route::post('result/get_club_year_summary', 'API\ResultController@get_club_year_summary');

Route::group(['middleware' => 'auth:api'], function() {
    Route::group(['middleware' => 'authenticated'], function() {
        Route::post('user/update_user', 'API\UserController@update_user');
        Route::post('user/get_all_user', 'API\UserController@get_all_users');
        Route::post('user/get_users_by_type', 'API\UserController@get_users_by_type');
        Route::post('user/change_password', 'API\UserController@change_password');
        Route::post('user/update_user_field', 'API\UserController@update_user_field');
        Route::post('user/upload_resume', 'API\UserController@upload_resume');
        Route::post('user/get_all_resumes', 'API\UserController@get_all_resumes');
        Route::post('user/delete_resume', 'API\UserController@delete_resume');
        Route::post('user/get_strengths', 'API\UserController@get_strengths');
        Route::post('user/save_strengths', 'API\UserController@save_strengths');
        Route::post('user/get_tagged_users', 'API\UserController@get_tagged_users');
        Route::post('user/join_team', 'API\UserController@join_team');
        Route::post('user/leave_team', 'API\UserController@leave_team');
        Route::post('user/get_team_members', 'API\UserController@get_team_members');
        Route::post('user/recommend_user', 'API\UserController@recommend_user');
        Route::post('user/get_audience', 'API\UserController@get_audience');
        Route::post('user/view_profile', 'API\UserController@view_profile');
        Route::post('user/report_user', 'API\UserController@report_user');

        //feed
        Route::post('feed/get_sports_feeds', 'API\FeedController@get_sports_feeds');
        Route::post('feed/get_my_feeds', 'API\FeedController@get_my_feeds');
        Route::post('feed/get_all_feeds_by_user', 'API\FeedController@get_all_feeds_by_user');
        Route::post('feed/save_feed', 'API\FeedController@save_feed');
        Route::post('feed/add_view_feed', 'API\FeedController@add_view_feed');
        Route::post('like/like_feed', 'API\FeedController@like_feed');
        Route::post('feed/private_feed', 'API\FeedController@private_feed');
        Route::post('feed/search_video_feeds', 'API\FeedController@search_video_feeds');
        Route::post('feed/report_feed', 'API\FeedController@report_feed');
        Route::post('feed/delete_feed', 'API\FeedController@delete_feed');

        //result summary
        Route::post('result/save_result', 'API\ResultController@save_result');
        Route::post('result/get_club_month_summary', 'API\ResultController@get_club_month_summary');
        Route::post('result/get_user_summary', 'API\ResultController@get_user_summary');
        Route::post('result/get_sport_summary', 'API\ResultController@get_sport_summary');
        Route::post('result/get_year_summary', 'API\ResultController@get_year_summary');
        Route::post('result/get_club_summary', 'API\ResultController@get_club_summary');
        Route::post('result/delete_user_club_summary', 'API\ResultController@delete_user_club_summary');
        Route::post('result/get_club_year_summary', 'API\ResultController@get_club_year_summary');
        Route::post('result/delete_club_year_summary', 'API\ResultController@delete_club_year_summary');
        Route::post('result/adjust_summary', 'API\ResultController@adjust_summary');
        Route::post('result/get_summary_by_club', 'API\ResultController@get_summary_by_club');

        //prize
        Route::post('prize/get_all_prizes_by_user', 'API\PrizeController@get_all_prizes_by_user');
        Route::post('prize/save_prize', 'API\PrizeController@save_prize');
        Route::post('prize/delete_prize', 'API\PrizeController@delete_prize');
        //Career
        Route::post('career/save_career', 'API\CareerController@save_career');
        Route::post('career/get_all_careers_by_userid', 'API\CareerController@get_all_careers_by_userid');
        Route::post('career/delete_career', 'API\CareerController@delete_career');
        //Description
        Route::post('description/update_description', 'API\DescriptController@update_description');
        Route::post('description/get_all_descriptions_by_userid', 'API\DescriptController@get_all_descriptions_by_userid');
        //Admob
        Route::post('admob/save_admob', 'API\AdmobController@save_admob');
        Route::post('admob/get_all_admobs', 'API\AdmobController@get_all_admobs');
        Route::post('admob/filter_admobs', 'API\AdmobController@filter_admobs');
        // Route::post('admob/filter_admobs', 'API\UserController@filter_admobs');
        Route::post('admob/delete_admob', 'API\AdmobController@delete_admob');
        //Follow
        Route::post('follow/add_follow', 'API\FollowController@add_follow');
        Route::post('follow/delete_follow', 'API\FollowController@delete_follow');
        Route::post('follow/check_follow', 'API\FollowController@check_follow');
        Route::post('follow/get_following', 'API\FollowController@get_following');
        Route::post('follow/get_follower', 'API\FollowController@get_follower');
        //Block
        Route::post('block/get_blocked_users', 'API\BlockController@get_blocked_users');
        Route::post('block/add_block', 'API\BlockController@add_block');
        Route::post('block/remove_block', 'API\BlockController@remove_block');
        //Bookmark
        Route::post('bookmark/save_bookmark', 'API\BookmarkController@save_bookmark');
        Route::post('bookmark/get_bookmarks', 'API\BookmarkController@get_bookmarks');

        //Notifications
        Route::post('alarm/get_all_notifications', 'API\AlarmController@get_all_notifications');
        Route::post('alarm/remove_notification', 'API\AlarmController@remove_notification');
        Route::post('alarm/push_chat_notification', 'API\AlarmController@push_chat_notification');

        //Story
        Route::post('story/save_story', 'API\StoryController@save_story');
        Route::post('story/get_all_story', 'API\StoryController@get_all_story');
        Route::post('story/get_stories_user', 'API\StoryController@get_stories_by_user');
        Route::post('story/reply_story', 'API\StoryController@reply_story');
        Route::post('story/view_story', 'API\StoryController@view_story');
        Route::post('story/get_story_views', 'API\StoryController@get_story_views');
        Route::post('story/get_story_msg', 'API\StoryController@get_story_msg');
        Route::post('story/delete_story', 'API\StoryController@delete_story');
        Route::post('story/get_view_statics', 'API\StoryController@get_view_statics');
        Route::post('story/report_story', 'API\StoryController@report_story');
    });
});
