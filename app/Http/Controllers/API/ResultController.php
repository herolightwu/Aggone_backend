<?php

namespace App\Http\Controllers\API;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResultController extends APIController
{
    /**
     * get_summary_by_club api
     * @return \Illuminate\Http\Response
     */
    public function get_summary_by_club(Request $request){
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

        $clubs = Result::query()->where('user_id', $input['user_id'])->select('club')->groupBy('club')->get();
        $skills = array();
        foreach ($clubs as $club){
            //yearly data
            $cb_skills = array();
            $cond = 'user_id = '.$input['user_id']." and club = '".$club->club."'";
            $years = Result::query()->whereRaw($cond)->select('year')->groupBy('year')->orderBy('year', 'desc')->get();
            $yr_skills = array();
            foreach ($years as $year){
                $obj_skill = array();
                $cond_club = 'user_id = '.$input['user_id']." and club = '".$club->club."' and year = ".$year->year;
                $yr_results = Result::query()->whereRaw($cond_club)->select('type', DB::raw('sum(value) as total'))->groupBy('type')->get();
                $yr_json = array();
                foreach ($yr_results as $result){
                    $yr_json[$result->type] = $result->total;
                }
                $obj_skill['name'] = $year->year;
                $obj_skill['value'] = $yr_json;
                $yr_skills[] = $obj_skill;
            }
            $cb_skills['years'] = $yr_skills;
            //monthly data
            $rets = array();
            for($i = 1; $i <= 12; $i++ ){
                $cond = 'user_id = '.$input['user_id']." and club = '".$club->club."' and month = ".$i;
                $results = Result::query()->whereRaw($cond)->select('type', DB::raw('sum(value) as total'))->groupBy('type')->get();
                $json = array();
                foreach ($results as $result){
                    $json[$result->type] = $result->total;
                }
                $rets[] = $json;
            }
            $cb_skills['data'] = $rets;
            $cb_skills['name'] = $club->club;
            $skills[] = $cb_skills;
        }
        return response()->json(['status' => true, 'result' => $skills], $this->successStatus);
    }
    /**
     * adjust_summary api
     * @return \Illuminate\Http\Response
     */
    public function adjust_summary(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'sport_id' => 'required',
            'club' => 'required',
            'year' => 'required',
            'month' => 'required',
            'type' => 'required',
            'value_type' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $cond = 'user_id = '.$input['user_id'].' and sport_id = '.$input['sport_id']." and club = '".$input['club']."' and year = ".$input['year'].' and month = '.$input['month']." and type = '".$input['type']."'";
        $result = Result::query()->whereRaw($cond)->first();
        if(isset($result)){
            $result = Result::find($result->id);
            if($input['value_type'] == 1){
                $result->value += 1;
                $result->save();
            } else if ($input['value_type'] == -1){
                if ($result->value > 0){
                    $result->value -= 1;
                    $result->save();
                } else{
                    return response()->json(['status' => false, 'error' => 'Cannot minus value'], $this->successStatus);
                }
            } else if ($input['value_type'] == 0){
                $result->value = $input['value'];
                $result->save();
            }

        } else {
            if($input['value_type'] == 1){
                $result = Result::create([
                    'user_id' => $input['user_id'],
                    'sport_id' => $input['sport_id'],
                    'club' => $input['club'],
                    'year' => $input['year'],
                    'month' => $input['month'],
                    'type' => $input['type'],
                    'value' => 1,
                ]);
            } else if ($input['value_type'] == 0){
                $result = Result::create([
                    'user_id' => $input['user_id'],
                    'sport_id' => $input['sport_id'],
                    'club' => $input['club'],
                    'year' => $input['year'],
                    'month' => $input['month'],
                    'type' => $input['type'],
                    'value' => $input['value'],
                ]);
            } else{
                return response()->json(['status' => false, 'error' => 'Cannot find defined data'], $this->successStatus);
            }
        }
        return response()->json(['status' => true], $this->successStatus);
    }
    /**
     * save_result api
     * @return \Illuminate\Http\Response
     */
    public function save_result(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'sport_id' => 'required',
            'club' => 'required',
            'year' => 'required',
            'month' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $cond = 'user_id = '.$input['user_id'].' and sport_id = '.$input['sport_id']." and club = '".$input['club']."' and year = ".$input['year'].' and month = '.$input['month']." and type = '".$input['type']."'";
        $result = Result::query()->whereRaw($cond)->first();
        if(isset($result)){
            $result = Result::find($result->id);
            $result->value = $input['value'];
            $result->save();
        } else {
            $result = Result::create($input);
        }
        return response()->json(['status' => true, 'result' => $result], $this->successStatus);
    }

