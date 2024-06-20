<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
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
            'name' => 'required|unique:categories,name'
        ], [
            'name.required' => 'Nama kategori harus diisi',
            'name.unique' => 'Nama kategori sudah ada'
        ]);

        $save = Category::create([
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
            'name' => 'required|unique:categories,name,' . $id
        ], [
            'name.required' => 'Nama kategori harus diisi',
            'name.unique' => 'Nama kategori sudah ada'
        ]);

        $category = Category::findOrFail($id);
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
