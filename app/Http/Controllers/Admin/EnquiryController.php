<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;

class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = Enquiry::orderBy("id","asc")->get();
        return view('Backend.Admin.Enquiry.list', compact('enquiries'));
    }
}
