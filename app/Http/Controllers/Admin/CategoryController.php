<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store()
    {
        $data = request()->validate([
            'file' => 'required|image',
            'name' => 'required|unique:categories,name',
        ], [
            'file.required' => 'File harus diisi',
            'name.required' => 'Nama kategori harus diisi',
            'name.unique' => 'Nama kategori sudah ada'
        ]);

        $imagePath = Storage::disk('public')->put('uploads/categories', request('file'));
        
        // get file name and extension
        $imageFileName = pathinfo($imagePath, PATHINFO_FILENAME) . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);

        $save = Category::create([
            'cover' => $imageFileName,
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'status' => 'active',
        ]);

        if ($save) {
            flash('Berhasil menambahkan kategori', 'success');
            return redirect()->route('admin.category.index');
        }

        flash('Gagal menambahkan kategori', 'error');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', [
            'category' => $category
        ]);
    }

    public function update($id)
    {
        $data = request()->validate([
            'file' => 'image',
            'name' => 'required|unique:categories,name,' . $id
        ], [
            'file.image' => 'File harus berupa gambar',
            'name.required' => 'Nama kategori harus diisi',
            'name.unique' => 'Nama kategori sudah ada'
        ]);

        $category = Category::findOrFail($id);
        $categoryCover = $category->cover;
        $categoryCoverPath = "uploads/categories/".$categoryCover;

        if (request()->hasFile('file')) {
            if ($category->cover != null) {
                Storage::disk('public')->delete($categoryCoverPath);
            }
            
            $imagePath = Storage::disk('public')->put('uploads/categories', request('file'));
            
            // get file name and extension
            $categoryCover = pathinfo($imagePath, PATHINFO_FILENAME) . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);
        }

        $category = Category::findOrFail($id);
        $category->cover = $categoryCover;
        $category->name = $data['name'];
        $category->slug = Str::slug($data['name']);
        $category->status = 'active';
        $save = $category->save();

        if ($save) {
            flash('Berhasil mengubah kategori', 'success');
            return redirect()->route('admin.category.index');
        }

        flash('Gagal mengubah kategori', 'error');
    }
}
