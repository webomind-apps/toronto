<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DefaultLogoRequest;
use App\Models\DefaultLogo;
use Illuminate\Http\Request;
use Image;
use Str;

class DefaultLogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $defaultLogoes = DefaultLogo::orderBy("id","asc")->get();
        return view('Backend.Admin.DefaultLogo.list', compact('defaultLogoes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.Admin.DefaultLogo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DefaultLogoRequest $request)
    {
        $data=[];
        $doc=$request->file("image");
        if (!empty($doc)) {
            if(explode("/",$doc->getClientMimeType())[0] == "image"){
                $data["image"]=$this->imageUpload($doc,'defaultLogo/');
                $data["created_by"] = auth()->user()->id;
                $data["updated_by"] = auth()->user()->id;
                DefaultLogo::create($data);
            }
        }
        return redirect(route('admin.defaultLogo.index'))->with('success', 'Default added successfully!');
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
    public function edit(DefaultLogo $defaultLogo)
    {
        return view('Backend.Admin.DefaultLogo.edit', compact('defaultLogo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DefaultLogoRequest $request, DefaultLogo $defaultLogo)
    {
        $data=[];
        $doc=$request->file("image");
        if (!empty($doc)) {
            if(explode("/",$doc->getClientMimeType())[0] == "image"){
                $data["image"]=$this->imageUpload($doc,'defaultLogo/');
                $data["updated_by"] = auth()->user()->id;
                $defaultLogo->update($data);
            }
        }
        return redirect(route('admin.defaultLogo.index'))->with('success', 'Default updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DefaultLogo $defaultLogo)
    {
        $defaultLogo->delete();
        return redirect(route('admin.defaultLogo.index'))->with('success', 'Default logo deleted successfully!');
    }

    public function status_change(Request $request)
    {
        DefaultLogo::where("id", $request->id)->update(["status" => (($request->status == 1) ? 0 : 1)]);
        return redirect(route('admin.defaultLogo.index'))->with('success', 'Default logo updated successfully!');
    }

    //Image Upload
    public function imageUpload($image, $folder)
    {
        $path = [];
        $x = 10;
        if (isset($image) && !empty($image)) {
            $imageName = Str::random($length = 10) . time() . '.' . $image->extension();
            $path = $folder . $imageName;
            if (!is_dir(storage_path('app/public/' . $folder))) {
                mkdir(storage_path('app/public/' . $folder), 0777, true);
            }
            $img = Image::make($image->getRealPath());
            $img->save(storage_path('app/public/' . $path), $x);
        }

        return $path;
    }
}
