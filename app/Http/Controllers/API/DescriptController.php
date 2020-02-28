<?php

namespace App\Http\Controllers\API;

use App\Models\Descript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DescriptController extends APIController
{
    /**
     * update_description api
     * @return \Illuminate\Http\Response
     */
    public function update_description(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $con = 'user_id = '.$input['user_id'].' and type = '.$input['type'];
        $desc = Descript::query()->whereRaw($con)->first();
        if($desc){
            $update_desc = Descript::find($desc->id);
            $update_desc->value = $input['value'];
            $update_desc->save();
        } else{
            $update_desc = Descript::create([
                'user_id' => $input['user_id'],
                'type' => $input['type'],
                'value' => $input['value'],
            ]);
        }
        return response()->json(['status' => true, 'description' => $update_desc], $this->successStatus);
    }

    /**
     * get_all_descriptions_by_userid api
     * @return \Illuminate\Http\Response
     */
    public function get_all_descriptions_by_userid(Request $request)
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

        $descs = Descript::query()->where('user_id', $input['user_id'])->get();
        return response()->json(['status' => true, 'count' => count($descs), 'descriptions' => $descs], $this->successStatus);
    }
}
