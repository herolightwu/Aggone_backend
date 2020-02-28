<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SportController extends Controller
{
    /**
     * SportController constructor.
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
            return Datatables::of(Sport::withTrashed())
                ->editColumn('deleted_at', function ($data) {
                    if ($data->deleted_at) {
                        return '<span class="badge badge-danger">Deleted</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    $editRoute = route('sports.edit', ['sport' => $data->id]);
                    $deleteRoute = route('sports.destroy', ['sport' => $data->id]);
                    $buttons = '<a class="btn btn-outline-secondary btn-sm btn-icon" href="'.$editRoute.'"><i class="fa fa-edit"></i></a>';
                    if ($data->deleted_at) {
                        $updateRoute = route('deleted-sports.update', ['deleted_sport' => $data->id]);
                        $buttons .= '<a class="btn btn-outline-warning btn-sm btn-icon btn-delete" href="javascript:;" data-toggle="modal" data-target="#restoreModal" data-url="'.$updateRoute.'"><i class="fa fa-reply"></i></a>';
                        $deleteRoute = route('deleted-sports.destroy', ['deleted_sport' => $data->id]);
                    }
                    $buttons .= '<a class="btn btn-outline-danger btn-sm btn-icon btn-delete" href="javascript:;" data-toggle="modal" data-target="#deleteModal" data-url="'.$deleteRoute.'"><i class="fa fa-trash"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['action', 'deleted_at'])->make(true);
        }
        return view('admin.sports.index')->with([
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
            'title' => 'required|unique:sports',
            'description' => '',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ]);
        }

        $category = Sport::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
        ]);

        return response()->json([
            'success' => 'Successfully added',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Sport $sport
     * @return void
     */
    public function show(Sport $sport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Sport $sport
     * @return void
     */
    public function edit(Sport $sport)
    {
        return view('admin.sports.edit')->with([
            'sport' => $sport,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Sport $sport
     * @return void
     */
    public function update(Request $request, Sport $sport)
    {
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                Rule::unique('sports')->ignore($sport->id),
            ],
            'description' => '',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ]);
        }

        $sport->title = $request->input('title');
        $sport->image = $request->input('image');
        $sport->description = $request->input('description');
        $sport->save();

        return response()->json([
            'success' => 'Successfully Updated.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Sport $sport
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Sport $sport)
    {
        $sport->delete();
        return response()->json([
            'success' => 'Successfully deleted',
        ]);
    }
}
