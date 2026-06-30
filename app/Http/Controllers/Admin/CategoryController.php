<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')
            ->orderBy('name_en')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        // Only top-level categories can be parents
        $parents = Category::whereNull('parent_id')
            ->orderBy('name_en')
            ->get();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_fa' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? false;

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        // Only top-level categories can be parents
        $parents = Category::whereNull('parent_id')
            ->orderBy('name_en')
            ->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name_fa' => 'required|string|max:255',
            'name_en' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id),
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                Rule::notExists(function ($query) use ($category) {
                    $query->where('id', $category->id);
                }),
            ],
            'icon' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? false;

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Check if category has children
        if ($category->children()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cannot delete category with child categories. Delete or move child categories first.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
