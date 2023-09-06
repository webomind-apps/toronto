<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\FooterContent;
use App\Http\Requests\FooterContentRequest;

class FooterContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $footerContent = FooterContent::latest()->first();
        if($footerContent){
            return view('Backend.Admin.FooterContent.edit', compact('footerContent'));
        }else{
            return view('Backend.Admin.FooterContent.create');
        }

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
        $footerContent = new FooterContent();
        $footerContent->created_by = auth()->user()->id;
        $footerContent->updated_by = auth()->user()->id;
        $footerContent->content = $request->content;
        $footerContent->save();
        return redirect(route('admin.footerContent.index'))->with('success', 'Footer content added successfully!');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FooterContent $footerContent)
    {
        $data = [
            "updated_by" => auth()->user()->id,
            "content"    => $request->content,
        ];
        $footerContent->update($data);
        return redirect(route('admin.footerContent.index'))->with('success', 'Footer content updated successfully!');
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
}
