<?php

namespace App\Exports;

use App\Models\Business;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class businessExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $business;
    protected $parmas;
    public function __construct($parmas)
    {
        $this->parmas = $parmas;
    }
    public function collection()
    {
        $businesses = Business::orderBy("name","desc")->with("business_upgrade_latest");
        if($this->parmas->status!=''){
            $businesses->where("status",$this->parmas->status);
        }
        if($this->parmas->province_id!=''){
            $businesses->where("province_id",$this->parmas->province_id);
        }
        if($this->parmas->package_id!=''){
            $package_id=$this->parmas->package_id;
            $businesses->whereHas('business_upgrade_latest', function ($query) use ($package_id) {
                $query->where('package_id', $package_id);
            });
        }
        if($this->parmas->category_id!=''){
            $category_id=$this->parmas->category_id;
            $businesses->whereHas('category', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        }
        return $this->business = $businesses->get();
    }
    public function map($business): array
    {
        return [
            $business->country->name,
            $business->city->name,
            $business->province->name,
            $business->category->category->name,
            $business->name,
            $business->phone,
            $business->email,
        ];
    }
    public function headings(): array
    {
        return [
            'Country',
            'City',
            'Province',
            'Category',
            'Name',
            'Phone',
            'email',
        ];
    }
}
