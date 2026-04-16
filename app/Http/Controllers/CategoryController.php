<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    // GET /api/category
    public function index(Request $request)
    {
        $category = Category::search($request)
            ->sort($request)
            ->filterByDate($request)
            ->paginate($request->integer('per_page', 10));

        return CategoryResource::collection($category);
    }

    // POST /api/category
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    // GET /api/category/{category}
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    // PUT/PATCH /api/category/{category}
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    // DELETE /api/category/{category}
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category successfully deleted.',
            'data' => new CategoryResource($category),
        ]);
    }
}
