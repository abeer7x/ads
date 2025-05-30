<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\category\StoreCategoryRequest;
use App\Http\Requests\category\UpdateCategoryRequest;
use App\Models\Category;

use App\Services\CategoryService as ServicesCategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    use AuthorizesRequests;

    protected $categoryService;

    public function __construct(ServicesCategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
         $this->authorize('create', Category::class);

        $category = $this->categoryService->create($request->validated());

        return $this->success($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->success($category);
    }

    /**
     * Update the specified resource in storage.
     */
 
     public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $category = $this->categoryService->update($category, $request->validated());

        return $this->success($category);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    
    {
        $this->authorize('delete', $category);

        $this->categoryService->delete($category);

        return $this->success(['message' => 'Category deleted']);
    }
}
