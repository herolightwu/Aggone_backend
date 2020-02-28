<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DeletedUserController extends Controller
{
    /**
     * DeletedUserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(User::onlyTrashed())
                ->editColumn('email', function ($user) {
                    return '<a href="mailto:'.$user->email.'">'.$user->email.'</a>';
                })
                ->editColumn('phone_number', function ($user) {
                    return '<a href="tel:'.$user->phone_number.'">'.$user->phone_number.'</a>';
                })
                ->addColumn('email_status', function ($user) {
                    if ($user->hasVerifiedEmail()) {
                        return '<span class="badge badge-success">Verified</span>';
                    } else {
                        return '<span class="badge badge-danger">New</span>';
                    }
                })
                ->addColumn('phone_status', function ($user) {
                    if ($user->hasVerifiedPhone()) {
                        return '<span class="badge badge-success">Verified</span>';
                    } else {
                        return '<span class="badge badge-danger">New</span>';
                    }
                })
                ->addColumn('roles', function ($user) {
                    $roles = '';
                    foreach ($user->roles as $user_role) {
                        $role_name = $user_role->name;
                        $badgeClassname = '';
                        if ($role_name == 'Admin') {
                            $badgeClassname = 'badge-warning';
                        } elseif ($role_name == 'Customer') {
                            $badgeClassname = 'badge-primary';
                        } elseif ($role_name == 'Cooker') {
                            $badgeClassname = 'badge-secondary';
                        } elseif ($role_name == 'Rider') {
                            $badgeClassname = 'badge-info';
                        } else {
                            $badgeClassname = 'badge-danger';
                        }
                        $roles = $roles.'<span class="badge '.$badgeClassname.'">'.ucfirst($role_name).'</span>';
                    }
                    return $roles;
                })
                ->addColumn('action', function ($data) {
                    $showRoute = route('deleted-users.show', ['deleted_user' => $data->id]);
                    $restoreRoute = route('deleted-users.update', ['deleted_user' => $data->id]);
                    $deleteRoute = route('deleted-users.destroy', ['deleted_user' => $data->id]);
                    $buttons = '<a class="btn btn-outline-success btn-sm btn-icon" href="'.$showRoute.'"><i class="fa fa-eye"></i></a>';
                    $buttons .= '<a class="btn btn-outline-warning btn-sm btn-icon" href="javascript:;" data-toggle="modal" data-target="#restoreModal" data-url="'.$restoreRoute.'"><i class="fa fa-reply"></i></a>';
                    $buttons .= '<a class="btn btn-outline-danger btn-sm btn-icon btn-delete" href="javascript:;" data-toggle="modal" data-target="#deleteModal" data-url="'.$deleteRoute.'"><i class="fa fa-trash"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['action', 'roles', 'email_status', 'email', 'phone_number', 'phone_status'])->make(true);
        }
        return view('admin.deleted-users.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return response()->json([
            'success' => 'Successfully restored.'
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
        $user = User::onlyTrashed()->findOrFail($id);
        $user->social()->delete();
        $user->forceDelete();

        return response()->json([
            'success' => 'Successfully deleted.'
        ]);
    }
}
