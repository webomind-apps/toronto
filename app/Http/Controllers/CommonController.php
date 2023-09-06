<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\FooterContent;
use App\Models\City;
use App\Models\Province;
use App\Models\Category;
use App\Models\SubCategory;

class CommonController extends Controller
{
    public function email_unique(Request $request)
    {
        $count = DB::table($request->dbTable)->where($request->dbField,$request->value)->count();
        return response()->json($count);
    }

    public function footer_content(Request $request)
    {
        $footer = FooterContent::latest()->first();
        $content = '';
        if(!empty($footer)){
                if(!empty($footer->content)){
                    $content .= '
                    <div class="col-lg-12 col-md-12 m-b-30 popularFooter">
                        '.$footer->content.'
                    </div>';
            }
        }
        return response()->json($content);
    }

    public function subCategory_collection(Request $request)
    {
        $subCategories = SubCategory::where("category_id",$request->category_id)->orderBy("name","asc")->get();
        return response()->json($subCategories);
    }

    public function city_collection(Request $request)
    {
        $cities = City::where("province_id",$request->province_id)->orderBy("name","asc")->get();
        return response()->json($cities);
    }

    public function province_collection(Request $request)
    {
        $provinces = Province::where("country_id",$request->country_id)->orderBy("name","asc")->get();
        return response()->json($provinces);
    }

    public function search_category_collection(Request $request) //search_category_collection
    {
        $search = $request->search;
        $result = [];

        if(!empty($search)):
            $categories = Category::select('name')->where('name', 'LIKE',$search.'%')->orderBy('name','asc')->distinct('name')->get();
            $sub_categories = SubCategory :: select('name')->where('name', 'LIKE',$search.'%')->orderBy('name','asc')->distinct('name')->get();

            $result=[];
            foreach($categories as $c):
                array_push($result,$c->name);
            endforeach;

            foreach($sub_categories as $c):
                if(!in_array($c->name, $result)):
                    array_push($result,$c->name);
                endif;
            endforeach;
        endif;

        natcasesort($result);
        $content='';
        foreach($result as $res):
            $content .= "<li>".$res."</li>";
        endforeach;

        echo $content;
        exit;
        // return response()->json($content);

    }

    public function search_city_collection(Request $request)
    {
        $search = $request->search;
        if(!empty($search)):
            $cities = City::select('name')->where('name', 'LIKE', $search.'%')->distinct("name")->get();
        endif;

        $content='';
        foreach($cities as $res):
            $content .= "<li>".$res->name."</li>";
        endforeach;
        echo $content;
        exit;
        // return response()->json($result);
    }

}
