<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20-Mar-20
 * Time: 3:44 PM
 */

namespace App\Services;

use App\Laravue\Models\ProductCategory;
use App\Repositories\ProductCategoryRepository;
use Illuminate\Support\Arr;
use App\Http\Resources\ProductCategoryResource;

class ProductCategoryService
{
    const ITEM_PER_PAGE = 15;
    private $model;

    public function __construct()
    {
        $this->model = ProductCategory::class;
    }

    public function list($request)
    {
        $searchParams = $request->all();
        $productCategories = $this->model::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');
        $sortBy = Arr::get($searchParams, 'sort', '');
        $orderBy = Arr::get($searchParams, 'orderBy', '');
        if (!empty($keyword)) {
            $productCategories->where('name', 'LIKE', '%' . $keyword . '%');
        }

        if ($sortBy && $orderBy) {
            $productCategories->orderBy($sortBy, $orderBy);
        }

        return ProductCategoryResource::collection($productCategories->paginate($limit));
    }

    public function store($request)
    {
        return $this->model::create($request->all());
    }
}
