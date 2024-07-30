<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FavouriteImage;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function like(Request $request)
    {
        if(!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda harus login terlebih dahulu',
            ], 400);
        }

        if (Auth::user()->role == 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Admin tidak bisa menambahkan gambar ke daftar favorit',
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'image_id' => 'required|exists:images,id'
        ], [
            'image_id.required' => 'ID gambar harus diisi',
            'image_id.exists' => 'ID gambar tidak valid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        if (FavouriteImage::where('user_id', Auth::user()->id)->where('image_id', $request->image_id)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gambar sudah ditambahkan ke daftar favorit',
            ], 400);
        }

        $save = FavouriteImage::create([
            'user_id' => Auth::user()->id,
            'image_id' => $request->image_id
        ]);

        if (!$save) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan gambar ke daftar favorit',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Gambar ditambahkan ke daftar favorit',
        ]);
    }
}
