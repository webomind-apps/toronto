<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Image;
use Str;
use App\Http\Requests\PaymentMethodRequest;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy("name", "desc")->get();
        return view('Backend.Admin.PaymentMethod.list', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.Admin.PaymentMethod.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentMethodRequest $request)
    {
        $data = $request->validated();
        $doc = $request->file("image");
        if (!empty($doc)) {
            if (explode("/", $doc->getClientMimeType())[0] == "image") {
                $data["image"] = $this->imageUpload($doc, 'paymentMethod/');
                $data["created_by"] = auth()->user()->id;
                $data["updated_by"] = auth()->user()->id;
                PaymentMethod::create($data);
            }
        }
        return redirect(route('admin.paymentMethod.index'))->with('success', 'Payment method added successfully!');
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
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('Backend.Admin.PaymentMethod.edit',compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentMethodRequest $request,PaymentMethod $paymentMethod)
    {
        $data = $request->validated();
        $doc = $request->file("image");
        if (!empty($doc)) {
            if (explode("/", $doc->getClientMimeType())[0] == "image") {
                $data["image"] = $this->imageUpload($doc, 'defaultLogo/');
                $data["created_by"] = auth()->user()->id;
                $data["updated_by"] = auth()->user()->id;
                $paymentMethod->update($data);
            }
        }
        return redirect(route('admin.paymentMethod.index'))->with('success', 'Payment method updated successfully!');
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
        PaymentMethod::where("id",$request->id)->update(["status"=>(($request->status == 1)?0:1)]);
        return redirect(route('admin.paymentMethod.index'))->with('success', 'Payment method updated successfully!');
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
