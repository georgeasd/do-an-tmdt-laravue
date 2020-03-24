<?php

namespace App\Laravue\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class ProductCategory extends BaseModel
{
    use Sluggable;

    protected $table = 'product_categories';
    protected $disk = 'store';

    protected $fillable = ['name', 'slug', 'image', 'parent_id', 'status', 'sorts'];

    /*
    |--------------------------------------------------------------------------
    | Functions
    |--------------------------------------------------------------------------
    */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ]
        ];
    }

    public function isRoot()
    {
        return $this->slug == 'root';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPsS
    |--------------------------------------------------------------------------
    */
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
        return asset($destinationPath . '/' . $value);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = $this->disk;
        $destination_path = 'product-category';
        $this->uploadImage($attribute_name, $disk, $destination_path, $value);
    }
}
