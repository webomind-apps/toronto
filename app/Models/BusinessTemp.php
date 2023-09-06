<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessTemp extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'user_temp_id',
        'transaction_id',
        'country_id',
        'province_id',
        'city_id',
        'description',
        'postcode',
        'address',
        'lat',
        'lng',
        'website',
        'image',
        'video',
        'is_feature',
        'area_of_practice',
        'product_and_service',
        'specialization',
        'priority',
        'online_order',
        'online_order_link',
        'status',
        'created_by',
        'updated_by',
    ];

    public function business_category_temps()
    {
        return $this->hasOne(BusinessCategoryTemp::class,'business_temp_id','id');
    }

    public function business_day_timing_temps()
    {
        return $this->hasMany(BusinessDayTimingTemp::class,'business_temp_id','id');
    }

    public function business_feature_temps()
    {
        return $this->hasMany(BusinessFeatureTemp::class,'business_temp_id','id');
    }

    public function business_gallery_temps()
    {
        return $this->hasMany(BusinessGalleryTemp::class,'business_temp_id','id');
    }

    public function business_language_temps()
    {
        return $this->hasMany(BusinessLanguageTemp::class,'business_temp_id','id');
    }

    public function business_payment_method_temps()
    {
        return $this->hasMany(BusinessPaymentMethodTemp::class,'business_temp_id','id');
    }

    public function business_social_media_temps()
    {
        return $this->hasMany(BusinessSocialMediaTemp::class,'business_temp_id','id');
    }

    public function business_sub_category_temps()
    {
        return $this->hasMany(BusinessSubCategoryTemp::class,'business_temp_id','id');
    }

    public function business_upgrade_temps()
    {
        return $this->hasOne(BusinessUpgradeTemp::class,'business_temp_id','id');
    }

    public function user_temps()
    {
        return $this->hasOne(UserTemp::class,"id","user_temp_id");
    }

}
