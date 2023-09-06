<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'user_id',
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

    public function category()
    {
        return $this->hasOne(BusinessCategory::class,'business_id','id');
    }

    public function subCategories()
    {
        return $this->hasMany(BusinessSubCategory::class,'business_id','id');
    }

    public function country()
    {
        return $this->hasOne(Country::class,'id','country_id');
    }

    public function province()
    {
        return $this->hasOne(Province::class,'id','province_id');
    }

    public function city()
    {
        return $this->hasOne(City::class,'id','city_id');
    }

    public function business_upgrade_latest()
    {
        return $this->hasOne(BusinessUpgrade::class,'business_id','id')->latest();
    }

    public function business_upgrade()
    {
        return $this->hasMany(BusinessUpgrade::class,'business_id','id');
    }

    public function languages()
    {
        return $this->hasMany(BusinessLanguage::class,'business_id','id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'business_id', 'id')->where("status",1);
    }

    public function avgReview()
    {
        return $this->reviews()
            ->selectRaw('avg(score) as aggregate, business_id')
            ->groupBy('business_id');
    }

    public function getAvgReviewAttribute()
    {
        if (!array_key_exists('avgReview', $this->relations)) {
            $this->load('avgReview');
        }
        $relation = $this->getRelation('avgReview')->first();
        return ($relation) ? $relation->aggregate : null;
    }

    public function wishLists()
    {
        return $this->hasMany(Wishlist::class, 'business_id', 'id')->where("status",1);
    }

    public function socialMedias()
    {
        return $this->hasMany(BusinessSocialMedia::class,'business_id','id');
    }

    public function business_day_timings()
    {
        return $this->hasMany(BusinessDayTiming::class,'business_id','id');
    }

    public function business_day_timing_today()
    {
        return $this->hasOne(BusinessDayTiming::class,'business_id','id')->where('day',date('l'));
    }

    public function payment_methods()
    {
        return $this->hasMany(BusinessPaymentMethod::class,'business_id','id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function galleries()
    {
        return $this->hasMany(BusinessGallery::class,'business_id','id');
    }
}
