<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserGroupController extends Controller
{
    /**
     * UserGroupController constructor.
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
            return Datatables::of(UserGroup::withTrashed())
                ->addColumn('users', function ($data) {
                    return $data->users->count();
                })
                /*->editColumn('deleted_at', function ($data) {
                    if ($data->deleted_at) {
                        return '<span class="badge badge-danger">Deleted</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    $editRoute = route('groups.edit', ['group' => $data->id]);
                    $deleteRoute = route('groups.destroy', ['group' => $data->id]);
                    $buttons = '<a class="btn btn-outline-secondary btn-sm btn-icon" href="'.$editRoute.'"><i class="fa fa-edit"></i></a>';
                    if ($data->deleted_at) {
                        $updateRoute = route('deleted-groups.update', ['deleted_group' => $data->id]);
                        $buttons .= '<a class="btn btn-outline-warning btn-sm btn-icon btn-delete" href="javascript:;" data-toggle="modal" data-target="#restoreModal" data-url="'.$updateRoute.'"><i class="fa fa-reply"></i></a>';
                        $deleteRoute = route('deleted-groups.destroy', ['deleted_group' => $data->id]);
                    }
                    $buttons .= '<a class="btn btn-outline-danger btn-sm btn-icon btn-delete" href="javascript:;" data-toggle="modal" data-target="#deleteModal" data-url="'.$deleteRoute.'"><i class="fa fa-trash"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['action', 'deleted_at'])*/->make(true);
        }
        return view('admin.groups.index')->with([
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:user_groups',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ]);
        }

        $category = UserGroup::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'success' => 'Successfully added',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function show(UserGroup $userGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userGroup = UserGroup::query()->findOrFail($id);
        return view('admin.groups.edit')->with([
            'group' => $userGroup, 'user' => Auth::user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserGroup $userGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\UserGroup $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $userGroup = UserGroup::query()->findOrFail($id);
        $userGroup->delete();
        return response()->json([
            'success' => 'Successfully deleted',
        ]);
    }
}
