<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Tables\Categories;
use ProtoneMedia\Splade\Facades\Toast;

class CategoryController extends Controller
{
    public function index(){
        // $categories = Category::all();
        return view('categories.index', [
            // 'categories' => SpladeTable::for(Category::class)
            // ->column('name', sortable: true, searchable: true)
            // ->withGlobalSearch(columns: ['name', 'slug'])
            // ->column('slug', sortable: true)
            // ->column('action')
            // ->export()
            // ->paginate(5),
            'categories' => Categories::class
        ]);
    }
    public function create(){
        $message = 'Create new category';
        return view('categories.create', compact('message'));
    }
    public function store(CategoryStoreRequest $request){
        Category::create($request->validated());
        Toast::title('Category was added successfully!');
        return redirect()->route('categories.index');
    }
    public function edit(Category $category){
        return view('categories.edit', compact('category'));
    }
    public function update(CategoryStoreRequest $request, Category $category){
        $category->update($request->validated());
        Toast::title('Category was updated successfully!');
        return redirect()->route('categories.index');
    }
    public function destroy(Category $category){
        $category->delete();
        Toast::title('Category was deleted successfully!');
        return redirect()->back();
    }
}
