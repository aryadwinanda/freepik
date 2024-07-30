<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $favouriteImages = $user->favouriteImages()->get();

        return view('favourite', [
            'favouriteImages' => $favouriteImages
        ]);
    }
}
