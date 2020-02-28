<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    /**
     * CityController constructor.
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
            return Datatables::of(City::withTrashed())
//                ->addColumn('restaurants', function ($data) {
//                    $restaurants = '';
//                    foreach ($data->restaurants as $restaurant) {
//                        $restaurants .= '<span class="badge badge-primary">'.$restaurant->restaurant_name.'</span>';
//                    }
//                    return $restaurants;
//                })
                ->addColumn('country_name', function ($data) {
                    return $data->country->country_name;
                })
                ->editColumn('deleted_at', function ($data) {
                    if ($data->deleted_at) {
                        return '<span class="badge badge-danger">Deleted</span>';
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    $editRoute = route('cities.edit', ['city' => $data->id]);
                    $deleteRoute = route('cities.destroy', ['city' => $data->id]);
                    $buttons = '<a class="btn btn-outline-secondary btn-sm btn-icon" href="'.$editRoute.'"><i class="fa fa-edit"></i></a>';
                    if ($data->deleted_at) {
                        $updateRoute = route('deleted-cities.update', ['deleted_city' => $data->id]);
                        $buttons .= '<a class="btn btn-outline-warning btn-sm btn-icon btn-delete" href="javascript:;" data-toggle="modal" data-target="#restoreModal" data-url="'.$updateRoute.'"><i class="fa fa-reply"></i></a>';
                        $deleteRoute = route('deleted-cities.destroy', ['deleted_city' => $data->id]);
                    }
                    $buttons .= '<a class="btn btn-outline-danger btn-sm btn-icon btn-delete" href="javascript:;" data-toggle="modal" data-target="#deleteModal" data-url="'.$deleteRoute.'"><i class="fa fa-trash"></i></a>';
                    return $buttons;
                })
                ->rawColumns(['action', 'deleted_at'])->make(true);
//                ->rawColumns(['action', 'restaurants', 'deleted_at'])->make(true);
        }
        $countries = Country::all();
        return view('admin.cities.index')->with([
            'countries' => $countries,
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
                'city_name' => 'required',
//                'zip_code' => '',
                'country' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ]);
        }
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $country = Country::query()->where('country_code', '=', $request->input('country'))->first();
        $city = new City([
            'city_name' => $request->input('city_name'),
        ]);
        $city->location = new Point($latitude, $longitude);
        //        $city->zip_code = $request->input('zip_code');

        $country->cities()->save($city);

        return response()->json([
            'success' => 'New City successful added',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $countries = Country::all();
        $currentCountry = $city->country;
        return view('admin.cities.edit')->with([
            'city' => $city,
            'countries' => $countries,
            'currentCountry' => $currentCountry,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $validator = Validator::make($request->all(),
            [
                'city_name' => [
                    'required',
                ],
//                'zip_code' => '',
                'country' => 'required'
            ]
        );
        if ($validator->fails()) {
            if($request->ajax()) {
                return response()->json([
                    'error' => $validator->errors(),
                ]);
            }
            return back()->withErrors($validator)->withInput();
        }
        $city->city_name = $request->input('city_name');
//        $city->zip_code = $request->input('zip_code');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $country = Country::where('country_code', '=', $request->input('country'))->get()->first();
        $city->location = new Point($latitude, $longitude);
        $city->country()->associate($country);
        $city->save();

        if($request->ajax()) {
            return response()->json([
                'success' => 'Current City successfully updated',
            ]);
        }

        return back()->with('success', 'Current City successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\City $city
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(City $city)
    {
        $city->delete();
        return response()->json([
            'success' => 'Successfully deleted',
        ]);
    }
}