    /**
     * delete_club_year_summary api
     * @return \Illuminate\Http\Response
     */
    public function delete_club_year_summary(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'club' => 'required',
            'year' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $cond = 'user_id = '.$input['user_id']." and club = '".$input['club']."' and year = ".$input['year'];
        Result::query()->whereRaw($cond)->delete();
        return response()->json(['status' => true], $this->successStatus);
    }

    /**
     * delete_user_club_summary api
     * @return \Illuminate\Http\Response
     */
    public function delete_user_club_summary(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'club' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $cond = 'user_id = '.$input['user_id']." and club = '".$input['club']."'";
        Result::query()->whereRaw($cond)->delete();
        return response()->json(['status' => true], $this->successStatus);
    }
    /**
     * get_club_month_summary api
     * @return \Illuminate\Http\Response
     */
    public function get_club_month_summary(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'sport_id' => 'required',
            'club' => 'required',
            'year' => 'required',
            'month' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $cond = 'user_id = '.$input['user_id'].' and sport_id = '.$input['sport_id']." and club = '".$input['club']."' and year = ".$input['year'].' and month = '.$input['month'];
        $results = Result::query()->whereRaw($cond)->select('type', DB::raw('sum(value) as total'))->groupBy('type')->get();
        $json = array();
        if(isset($results)){
            foreach ($results as $result){
                $json[$result->type] = $result->total;
            }
        }
        $rets = $json;
        return response()->json(['status' => true, 'result' => $rets], $this->successStatus);
    }

    /**
     * get_club_summary api
     * @return \Illuminate\Http\Response
     */
    public function get_club_summary(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
//            'club' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $years = Result::query()->where('user_id', $input['user_id'])->select('year')->groupBy('year')->orderBy('year', 'desc')->get();

        $skills = array();
        foreach ($years as $year){
            $cond = 'user_id = '.$input['user_id']." and year = ".$year->year;
            $clubs = Result::query()->whereRaw($cond)->select('club')->groupBy('club')->get();
            foreach ($clubs as $club){
                $rets = array();
                for($i = 1; $i <= 12; $i++ ){
                    $cond = 'user_id = '.$input['user_id']." and club = '".$club->club."' and year = ".$year->year.' and month = '.$i;
                    $results = Result::query()->whereRaw($cond)->select('type', DB::raw('sum(value) as total'))->groupBy('type')->get();
                    $json = array();
                    foreach ($results as $result){
                        $json[$result->type] = $result->total;
                    }
                    $rets[] = $json;
                }
                $cat_name = $year->year.'-'.$club->club;
                $skills[$cat_name] = $rets;
            }
        }

        return response()->json(['status' => true, 'result' => $skills], $this->successStatus);
    }

