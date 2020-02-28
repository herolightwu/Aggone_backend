<?php

namespace App\Http\Controllers\API;

use App\Models\Feed;
use App\Models\Feed_like;
use App\Models\Recommend;
use App\Models\Report;
use App\Models\Resume;
use App\Models\Strength;
use App\Models\Team;
use App\Models\User;
use App\Models\UserView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\MockObject\Exception;

class UserController extends APIController
{

    const RESUME_PATH = '/uploads/resumes/';
    /**
     * sign_up api
     *
     * @return \Illuminate\Http\Response
     */
    public function sign_up(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'push_token' => 'required',
        ]);

        if ($validator->fails()) {
            $err = ['code' => APIController::$invalidParamsCode, 'msg' => $validator->errors()];
            //return response()->json(['success'=>0, 'error'=>$err], $this->failedStatus);
            return response()->json(['status' => true, 'error' => 'Email & password field is required.'], $this->failedStatus);
        }

        $input = $request->all();
        $name_str = explode("@", $input['email']);
        $input['username'] = $name_str[0];
        $input['password'] = bcrypt($input['password']);
        $res = User::query()->where('email', $input['email'])->get();
        if (count($res) > 0) {
            return response()->json(['status' => false, 'error' => 'Email is already exist, please use other email', 'errcode' => APIController::$emailExist], $this->failedStatus);
        }
        // here begin with try original
        try {
            $user = User::create($input);
            $user->push_token = $input['push_token'];
            $user->save();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['user'] = $user;
            $success['status'] = true;

            return response()->json($success, $this->successStatus);
        } catch (Exception $err) {
            return response()->json(['status' => false, 'error' => 'this is error failed try catch'], $this->failedStatus);
        }
    }
    /**
     * getUserByEmail api
     *
     * @return \Illuminate\Http\Response
     */
    public function get_user_by_email(Request $request){
        $input = $request->all();
        $res = User::query()->where('email', $input['email'])->first();
        if(!$res){
            //return $this->responseFailed('Don\'t exists.');//, APIController::$emailNotExistCode
            return response()->json(['status'=>false, 'error'=>'Don\'t exist'], $this-> successStatus);
        }
        return response()->json(['status'=>true, 'user'=>$res], $this-> successStatus);
    }

    /**
     * update_user_field api
     *
     * @return \Illuminate\Http\Response
     */
    public function update_user_field(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'key' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'error'=>'Missing Parameters'], $this-> failedStatus);
        }

        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }

        $user = User::find($user->id);
        if($input['key'] == 'web_url') {
            $user->web_url = $input['value'];
            $user->save();
        } else if($input['key'] == 'phone') {
            $user->phone = $input['value'];
            $user->save();
        } else if($input['key'] == 'desc_str') {
            $user->desc_str = $input['value'];
            $user->save();
        } else if($input['key'] == 'available_club') {
            $user->available_club = $input['value'];
            $user->save();
        } else if($input['key'] == 'email') {
            $users = User::query()->where('email', $input['value'])->get();
            if(count($users) == 0){
                $user->email = $input['value'];
                $user->save();
            } else {
                return response()->json(['status'=>false, 'error'=>'Existed email address'], $this-> failedStatus);
            }

        } else{
            return response()->json(['status'=>false, 'error'=>'Unknown field'], $this-> successStatus);
        }
        $recommends = Recommend::query()->where('user_id', $user->id)->get();
        $user['recommends'] = count($recommends);
        return response()->json(['status'=>true, 'user'=>$user], $this-> successStatus);
    }
    /**
     * update_user api
     *
     * @return \Illuminate\Http\Response
     */
    public function update_user(Request $request){
        //$request->merge((array)json_decode($request->getContent()));
        $u_data = $request->all();
        $validator = Validator::make($u_data, [
            'username' => 'required',
            'email' => 'required',
            'year'=>'required',
            'month'=>'required',
            'day'=>'required',
            'age'=>'required',
            'group_id'=>'required',
            'sport_id'=>'required',
            'height'=>'required',
            'weight'=>'required',
            'gender_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'error'=>'Missing Parameters'], $this-> failedStatus);
        }

        //$user = User::query()->where('email', $u_data['email'])->first();
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $update_data = ['username' => $u_data['username'],
            'year' => $u_data['year'],
            'month' => $u_data['month'],
            'day' => $u_data['day'],
            'age' => $u_data['age'],
            'group_id' => $u_data['group_id'],
            'sport_id' => $u_data['sport_id'],
            'height' => $u_data['height'],
            'weight' => $u_data['weight'],
            'gender_id' => $u_data['gender_id']];
        $retVal = $user->update($update_data);
        if (!$retVal){
            return response()->json(['status'=>false, 'error'=>'User update failed.'], $this-> failedStatus);
        } else{
            $updated_user = User::find($user->id);
            if (isset($u_data['photo_url'])){
                $updated_user->photo_url = $u_data['photo_url'];
                $updated_user->save();
            }
            if (isset($u_data['position'])){
                $updated_user->position = $u_data['position'];
                $updated_user->save();
            }
            if (isset($u_data['category'])){
                $updated_user->category = $u_data['category'];
                $updated_user->save();
            }
            if (isset($u_data['club'])){
                $updated_user->club = $u_data['club'];
                $updated_user->save();
            }
            if (isset($u_data['city'])){
                $updated_user->city = $u_data['city'];
                $updated_user->save();
            }
            if (isset($u_data['country'])){
                $updated_user->country = $u_data['country'];
                $updated_user->save();
            }
            if (isset($u_data['contract'])){
                $updated_user->contract = $u_data['contract'];
                $updated_user->save();
            }


            $relate = DB::table("user_user_group")->where([['user_id', $updated_user->id], ['user_group_id', $updated_user->group_id]])->get();
            if (count($relate) <= 0){
                DB::table('user_user_group')->insert([
                    'user_id' => $updated_user->id,
                    'user_group_id' => $updated_user->group_id,
                ]);
            } else{
                DB::table("user_user_group")->where('user_id', $updated_user->id)->update(['user_group_id' => $updated_user->group_id]);
            }
            $recommends = Recommend::query()->where('user_id', $updated_user->id)->get();
            $updated_user['recommends'] = count($recommends);
            return response()->json(['status'=>true, 'user'=>$updated_user], $this-> successStatus);
        }
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => 'required',
            'password' => 'required',
            'push_token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false, 'error'=>'Missing Parameters'], $this-> successStatus);
        }
        $res = User::query()->where('email', $input['email'])->get();
        if(count($res)<= 0){
            //return $this->responseFailed('Account is not exists. Please sign up.');
            return response()->json(['status'=>false, 'error'=>'Account is not exists. Please sign up.'], $this-> successStatus);
        }
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $token = $user->createToken('MyApp')-> accessToken;
            $user->push_token = $input['push_token'];
            $user->save();
            $recommends = Recommend::query()->where('user_id', $user->id)->get();
            $user['recommends'] = count($recommends);
            $success['token'] =  $token;
            $success['user'] = $user;
            $success['status'] = true;

            return response()->json($success, $this-> successStatus);
        } else{
            return $this->responseFailed('Password is not correct.');
        }
    }
    /**
     * login_social api
     *
     * @return \Illuminate\Http\Response
     */
    public function login_social(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => 'required',
            'username' => 'required',
            'photo_url' => 'required',
            'push_token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false, 'error'=>'Missing Parameters'], $this-> failedStatus);
        }
        $res = User::query()->where('email', $input['email'])->first();
        if(!$res){
            $input['password'] = '123456';
            $input['password'] = bcrypt($input['password']);
            try{
                $user = User::create($input);
                $user->photo_url = $input['photo_url'];
                $user->username = $input['username'];
                $user->push_token = $input['push_token'];
                $user->save();
                $recommends = Recommend::query()->where('user_id', $user->id)->get();
                $user['recommends'] = count($recommends);

                $success['token'] =  $user->createToken('MyApp')-> accessToken;
                $success['user'] = $user;
                $success['status'] = true;
                return response()->json($success, $this-> successStatus);
            }catch (Exception $err){
                return response()->json(['status'=>false, 'error'=>'Create account failed.'], $this-> failedStatus);
            }
        } else{
            $user = User::find($res->id);
            $user->username = $input['username'];
            if (!isset($user->photo_url)) {
                $user->photo_url = $input['photo_url'];
            }
            $user->push_token = $input['push_token'];
            $user->save();
            $recommends = Recommend::query()->where('user_id', $user->id)->get();
            $user['recommends'] = count($recommends);

            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['user'] = $user;
            $success['status'] = true;
            return response()->json($success, $this-> successStatus);
        }
    }
    /**
     * forgot_password api
     *
     * @return \Illuminate\Http\Response
     */
    public function forgot_password(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false, 'error'=>'Missing Parameter'], $this-> failedStatus);
        }

        $user = User::where('email', $input['email'])->first();
        if (!$user)
            return $this->responseFailed('Can\'t find a user with that e-mail address.');
        $newPass = $this->generateRandomString();
        $user->password = bcrypt($newPass);
        $user->save();
        // TODO: send email to user
        //=========send email ======================
        $to = $request->email; // Send email to our user
        $subject = 'New Aggone Password'; // Give the email a subject
        $message = '<center>
  				<h2>New Password</h2><br>
				<p>Please find your new password below. You can use this new password to login to</p>
				<p> the Aggone app. Once you\'ve logged in, you can change your password</p>
				 <p>by selecting <b>Change Password</b> from the app menu.</p>

            	<br>
            	<b>New Password:</b> ' . $newPass . '<p>
            	-------------------------------------

            	<h4>Thanks for choosing Aggone.</h4>
				</center>';

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: noreply@aggone.org' . "\r\n" .
            'Reply-To: noreply@aggone.org' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();// Set from headers
        mail($to, $subject, $message, $headers); // Send our email

        return response()->json(['status'=>true, 'data'=>'Reset password success.'], $this-> successStatus);
    }
    /**
     * get_users_by_filter api
     *
     * @return \Illuminate\Http\Response
     */
    public function get_users_by_filter(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'group_id' => ['required', 'numeric'],
            'sport_id' => ['required', 'numeric'],
            'gender_id' => ['required', 'numeric'],
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);
        $con = 'sport_id = '.$input['sport_id'].' and gender_id = '.$input['gender_id'].' and group_id = '.$input['group_id'];
        if ($input['group_id'] == config('constants.GROUP_PLAYER')){
            if ($input['age'] != 0 && $input['height'] != 0 && $input['weight'] != 0)
            {
                $con = $con.' and age > '.$input['age'].' and height > '.$input['height'].' and weight < '.$input['weight'];
            }
        } else{
            if ($input['country'] != ''){
                $con = $con." and country = '".$input['country']."'";
            }
        }
        $users = Array();
        if($input['name'] == '' && $input['city'] != ''){
            $con = $con." and city = '".$input['city']."'";
        } else if($input['name'] != '' && $input['city'] == '') {
            $con = $con.' and username like '."'%".$input['name']."%'";
        } else if($input['name'] != '' && $input['city'] != ''){
            $con = $con.' and username like '."'%".$input['name']."%' and city = '".$input['city']."'";
        }
        $users = User::query()->whereRaw($con)->get();
        foreach ($users as $user){
            $recommends = Recommend::query()->where('user_id', $user->id)->get();
            $user['recommends'] = count($recommends);
        }
        return response()->json(['status'=>true, 'count'=>count($users), 'users'=>$users], $this-> successStatus);
    }

    /**
     * filter_admobs api
     * @return \Illuminate\Http\Response
     */
    public function filter_admobs(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'sport_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $con = 'sport_id = '.$input['sport_id'].' and group_id = '.config('constants.GROUP_CLUB');
        if ($input['city'] != ''){
            $con = $con.' and city like '."'%".$input['city']."%'";
        }
//        if ($input['country'] != ''){
//            $con = $con.' and country like '."'%".$input['country']."%'";
//        }
        $admobs = User::query()->whereRaw($con)->get();
        foreach ($admobs as $ad){
            $ad['user_id'] = $ad->id;
            $ad['description'] = $ad->desc_str;
            $ad['user'] = User::find($ad->id);
        }
        return response()->json(['status' => true, 'count' => count($admobs), 'admobs' => $admobs], $this->successStatus);
    }
    /**
     * get_users_by_type api
     *
     * @return \Illuminate\Http\Response
     */
    public function get_users_by_type(Request $request){
        $user = Auth::user();
        if(!$user)
            return response()->json(['status'=>false, 'error'=>'Invalid user.'], $this-> failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'group_id' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>'Missing Parameter'], $this-> failedStatus);

        $users = User::query()->where('group_id', $input['group_id'])->get();
        foreach ($users as $user){
            $recommends = Recommend::query()->where('user_id', $user->id)->get();
            $user['recommends'] = count($recommends);
        }
        return response()->json(['status'=>true, 'count'=>count($users), 'users'=>$users], $this-> successStatus);
    }

    /**
     * get_all_users api
     *
     * @return \Illuminate\Http\Response
     */
    public function get_all_users(Request $request){
        $user = Auth::user();
        if(!$user)
            return response()->json(['status'=>false, 'error'=>'Invalid user.'], $this-> failedStatus);

        $con = 'sport_id > 500 and id <> '.$user->id ;
        $users = User::query()->whereRaw($con)->get();
        foreach ($users as $user){
            $recommends = Recommend::query()->where('user_id', $user->id)->get();
            $user['recommends'] = count($recommends);
        }
        return response()->json(['status'=>true, 'count'=>count($users), 'users'=>$users], $this-> successStatus);
    }

    /**
     * search_users api
     *
     * @return \Illuminate\Http\Response
     */
    public function search_users(Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);
        $con = "username like '%".$input['name']."%'";
        $users = User::query()->whereRaw($con)->orderBy('username')->get();
        foreach ($users as $user){
            $recommends = Recommend::query()->where('user_id', $user->id)->get();
            $user['recommends'] = count($recommends);
        }
        return response()->json(['status'=>true, 'count'=>count($users), 'users'=>$users], $this-> successStatus);
    }

    /**
     * change_password api
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password(Request $request){
        $user = Auth::user();
        if(!$user)
            return response()->json(['status'=>false, 'error'=>'Invalid user.'], $this-> failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'password' => 'required'
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);

        $users = User::find($user->id);
        $user->password = bcrypt($input['password']);
        $user->save();
        return response()->json(['status'=>true], $this-> successStatus);
    }

    /**
     * upload_image api
     * @return \Illuminate\Http\Response
     */
    public function upload_image(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing filename'], $this->failedStatus);
        }
        if ($request->hasFile('image')){
            $ifile = $request->file('image');
            $ifilename = $request->get('name').".".$ifile->extension();
            $ipath = public_path().FeedController::IMAGE_PATH;
            if (!File::isDirectory($ipath)){
                File::makeDirectory($ipath, 0777, true, true);
            }
            $ifile->move($ipath, $ifilename);
            return response()->json(['status' => true, 'image_url' => $ifilename], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'error' => 'Missing files'], $this->failedStatus);
        }
    }

    /**
     * upload_resume api
     * @return \Illuminate\Http\Response
     */
    public function upload_resume(Request $request){
        $user = Auth::user();
        if(!$user)
            return response()->json(['status'=>false, 'error'=>'Invalid user.'], $this-> failedStatus);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing filename'], $this->failedStatus);
        }
        if ($request->hasFile('pdf')){
            $ifile = $request->file('pdf');
            $ifilename = $request->get('name');
            $ipath = public_path().UserController::RESUME_PATH;
            if (!File::isDirectory($ipath)){
                File::makeDirectory($ipath, 0777, true, true);
            }
            $ifile->move($ipath, $ifilename);
            $resume = Resume::create([
                'user_id' => $user->id,
                'resume_url' => $ifilename,
            ]);
            return response()->json(['status' => true, 'resume_url' => $ifilename], $this->successStatus);
        } else {
            return response()->json(['status' => false, 'error' => 'Missing files'], $this->failedStatus);
        }
    }

    /**
     * get_all_resumes api
     * @return \Illuminate\Http\Response
     */
    public function get_all_resumes(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['status' => false, 'error' => 'Invalid user.'], $this->failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required'
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);
        $resumes = Resume::query()->where('user_id', $input['user_id'])->get();
        return response()->json(['status'=>true, 'count'=>count($resumes), 'resumes' => $resumes], $this-> successStatus);
    }

    /**
     * delete_resume api
     * @return \Illuminate\Http\Response
     */
    public function delete_resume(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['status' => false, 'error' => 'Invalid user.'], $this->failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'id' => 'required'
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);

        $resume = Resume::find($input['id']);
        $resume->delete();
        return response()->json(['status'=>true], $this-> successStatus);
    }

    /**
     * get_strengths api
     * @return \Illuminate\Http\Response
     */
    public function get_strengths(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['status' => false, 'error' => 'Invalid user.'], $this->failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'uid' => 'required'
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);

        $strengths = Strength::query()->where('user_id', $input['uid'])->first();
        if ($strengths){
            return response()->json(['status'=>true, 'strength'=>$strengths->strength], $this-> successStatus);
        } else{
            return response()->json(['status'=>true, 'strength'=>""], $this-> successStatus);
        }
    }

    /**
     * save_strengths api
     * @return \Illuminate\Http\Response
     */
    public function save_strengths(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['status' => false, 'error' => 'Invalid user.'], $this->failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'strength' => 'required'
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);

        $old_strength = Strength::query()->where('user_id', $user->id)->first();
        if ($old_strength){
            $strength = Strength::find($old_strength->id);
            $strength->strength = $input['strength'];
            $strength->save();
        } else{
            $strength = Strength::create([
                'user_id' => $user->id,
                'strength' => $input['strength'],
            ]);
        }
        return response()->json(['status'=>true], $this-> successStatus);
    }

    /**
     * get_tagged_users api
     * @return \Illuminate\Http\Response
     */
    public function get_tagged_users(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['status' => false, 'error' => 'Invalid user.'], $this->failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'tagged' => 'required'
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);

        $ids = explode(",", $input['tagged']);
        $result = array();
        foreach ($ids as $id){
            if ($id != ''){
                $user = User::find($id);
                if(isset($user)){
                    $recommends = Recommend::query()->where('user_id', $user->id)->get();
                    $user['recommends'] = count($recommends);
                    $result[] = $user;
                }
            }
        }
        return response()->json(['status'=>true, 'users'=> $result], $this-> successStatus);
    }

    /**
     * get_team_members api
     * @return \Illuminate\Http\Response
     */
    public function get_team_members(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['status' => false, 'error' => 'Invalid user.'], $this->failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'team_id' => 'required'
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);

        $users = Team::query()->where('team_id', $input['team_id'])->with('user')->get('user_id');

        foreach ($users as $uu){
            $recommends = Recommend::query()->where('user_id', $uu->user_id)->get();
            $uu->user['recommends'] = count($recommends);
        }
        return response()->json(['status'=>true, 'team'=> $users], $this-> successStatus);
    }

    /**
     * join_team api
     * @return \Illuminate\Http\Response
     */
    public function join_team(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['status' => false, 'error' => 'Invalid user.'], $this->failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'team_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);

        $info = Team::query()->where('team_id', $input['team_id'])->where('user_id', $input['user_id'])->first();
        if ($info){
            return response()->json(['status'=>true], $this-> successStatus);
        }
        $ret = Team::create([
            'team_id' => $input['team_id'],
            'user_id' => $input['user_id'],
        ]);
        if($ret)
            return response()->json(['status'=>true], $this-> successStatus);
        else
            return response()->json(['status'=>false], $this-> successStatus);
    }

    /**
     * leave_team api
     * @return \Illuminate\Http\Response
     */
    public function leave_team(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['status' => false, 'error' => 'Invalid user.'], $this->failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'team_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);

        $info = Team::query()->where('team_id', $input['team_id'])->where('user_id', $input['user_id'])->first();

        if($info){
            $ret = Team::find($info->id);
            $ret->delete();
            return response()->json(['status'=>true], $this-> successStatus);
        }
        return response()->json(['status'=>false], $this-> successStatus);
    }

    /**
     * recommend_user api
     * @return \Illuminate\Http\Response
     */
    public function recommend_user(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['status' => false, 'error' => 'Invalid user.'], $this->failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);

        $cond = 'user_id = '.$input['user_id'].' and recommend_id = '.$user->id;
        $recommend = Recommend::query()->whereRaw($cond)->first();
        if(isset($recommend)){
            $recommend = Recommend::find($recommend->id);
            $recommend->delete();
        } else{
            $recommend = Recommend::create([
                'user_id' => $input['user_id'],
                'recommend_id' => $user->id,
            ]);
        }

        $recommends = Recommend::query()->where('user_id', $input['user_id'])->get();

        return response()->json(['status'=>true, 'count' => count($recommends)], $this-> successStatus);
    }

    /**
     * view_profile api
     * @return \Illuminate\Http\Response
     */
    public function view_profile(Request $request){
        $user = Auth::user();
        if (!$user)
            return response()->json(['status' => false, 'error' => 'Invalid user.'], $this->failedStatus);
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status'=>false, 'error'=>$validator->errors()->getMessages()], $this-> failedStatus);

        if($user->id != $input['user_id']){
            $cond = 'user_id = '.$input['user_id'].' and viewed_id = '.$user->id;
            $uview = UserView::query()->whereRaw($cond)->first();
            if(!isset($uview)){
                UserView::create([
                    'user_id' => $input['user_id'],
                    'viewed_id' => $user->id,
                ]);
            }
        }

        $recommends = Recommend::query()->where('user_id', $input['user_id'])->get();
        return response()->json(['status'=>true, 'recommend' => count($recommends)], $this-> successStatus);
    }

    /**
     * get_audience api
     * @return \Illuminate\Http\Response
     */
    public function get_audience(Request $request){
        $user = Auth::user();
        if (!$user)
            return response()->json(['status' => false, 'error' => 'Invalid user.'], $this->failedStatus);

        $club_ct = 0;
        $agent_ct = 0;
        $coach_ct = 0;
        $company_ct = 0;
        $player_ct = 0;
        $staff_ct = 0;
        $total_ct = 0;

        $views = UserView::query()->where('user_id', $user->id)->with('user')->get();
        $total_ct = count($views);
        foreach ($views as $view){
            $viewer = $view['user'];
            if($viewer['group_id'] == config('constants.GROUP_PLAYER')){
                $player_ct++;
            } else if ($viewer['group_id'] == config('constants.GROUP_COACH')){
                $coach_ct++;
            } else if ($viewer['group_id'] == config('constants.GROUP_CLUB')){
                $club_ct++;
            } else if ($viewer['group_id'] == config('constants.GROUP_AGENT')){
                $agent_ct++;
            } else if ($viewer['group_id'] == config('constants.GROUP_COMPANY')){
                $company_ct++;
            } else{
                $staff_ct++;
            }
        }
        $cond = 'user_id = '.$user->id.' and ( type = 0 or type = 1)';
        $view_video = Feed::query()->whereRaw($cond)->sum('view_count');
        $feed_group = Feed::query()->whereRaw($cond)->get();
        $star_ct = 0;
        foreach ($feed_group as $feed){
            $likes = Feed_like::query()->where('feed_id', $feed->id)->get();
            $star_ct += count($likes);
        }
        $result['view_video'] = $view_video;
        $result['total_profile'] = $total_ct;
        $result['player'] = $player_ct;
        $result['coach'] = $coach_ct;
        $result['agent'] = $agent_ct;
        $result['club'] = $club_ct;
        $result['company'] = $company_ct;
        $result['staff'] = $staff_ct;
        $result['star_video'] = $star_ct;
        return response()->json(['status'=>true, 'result' => $result], $this-> successStatus);
    }

    /**
     * report_user api
     * @return \Illuminate\Http\Response
     */
    public function report_user(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'report' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $other = User::find($input['user_id']);
        $user = User::find($user->id);
        //=========send email ======================
        $to = "aggone.inc@aggone.org"; // Send email to our user
        $subject = 'Report for '.$other->username; // Give the email a subject
        $message = '<center>
  				<h2>Report for '.$other->username.'</h2><br>
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
            'type' => 1,//user->1, feed->2 (default), story->3
            'rep_id' => $other->id,
            'description' => $input['report'],
        ]);
        return response()->json(['status' => true], $this->successStatus);
    }

    function generateRandomString($length = 6) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}
