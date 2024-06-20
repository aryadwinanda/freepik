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
}
