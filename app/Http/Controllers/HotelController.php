<?php

namespace App\Http\Controllers;

use App\Models\hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //
        $this->middleware('permission:hotels-list|hotels-create|hotels-edit|hotels_delete',['only'=>['index','show']]);
        $this->middleware('permission:hotels-create',['only'=>['create','store']]);
        $this->middleware('permission:hotels-edit',['only'=>['edit','update']]);
        $this->middleware('permission:hotels-delte',['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $hotels = hotel::latest()->paginate(5);
        return view('hotels.index',compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('hotels.create');
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
        request()->validate([
            'name' =>'required',
            'detail'=>'required',
        ]);
        hotel::create($request->all());

        return redirect()->route('hotels.index')
                        ->with('success','Hotel created sucessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(hotel $hotel)
    {
        //
        return view('hotels.show',compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(hotel $hotel)
    {
        //
        return view('hotels.edit',compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, hotel $hotel)
    {
        //
        request()->validate([
            'name'=>'required',
            'detail'=>'required',
        ]);

        $hotel->update($request->all());

        return redirect()->route('hotels.index')
                        ->with('success','Hotel updated sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(hotel $hotel)
    {
        //
        $hotel->delete();

        return redirect()->route('hotels.index')
                                ->with('success','Hotel deleted sucessfully');
    }
}
