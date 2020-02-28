<?php

namespace App\Http\Controllers\API;

use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CareerController extends APIController
{
    /**
     * save_career api
     * @return \Illuminate\Http\Response
     */
    public function save_career(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'position' => 'required',
            'sport_id' => 'required',
            'club' => 'required',
            'location' => 'required',
            'year' => 'required',
            'month' => 'required',
            'day' => 'required',
            'tyear' => 'required',
            'tmonth' => 'required',
            'tday' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $career = Career::create($input);
        if (isset($input['logo'])){
            $career->logo = $input['logo'];
            $career->save();
        }
        return response()->json(['status' => true, 'career' => $career], $this->successStatus);
    }

    /**
     * get_all_careers_by_userid api
     * @return \Illuminate\Http\Response
     */
    public function get_all_careers_by_userid(Request $request)
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

        $careers = Career::query()->where('user_id', $input['user_id'])->get();
        return response()->json(['status' => true, 'count' => count($careers), 'careers' => $careers], $this->successStatus);
    }

    /**
     * delete_career api
     * @return \Illuminate\Http\Response
     */
    public function delete_career(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'career_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $career = Career::find($input['career_id']);
        $career->delete();
        return response()->json(['status' => true], $this->successStatus);
    }
}
