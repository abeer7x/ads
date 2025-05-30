<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function all()
    {
        return Category::all();
    }

    public function create(array $data): Category
    {
        return Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