    /**
     * get_club_year_summary api
     * @return \Illuminate\Http\Response
     */
    public function get_club_year_summary(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
//            'club' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $years = Result::query()->where('user_id', $input['user_id'])->select('year')->groupBy('year')->orderBy('year', 'desc')->get();

        $skills = array();
        foreach ($years as $year){
            $cond = 'user_id = '.$input['user_id'].' and year = '.$year->year;
            $clubs = Result::query()->whereRaw($cond)->select('club')->groupBy('club')->get();
            foreach ($clubs as $club){
                $obj_skill = array();
                $cond_club = 'user_id = '.$input['user_id']." and club = '".$club->club."' and year = ".$year->year;
                $results = Result::query()->whereRaw($cond_club)->select('type', DB::raw('sum(value) as total'))->groupBy('type')->get();
                $json = array();
                foreach ($results as $result){
                    $json[$result->type] = $result->total;
                }
                $cond_year = 'user_id = '.$input['user_id']." and club = '".$club->club."' and year = ".$year->year;
                $months = Result::query()->whereRaw($cond_year)->select('month')->groupBy('month')->get();
                $year_json = array();
                $obj = array();
                foreach ($months as $month){
                    $year_json[] = $month->month;
                }
                $obj[][$year->year] = $year_json;

                $cat_name = $year->year.'-'.$club->club;
                $obj_skill[$cat_name]['data'] = $json;
                $obj_skill[$cat_name]['years'] = $obj;
                $skills[] = $obj_skill;
            }
        }

        return response()->json(['status' => true, 'result' => $skills], $this->successStatus);
    }

    /**
     * get_user_summary api
     * @return \Illuminate\Http\Response
     */
    public function get_user_summary(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
//            'club' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $clubs = Result::query()->where('user_id', $input['user_id'])->select('club')->groupBy('club')->get();

        $skills = array();
        if (isset($clubs)){
            foreach ($clubs as $club){
                $obj_skill = array();
                $cond = 'user_id = '.$input['user_id']." and club = '".$club->club."'";//->orderBy('year')->orderBy('month')
                $results = Result::query()->whereRaw($cond)->select('type', DB::raw('sum(value) as total'))->groupBy('type')->get();
                $json = array();
                foreach ($results as $result){
                    $json[$result->type] = $result->total;
                }
                $years = Result::query()->whereRaw($cond)->select('year')->groupBy('year')->get();
                $obj = array();
                foreach ($years as $year){
                    $cond_year = 'user_id = '.$input['user_id']." and club = '".$club->club."' and year = ".$year->year;
                    $months = Result::query()->whereRaw($cond_year)->select('month')->groupBy('month')->get();
                    $year_json = array();
                    foreach ($months as $month){
                        $year_json[] = $month->month;
                    }
                    $obj[][$year->year] = $year_json;
                }
                $obj_skill[$club->club]['data'] = $json;
                $obj_skill[$club->club]['years'] = $obj;
                $skills[] = $obj_skill;
                //$skills[$club->club] = $json;

            }
        }

        return response()->json(['status' => true, 'result' => $skills], $this->successStatus);
    }
    /**
     * get_sport_summary api
     * @return \Illuminate\Http\Response
     */
    public function get_sport_summary(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'sport_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }
        $cond = 'user_id = '.$input['user_id'].' and sport_id = '.$input['sport_id'];
        $results = Result::query()->whereRaw($cond)->orderBy('year')->orderBy('month')->select('type', DB::raw('sum(value) as total'))->groupBy('type')->get();
        $json = array();
        foreach ($results as $result){
            $json[$result->type] = $result->total;
        }
        $rets = $json;
        return response()->json(['status' => true, 'result' => $rets], $this->successStatus);
    }
    /**
     * get_year_summary api
     * @return \Illuminate\Http\Response
     */
    public function get_year_summary(Request $request){
        $user = Auth::user();
        if (!$user){
            return response()->json(['status'=>false, 'error'=>'Invalid user'], $this-> failedStatus);
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'sport_id' => 'required',
            'year' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => 'Missing parameters'], $this->failedStatus);
        }

        $rets = array();
        for($i = 1; $i <= 12; $i++ ){
            $cond = 'user_id = '.$input['user_id'].' and year = '.$input['year'].' and month = '.$i;//' and sport_id = '.$input['sport_id'].
            $results = Result::query()->whereRaw($cond)->select('type', DB::raw('sum(value) as total'))->groupBy('type')->get();
            $json = array();
            foreach ($results as $result){
                $json[$result->type] = $result->total;
            }
            $rets[] = $json;
        }

        return response()->json(['status' => true, 'result' => $rets], $this->successStatus);
    }
}
