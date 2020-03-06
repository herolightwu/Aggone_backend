<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use App\Traits\CaptureIpTrait;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use jeremykenedy\LaravelRoles\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class CoachController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(User::query()->where('group_id', '=',2))
                ->addColumn('avatar', function ($user) {
                    if ($user->photo_url) {
                        return '<img class="img-thumbnail" src="'.$user->photo_url.'" />';
                    } else {
                        return '<img class="img-thumbnail" src="'.Gravatar::get($user->email).'" />';
                    }
                })
                ->editColumn('email', function ($user) {
                    return '<a href="mailto:'.$user->email.'">'.$user->email.'</a>';
                })
                ->editColumn('sport', function ($user) {
                    $sport = $user->sport;
                    return $sport->name;
                })
                ->editColumn('birthday', function ($user) {
                    if ($user->day == 0)
                        return "";
                    else
                        return $user->day."-".$user->month."-".$user->year;
                })
                ->addColumn('action', function ($user) {
//                    $editRoute = route('users.edit', ['user' => $data->id]);
                    $showRoute = route('coaches.show', $user->id);
                    $deleteRoute = route('coaches.destroy', $user->id);
                    $buttons = '<a class="btn btn-outline-success btn-sm btn-icon" href="'.$showRoute.'"><i class="fa fa-eye"></i></a>';
//                    $buttons .= '<a class="btn btn-outline-primary btn-sm btn-icon" href="'.$editRoute.'"><i class="fa fa-edit"></i></a>';
                    $buttons .= '<a class="btn btn-outline-danger btn-sm btn-icon btn-delete" href="javascript:;" data-toggle="modal" data-target="#deleteModal" data-url="'.$deleteRoute.'"><i class="fa fa-trash"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['action', 'avatar', 'email', 'group_id', 'birthday'])->make(true);
        }
        return view('admin.coaches.index')->with([
            'user' => Auth::user(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::query()->findOrFail($id);
        return view('admin.coaches.show')->with([
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::query()->findOrFail($id);
        $roles = Role::all();
        $cities = City::all();

        $currentRole = null;
        $currentCity = null;

        foreach ($user->cities as $user_city) {
            $currentCity = $user_city;
        }

        $data = [
            'user'        => $user,
            'roles'       => $roles,
            'cities' => $cities,
            'currentCity' => $currentCity,
        ];

        return view('admin.coaches.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::query()->findOrFail($id);
        $emailCheck = ($request->input('email') != '') && ($request->input('email') != $user->email);
        $ipAddress = new CaptureIpTrait();

        if ($emailCheck) {
            $validator = Validator::make($request->all(), [
                'name'     => [
                    'required',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ],
                'email'     => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ],
                'phone_number' => [
                    'required',
                    'min:7',
                    'max:14',
//                    Rule::unique('users')->ignore($user->id),
                ],
                'driver_license' => ''
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name'     => 'required|max:255|unique:users,name,'.$id,
                'phone_number' => [
                    'required',
                    'min:7',
                    'max:14',
//                    Rule::unique('users')->ignore($user->id),
                ],
                'driver_license' => ''
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ]);
        }

        $user->name = $request->input('username');
//        $user->first_name = $request->input('first_name');
//        $user->last_name = $request->input('last_name');
//        $user->phone_number = $request->input('phone_number');
//        $user->driver_license = $request->input('driver_license');

//        if ($emailCheck) {
        $user->email = $request->input('email');
//        }

//        $userRole = $request->input('role');
//        if ($userRole != null) {
//            $user->roles()->sync($userRole);
//        }

        $userCity = $request->input('city');
        if ($userCity != null) {
            $user->cities()->detach();
            $user->cities()->attach($userCity);
        }

        $user->updated_ip_address = $ipAddress->getClientIp();

        $user->save();

        return response()->json([
            'success' => 'Successfully updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentUser = Auth::user();
        $user = User::findOrFail($id);
        $ipAddress = new CaptureIpTrait();

        if ($user->id != $currentUser->id) {
            $user->deleted_ip_address = $ipAddress->getClientIp();
            $user->save();
            $user->delete();

            return response()->json([
                'success' => "Successfully Deleted",
            ]);
        }

        return response()->json([
            'error' => [
                'error1' => [
                    'Can\'t delete yourself.',
                ]
            ],
        ]);
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::query()->findOrFail($id);
        $ipAddress = new CaptureIpTrait();

        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ]);
        }

        $user->password = bcrypt($request->input('password'));
        $user->updated_ip_address = $ipAddress->getClientIp();
        $user->save();
        return response()->json(['success'=>'Password updated']);
    }

    public function licenseImage($id, $filename)
    {
        return Image::make(storage_path().'/images/'.$id.'/license/'.$filename)->response();
    }
}
