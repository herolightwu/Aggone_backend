<?php

namespace App\Http\Controllers\API;

use App\Models\Prize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PrizeController extends APIController
{
    /**
     * get_all_prizes_by_user api
     * @return \Illuminate\Http\Response
     */
    public function get_all_prizes_by_user(Request $request){
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

        $prizes = Prize::query()->where('user_id', $input['user_id'])->get();
        return response()->json(['status' => true, 'count' => count($prizes), 'prizes' => $prizes], $this->successStatus);
    }
    /**
     * save_prize api
     * @return \Illuminate\Http\Response
     */
    public function save_prize(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'title' => 'required',
            'club' => 'required',
            'year' => 'required',
            'icon' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $prize = Prize::create($input);
        return response()->json(['status' => true, 'prize' => $prize], $this->successStatus);
    }

    /**
     * delete_prize api
     * @return \Illuminate\Http\Response
     */
    public function delete_prize(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'prize_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $prize = Prize::find($input['prize_id']);
        $prize->delete();
        return response()->json(['status' => true], $this->successStatus);
    }
}
