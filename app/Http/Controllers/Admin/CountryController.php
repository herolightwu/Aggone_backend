<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    /**
     * CountryController constructor.
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
            return Datatables::of(Country::withTrashed())
                ->addColumn('cities', function ($data) {
                    $cities = '';
                    foreach ($data->cities as $city) {
                        $cities .= '<span class="badge badge-primary">'.$city->city_name.'</span>';
                    }
                    return $cities;
                })
                ->editColumn('deleted_at', function ($data) {
                    if ($data->deleted_at) {
                        return '<span class="badge badge-danger">Deleted</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    $editRoute = route('countries.edit', ['country' => $data->id]);
                    $deleteRoute = route('countries.destroy', ['country' => $data->id]);
                    $buttons = '<a class="btn btn-outline-secondary btn-sm btn-icon" href="'.$editRoute.'"><i class="fa fa-edit"></i></a>';
                    if ($data->deleted_at) {
                        $updateRoute = route('deleted-countries.update', ['deleted_country' => $data->id]);
                        $buttons .= '<a class="btn btn-outline-warning btn-sm btn-icon btn-delete" href="javascript:;" data-toggle="modal" data-target="#restoreModal" data-url="'.$updateRoute.'"><i class="fa fa-reply"></i></a>';
                    }
                    $buttons .= '<a class="btn btn-outline-danger btn-sm btn-icon btn-delete" href="javascript:;" data-toggle="modal" data-target="#deleteModal" data-url="'.$deleteRoute.'"><i class="fa fa-trash"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['action', 'cities', 'deleted_at'])->make(true);
        }
        return view('admin.countries.index')->with([
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
        $validator = Validator::make($request->all(),
            [
                'country_name' => 'required|max:20|unique:countries',
                'country_code' => 'required|max:5|unique:countries',
                'iso_code' => 'required|max:5',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ]);
        }

        Country::create([
            'country_name' => $request->input('country_name'),
            'country_code' => $request->input('country_code'),
            'iso_code' => $request->input('iso_code'),
        ]);

        return response()->json([
            'success' => 'Successfully created',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('admin.countries.edit')->with([
            'country' => $country,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        if ($country->trashed()) {
            return response()->json([
                'success' => 'OK'
            ]);
        }
        $validator = Validator::make($request->all(),
            [
//                'country_name' => 'required|max:20|unique:countries',
                'country_name' => [
                    'required',
                    Rule::unique('countries')->ignore($country->id),
                    'max:20'
                ],
                'country_code' => [
                    'required',
                    'max:5',
                    Rule::unique('countries')->ignore($country->id)
                ],
                'iso_code' => 'required|max:5',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $country->country_name = $request->input('country_name');
        $country->country_code = $request->input('country_code');
        $country->iso_code = $request->input('iso_code');
        $country->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return response()->json([
            'success' => 'Successfully deleted',
        ]);
    }
}
