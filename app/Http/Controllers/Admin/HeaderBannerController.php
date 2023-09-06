<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeaderBannerRequest;
use App\Models\HeaderBanner;
use App\Models\DefaultLogo;
use Illuminate\Http\Request;
use Image;
use Str;

class HeaderBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headerBanners = HeaderBanner::orderBy("id", "asc")->get();
        $default_logo = DefaultLogo::where("status", 1)->latest()->first();
        return view('Backend.Admin.HeaderBanner.list', compact('headerBanners','default_logo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.Admin.HeaderBanner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HeaderBannerRequest $request)
    {
        $data = [];
        $doc = $request->file("image");
        if (!empty($doc)) {
            if (explode("/", $doc->getClientMimeType())[0] == "image") {
                $data["image"] = $this->imageUpload($doc, 'headerBanner/');
                $data["created_by"] = auth()->user()->id;
                $data["updated_by"] = auth()->user()->id;
                HeaderBanner::create($data);
            }
        }
        return redirect(route('admin.headerBanner.index'))->with('success', 'Header Banner added successfully!');
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
    public function edit(HeaderBanner $headerBanner)
    {
        return view('Backend.Admin.HeaderBanner.edit', compact('headerBanner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HeaderBannerRequest $request, HeaderBanner $headerBanner)
    {
        $data = [];
        $doc = $request->file("image");
        if (!empty($doc)) {
            if (explode("/", $doc->getClientMimeType())[0] == "image") {
                $data["image"] = $this->imageUpload($doc, 'headerBanner/');
            } else {
                $data["image"] = $this->documentUpload($doc, 'headerBanner/');
            }
            $data["updated_by"] = auth()->user()->id;
            $headerBanner->update($data);
        }
        return redirect(route('admin.headerBanner.index'))->with('success', 'Header Banner updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HeaderBanner $headerBanner)
    {
        $headerBanner->delete();
        return redirect(route('admin.headerBanner.index'))->with('success', 'Header Banner deleted successfully!');
    }

    public function status_change(Request $request)
    {
        HeaderBanner::where("id", $request->id)->update(["status" => (($request->status == 1) ? 0 : 1)]);
        return redirect(route('admin.headerBanner.index'))->with('success', 'Header Banner updated successfully!');
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

    // document upload
    public function documentUpload($document, $folder)
    {
        $path = [];
        if (isset($document)) {
            $documentName = Str::random($length = 10) . time() . '.' . $document->extension();
            $path = $folder . $documentName;
            if (!is_dir(storage_path('app/public/' . $folder))) {
                mkdir(storage_path('app/public/' . $folder), 0777, true);
            }

            $document->move(storage_path('app/public/' . $folder), $documentName);
        }
        return $path;
    }
}
