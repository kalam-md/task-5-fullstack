<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Hamcrest\Core\HasToString;
use Symfony\Component\Console\Input\Input;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user', 'category')->get();
        $categories = Category::all()->toArray();
        return response()->json([
            'articles' => $articles,
            'categories' => $categories,
        ], 200);
    }

    public function add(Request $request)
    {
        $article = new Article([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('file')) {
            $imageName = time() . '.' . $request->file('file')->extension();
            $article->image = $imageName;
        }

        $article->save();

        $request->image->move(public_path('images'), $imageName);

        return response()->json('Article successfully added');
    }

    public function edit($id)
    {
        $article = Article::find($id);

        return response()->json($article);
    }

    public function update($id, Request $request)
    {
        $article = Article::find($id);

        if ($request->hasFile('file')) {
            $imageName = time() . '.' . $request->file('file')->extension();

            $currentImage = $article->image;
            $deleteImage = public_path('images') . '/' . $currentImage;

            if (!empty($deleteImage) && file_exists($deleteImage)) {
                @unlink($deleteImage);
            }

            $request->file('file')->move(public_path('images'), $imageName);
            $request->image = $imageName;
        }


        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
        ]);

        return response()->json('Article successfully updated');
    }

    public function delete($id)
    {
        $article = Article::find($id);

        $currentImage = $article->image;
        $deleteImage = public_path('images') . '/' . $currentImage;

        if (!empty($deleteImage) && file_exists($deleteImage)) {
            @unlink($deleteImage);
        }

        $article->delete();

        return response()->json('Article successfully deleted');
    }
}
