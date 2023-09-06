<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Http\Requests\PackageRequest;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::orderBy("id","asc")->get();
        return view('Backend.Admin.Package.list', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.Admin.Package.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
    {
        $data = $request->validated();
        $data["created_by"] = auth()->user()->id;
        $data["updated_by"] = auth()->user()->id;
        Package::create($data);
        return redirect(route('admin.package.index'))->with('success', 'Package added successfully!');
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
    public function edit(Package $package)
    {
        return view('Backend.Admin.Package.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PackageRequest $request,Package $package)
    {
        $data = $request->validated();
        $data["updated_by"] = auth()->user()->id;
        $package->update($data);
        return redirect(route('admin.package.index'))->with('success', 'Package updated successfully!');
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
        Package::where("id", $request->id)->update(["status" => (($request->status == 1) ? 0 : 1)]);
        return redirect(route('admin.package.index'))->with('success', 'Package updated successfully!');
    }

    public function price_change(Request $request)
    {
        Package::where("id",$request->id)->update(["price"=>$request->price]);
        return redirect(route('admin.package.index'))->with('success', 'Package updated successfully!');
    }
}
