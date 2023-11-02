<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Http\Requests\SubCategoryRequest;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sub_categories=SubCategory::orderBy('name','asc');
        if($request->search!=''){
            $sub_categories->whereHas('category', function ($q) use($request) {
                $q->where("name",'like','%'.$request->search.'%');
            })->orWhere("name",'like','%'.$request->search.'%');
        }
        $sub_categories = $sub_categories->with("category")->paginate(10);
        return view('Backend.Admin.SubCategory.list', compact('sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy("name","asc")->where("status",1)->get();
        return view('Backend.Admin.SubCategory.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->validated();
        // $data["created_by"] = auth()->user()->id;
        // $data["updated_by"] = auth()->user()->id;

        foreach($request->name as $name){
            $data = [
                'name' => $name,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'category_id' => $request->category_id
            ];
            SubCategory::create($data);
        }
        // dd($request->validated());
        // SubCategory::create($data);
        return redirect(route('admin.subCategory.index'))->with('success', 'Sub Category added successfully!');
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
    public function edit(SubCategory $subCategory)
    {
        $categories = Category::orderBy("name","asc")->where("status",1)->get();
        return view('Backend.Admin.SubCategory.edit',compact('subCategory','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryRequest $request,SubCategory $subCategory)
    {
        $data = $request->validated();
        $data["updated_by"] = auth()->user()->id;
        $subCategory->update($data);
        return redirect(route('admin.subCategory.index'))->with('success', 'Sub Category updated successfully!');
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
        SubCategory::where("id",$request->id)->update(["status"=>(($request->status == 1)?0:1)]);
        return redirect(route('admin.subCategory.index'))->with('success', 'Sub Category updated successfully!');
    }

}
