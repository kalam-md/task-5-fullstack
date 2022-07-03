<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all()->toArray();
        return array_reverse($categories);
    }

    public function add(Request $request)
    {
        $category = new Category([
            'name' => $request->name,
        ]);

        $category->save();

        return response()->json('Category successfully added');
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return response()->json($category);
    }

    public function update($id, Request $request)
    {
        $category = Category::find($id);
        $category->update($request->all());
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();

        return response()->json('Category successfully deleted');
    }
}
