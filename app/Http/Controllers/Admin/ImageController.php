<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::with('category')->get();
        $categories = Category::all();

        return view('admin.image.index', [
            'images' => $images,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.image.create',[
            'categories' => $categories
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'title.required' => 'Judul harus diisi',
            'category_id.required' => 'Kategori harus diisi',
            'description.required' => 'Deskripsi harus diisi',
            'keywords.required' => 'Keywords harus diisi',
            'file.required' => 'File harus diisi',
            'file.image' => 'File harus berupa gambar',
        ]);

        $imagePath = Storage::disk('public')->put('uploads', request('file'));
        
        // get file name and extension
        $imageFileName = pathinfo($imagePath, PATHINFO_FILENAME) . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);

        $save = Image::create([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'color' => null,
            'description' => $data['description'] ?? null,
            'keywords' => $data['keywords'] ?? null,
            'file' => $imageFileName
        ]);

        if ($save) {
            $scriptPath = public_path('scripts/color_detect.py');
            $imagePath = public_path('storage/uploads/' . $imageFileName);

            $pythonPath = env('PYTHON_PATH');
            $command = [$pythonPath, $scriptPath, "-i", $imagePath];
            $process = new Process($command);
            $process->run();
            $output = $process->getOutput();

            $output = str_replace(array("\r\n", "\r", "\n"), '', $output);
            $arrOutput = explode('//', $output);

            $image = Image::find($save->id);
            $image->color = $arrOutput[0];
            $image->color_rgb = $arrOutput[1];
            $image->save();

            flash('Berhasil menambahkan gambar', 'success');
            return redirect()->route('admin.image.index');
        }

        flash('Gagal menambahkan gambar', 'error');
    }

    public function edit($id)
    {
        $image = Image::findOrFail($id);
        $categories = Category::all();
        return view('admin.image.edit', [
            'image' => $image,
            'categories' => $categories
        ]);
    }

    public function update($id)
    {
        $data = request()->validate([
            'title' => 'required',
            'category_id' => 'required',
            'color' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'title.required' => 'Judul harus diisi',
            'category_id.required' => 'Kategori harus diisi',
            'color.required' => 'Warna harus diisi',
            'description.required' => 'Deskripsi harus diisi',
            'keywords.required' => 'Keywords harus diisi',
            'file.image' => 'File harus berupa gambar',
        ]);

        $image = Image::findOrFail($id);
        $imageFileName = $image->file;
        $imagePath = "uploads/".$imageFileName;

        if (request()->hasFile('file')) {
            Storage::disk('public')->delete($imagePath);
            $imagePath = Storage::disk('public')->put('uploads', request('file'));
            
            // get file name and extension
            $imageFileName = pathinfo($imagePath, PATHINFO_FILENAME) . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);
        }

        $update = $image->update([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'color' => $data['color'] ?? null,
            'description' => $data['description'] ?? null,
            'keywords' => $data['keywords'] ?? null,
            'file' => $imageFileName
        ]);

        if ($update) {
            flash('Berhasil mengubah gambar', 'success');
            return redirect()->route('admin.image.index');
        }

        flash('Gagal mengubah gambar', 'error');
    }
}
