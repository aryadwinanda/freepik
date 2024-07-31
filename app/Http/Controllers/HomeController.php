<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FavouriteImage;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Process;

class HomeController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::where('status', 'active')->get();
        return view('home', [
            'categories' => $categories
        ]);
    }

    public function category(Request $request, $slug)
    {
        $color = $request->color;
        $img_search = $request->img_search;
        $sort = $request->sort ?? 'new';

        if ($img_search) {
            $img_search = asset('storage/uploads/temp/' . $img_search);
        } else {
            $img_search = "#";
        }

        $category = Category::where('slug', $slug)->first();

        $images = Image::where('category_id', $category->id)
            ->when($color, function ($query) use ($color) {
                return $query->where('color', $color);
            })
            ->when($sort == 'new', function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->when($sort == 'old', function ($query) {
                return $query->orderBy('created_at', 'asc');
            })
            ->when($sort == 'popular', function ($query) {
                return $query->withCount('favouriteImages')->orderBy('favourite_images_count', 'desc');
            })->get();

        return view('category', [
            'category' => $category,
            'images' => $images,
            'color' => $color,
            'img_search' => $img_search,
            'sort' => $sort
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $color = $request->color;
        $img_search = $request->img_search;
        $sort = $request->sort ?? 'new';

        if ($img_search) {
            $img_search = asset('storage/uploads/temp/' . $img_search);
        } else {
            $img_search = "#";
        }

        // filter title or keywords from images
        $images = Image::where('title', 'like', '%' . $keyword . '%')
            ->orWhere('keywords', 'like', '%' . $keyword . '%')
            ->when($color, function ($query) use ($color) {
                return $query->where('color', $color);
            })
            ->when($sort == 'new', function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->when($sort == 'old', function ($query) {
                return $query->orderBy('created_at', 'asc');
            })
            ->when($sort == 'popular', function ($query) {
                return $query->withCount('favouriteImages')->orderBy('favourite_images_count', 'desc');
            })
            ->get();

        return view('search', [
            'keyword' => $keyword,
            'images' => $images,
            'color' => $color,
            'img_search' => $img_search,
            'sort' => $sort
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

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = Storage::disk('public')->put('uploads/temp', request('file'));
        $imageFileName = pathinfo($imagePath, PATHINFO_FILENAME) . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);

        $scriptPath = public_path('scripts/color_detect.py');
        $imagePath = public_path('storage/uploads/temp/' . $imageFileName);

        $pythonPath = env('PYTHON_PATH');
        $command = [$pythonPath, $scriptPath, "-i", $imagePath];
        $process = new Process($command);
        $process->run();
        $output = $process->getOutput();

        $arrOutput = explode('//', $output);

        return response()->json([
            'img_search' => $imageFileName,
            'color' => $arrOutput[0],
        ]);
    }
}
