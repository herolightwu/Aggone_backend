<?php

namespace App\Http\Controllers\API;

use App\Models\Block;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlockController extends APIController
{
    /**
     * get_blocked_users api
     * @return \Illuminate\Http\Response
     */
    public function get_blocked_users()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }

        $blocks = Block::query()->where('user_id', $user->id)->get();

        $blockeds = array();
        $count = 0;
        foreach ($blocks as $block){
            $user = User::find($block->blocked_id);
            if($user){
                $count++;
                array_push($blockeds, $user);
            }

        }

        return response()->json(['status' => true, 'count' => $count, 'blocks' => $blockeds], $this->successStatus);
    }

    /**
     * add_block api
     * @return \Illuminate\Http\Response
     */
    public function add_block(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'blocked_user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $con = 'user_id = '.$user->id.' and blocked_id = '.$input['blocked_user_id'];
        $blocks = Block::query()->whereRaw($con)->get();

        if(count($blocks) == 0)
            $block = Block::create([
                'user_id' => $user->id,
                'blocked_id' => $input['blocked_user_id'],
            ]);

        return response()->json(['status' => true], $this->successStatus);
    }

    /**
     * remove_block api
     * @return \Illuminate\Http\Response
     */
    public function remove_block(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'error' => 'Invalid user'], $this->failedStatus);
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'blocked_user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $con = 'user_id = '.$user->id.' and blocked_id = '.$input['blocked_user_id'];
        $blocks = Block::query()->whereRaw($con)->get();

        foreach ($blocks as $block)
        {
            $ret = Block::find($block->id);
            $ret->delete();
        }

        return response()->json(['status' => true], $this->successStatus);
    }
}
