<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class products extends Model
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name','price','description','stock','weight',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    protected $dates = [
        'deleted_at',
    ];
    public function proddiscount()
    {
        return $this->hasMany('App\discounts','id_product');
    }

    public function prodimage()
    {
        return $this->hasMany('App\product_images','product_id');
    }

    public function detailCategory()
    {
        return $this->hasMany('App\product_category_details','product_id');
    }

    public function cartsp()
    {
        return $this->hasMany('App\carts','product_id');
    }

    public function checkReview()
    {
        return $this->hasMany('App\product_reviews','product_id');
    }

}
