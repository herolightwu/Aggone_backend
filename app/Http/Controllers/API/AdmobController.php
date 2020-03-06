<?php

namespace App\Http\Controllers\API;

use App\Models\Admob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdmobController extends APIController
{
    /**
     * save_admob api
     * @return \Illuminate\Http\Response
     */
    public function save_admob(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'sport_id' => 'required',
            'city' => 'required',
            'position' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $admob = Admob::create([
            'user_id' => $user->id,
            'sport_id' => $input['sport_id'],
            'position' => $input['position'],
            'description' => $input['description'],
            'city' => $input['city'],
        ]);

        $ret_ad = Admob::query()->where('id', $admob->id)->with('user')->first();
        if ($ret_ad){
            return response()->json(['status' => true, 'admob' => $ret_ad], $this->successStatus);
        } else{
            return response()->json(['status' => false, 'error' => 'Failed save'], $this->failedStatus);
        }
    }

    /**
     * get_all_admobs api
     * @return \Illuminate\Http\Response
     */
    public function get_all_admobs(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }

        $admobs = Admob::with('user')->where('user_id', $user->id)->get();
        return response()->json(['status' => true, 'count' => count($admobs), 'admobs' => $admobs], $this->successStatus);
    }

    /**
     * delete_admob api
     * @return \Illuminate\Http\Response
     */
    public function delete_admob(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'admob_id' => 'required',
        ]);

        $admob = Admob::find($input['admob_id']);
        if(isset($admob)){
            $admob->delete();
        }
        return response()->json(['status' => true], $this->successStatus);
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

        $con = 'sport_id = '.$input['sport_id'];
        if ($input['city'] != ''){
            $con = $con.' and city like '."'%".$input['city']."%'";
        }
//        if ($input['country'] != ''){
//            $con = $con.' and country like '."'%".$input['country']."%'";
//        }
        $admobs = Admob::with('user')->whereRaw($con)->get();
        return response()->json(['status' => true, 'count' => count($admobs), 'admobs' => $admobs], $this->successStatus);
    }
}
