<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertisementRequest;
use App\Models\Advertisement;
use App\Models\Business;
use App\Models\Category;
use App\Models\DefaultLogo;
use App\Models\AdvertisementCategory;
use App\Models\AdvertisementCity;
use App\Models\City;
use Illuminate\Http\Request;
use Image;
use Str;
use DB;
use Illuminate\Queue\Worker;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $advertisements = Advertisement::with("business","categories","cities")->orderBy("id", "asc");
        if($request->status == "active"){
            $advertisements->where("status",1);
        }elseif($request->status == "inactive"){
            $advertisements->where("status",0);
        }
        $advertisements = $advertisements->get();

        $default_logo = DefaultLogo::where("status", 1)->latest()->first();
        return view('Backend.Admin.Advertisement.list', compact('advertisements','default_logo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $businesses = Business::orderBy("name", "asc")->where("status", 1)->get();
        $cities = City::orderBy("name", "asc")->where("status", 1)->get();
        $categories = Category::orderBy("name", "asc")->where("status", 1)->get();
        return view('Backend.Admin.Advertisement.create', compact('businesses', 'cities', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisementRequest $request)
    {
        $data = $request->validated();
        $doc = $request->file("image");
        if (!empty($doc)) {
            if (explode("/", $doc->getClientMimeType())[0] == "image") {
                $data["image"] = $this->imageUpload($doc, 'advertisement/');
            }
        }
        $data["created_by"] = auth()->user()->id;
        $data["updated_by"] = auth()->user()->id;
        $data["file_status"] = $request->file_status;
        if(Advertisement::create($data)){

            $advertisement_id = DB::getPdo()->lastInsertId();
            foreach($request->category_ids as $category_id){
                $category                   = new AdvertisementCategory();
                $category->advertisement_id = $advertisement_id;
                $category->category_id      = $category_id;
                $category->save();
            }

            foreach($request->city_ids as $city_id){
                $city                   = new AdvertisementCity();
                $city->advertisement_id = $advertisement_id;
                $city->city_id          = $city_id;
                $city->save();
            }

        }
        return redirect(route('admin.advertisement.index'))->with('success', 'Advertisement added successfully!');
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
    public function edit(Advertisement $advertisement)
    {
        $businesses = Business::orderBy("name", "asc")->where("status", 1)->get();
        $cities = City::orderBy("name", "asc")->where("status", 1)->get();
        $categories = Category::orderBy("name", "asc")->where("status", 1)->get();
        return view('Backend.Admin.Advertisement.edit', compact('businesses','cities','categories','advertisement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdvertisementRequest $request, Advertisement $advertisement)
    {
        $data = $request->validated();
        $doc = $request->file("image");
        if (!empty($doc)) {
            if (explode("/", $doc->getClientMimeType())[0] == "image") {
                $data["image"] = $this->imageUpload($doc, 'advertisement/');
            }
        }
        $data["updated_by"] = auth()->user()->id;
        $data["file_status"] = $request->file_status;
        $advertisement->update($data);

        AdvertisementCategory::where("advertisement_id", $advertisement->id)->delete();
        AdvertisementCity::where("advertisement_id", $advertisement->id)->delete();

        foreach($request->category_ids as $category_id){
            $category = new AdvertisementCategory();
            $category->advertisement_id = $advertisement->id;
            $category->category_id = $category_id;
            $category->save();
        }

        foreach($request->city_ids as $city_id){
            $city                   = new AdvertisementCity();
            $city->advertisement_id = $advertisement->id;
            $city->city_id          = $city_id;
            $city->save();
        }

        return redirect(route('admin.advertisement.index'))->with('success', 'Advertisement updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertisement = Advertisement::find($id);
        $advertisement->delete();

        return redirect(route('admin.advertisement.index'))->with('success', 'Advertisement deleted successfully!');

    }

    public function status_change(Request $request)
    {
        Advertisement::where("id", $request->id)->update(["status" => (($request->status == 1) ? 0 : 1)]);
        return redirect(route('admin.advertisement.index'))->with('success', 'Advertisement updated successfully!');
    }

    //Image Upload
    public function imageUpload($image, $folder)
    {
        $path = [];
        $x = 10;
        if (isset($image) && !empty($image)) {
            $imageName = Str::random(10) . time() . '.' . $image->extension();
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

