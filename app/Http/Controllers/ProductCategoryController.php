<?php

namespace App\Http\Controllers;


use App\Laravue\JsonResponse;
use App\Laravue\Models\ProductCategory;
use App\Services\ProductCategoryService;
use Illuminate\Http\Request;


class ProductCategoryController extends Controller
{
    private $productCategorySerivce;

    public function __construct(ProductCategoryService $productCategorySerivce)
    {
        $this->productCategorySerivce = $productCategorySerivce;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $categories = $this->productCategorySerivce->list($request);
            return $categories;
        } catch (\Exception $e) {
            return response()->json(new JsonResponse([], $e->getMessage()), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            return $this->productCategorySerivce->store($request);
        } catch (\Exception $e) {
            return response()->json(new JsonResponse([], $e->getMessage()), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Laravue\Models\ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        try {
            if ($productCategory->isRoot()) {
                throw new \Exception('Oops! Can not delete root category', 403);
            }
            $productCategory->delete();
            return response()->json(['success' => 'Success'], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
