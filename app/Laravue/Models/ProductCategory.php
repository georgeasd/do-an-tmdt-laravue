<?php

namespace App\Laravue\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use Sluggable;

    protected $table = 'product_categories';

    protected $fillable = ['name', 'slug', 'image', 'parent_id', 'status', 'sorts'];


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ]
        ];
    }

    // Relationship
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getImageAttribute($value)
    {
        if (!$value) {
            return '';
        }
        $destinationPath = "uploads/product-category";
//        if (Request::is('api*')) {
//            return CDNHelper::CdnURL($destinationPath, $value);
//        }
        return asset($destinationPath . '/' . $value);
    }
}
