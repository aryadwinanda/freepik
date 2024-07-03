<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::where('status', 'active')->get();
        return view('home', [
            'categories' => $categories
        ]);
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $images = Image::where('category_id', $category->id)->get();
        return view('category', [
            'category' => $category,
            'images' => $images
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        // filter title or keywords from images
        $images = Image::where('title', 'like', '%' . $keyword . '%')
            ->orWhere('keywords', 'like', '%' . $keyword . '%')
            ->get();

        return view('search', [
            'keyword' => $keyword,
            'images' => $images
        ]);
    }

    public function download(Image $image)
    {
        $imagePath = public_path('storage/uploads/' . $image->file);

        if (file_exists($imagePath)) {
            return response()->download($imagePath, $image->file);
        } else {
            abort(404, 'File not found');
        }
    }
}
