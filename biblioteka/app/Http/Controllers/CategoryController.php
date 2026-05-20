<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('books')->orderBy('name')->paginate(15);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]);

        Category::create($request->only('name'));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategorija je uspješno kreirana.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
        ]);

        $category->update($request->only('name'));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategorija je uspješno ažurirana.');
    }

    public function destroy(Category $category)
    {
        if ($category->books()->exists()) {
            return back()->with('error', 'Nije moguće obrisati kategoriju koja ima knjige.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategorija je obrisana.');
    }
}
