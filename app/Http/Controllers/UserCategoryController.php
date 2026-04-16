<?php

namespace App\Http\Controllers;

use App\Models\UserCategory;
use Illuminate\Http\Request;
use App\Http\Resources\UserCategoryResource;
use App\Http\Requests\StoreUserCategoryRequest;
use App\Http\Requests\UpdateUserCategoryRequest;

class UserCategoryController extends Controller
{
    // GET /api/user-categories
    public function index(Request $request)
    {
        $category = UserCategory::search($request)
            ->sort($request)
            ->filterByDate($request)
            ->paginate($request->integer('per_page', 10));

        return UserCategoryResource::collection($category);
    }

    // POST /api/user-categories
    public function store(StoreUserCategoryRequest $request)
    {
        $category = UserCategory::create($request->validated());

        return new UserCategoryResource($category);
    }

    // GET /api/user-categories/{user_category}
    public function show(UserCategory $user_category)
    {
        return new UserCategoryResource($user_category);
    }

    // PUT/PATCH /api/user-categories/{user_category}
    public function update(UpdateUserCategoryRequest $request, UserCategory $category)
    {
        $category->update($request->validated());

        return new UserCategoryResource($category);
    }

    // DELETE /api/user-categories/{user_category}
    public function destroy(UserCategory $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'UserCategory successfully deleted.',
            'data' => new UserCategoryResource($category),
        ]);
    }
}
