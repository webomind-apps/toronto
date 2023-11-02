<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Province;
use App\Http\Requests\ProvinceRequest;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Province::with("country")->orderBy("name","desc")->get();
        return view('Backend.Admin.Province.list', compact('provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::orderBy("name","asc")->where("status",1)->get();
        return view('Backend.Admin.Province.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProvinceRequest $request)
    {
        $data = $request->validated();
        $data["created_by"] = auth()->user()->id;
        $data["updated_by"] = auth()->user()->id;
        Province::create($data);
        return redirect(route('admin.province.index'))->with('success', 'Province added successfully!');
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
    public function edit(Province $province)
    {
        $countries = Country::orderBy("name","asc")->where("status",1)->get();
        return view('Backend.Admin.Province.edit',compact('province','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProvinceRequest $request,Province $province)
    {
        $data = $request->validated();
        $data["updated_by"] = auth()->user()->id;
        $province->update($data);
        return redirect(route('admin.province.index'))->with('success', 'Province updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function status_change(Request $request)
    {
        Province::where("id",$request->id)->update(["status"=>(($request->status == 1)?0:1)]);
        return redirect(route('admin.province.index'))->with('success', 'Province updated successfully!');
    }

  }
