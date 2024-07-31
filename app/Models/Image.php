<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'color',
        'description',
        'keywords',
        'file',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function favouriteImages(): HasMany
    {
        return $this->hasMany(FavouriteImage::class, 'image_id', 'id');
    }

    public function getCountFavouritesAttribute()
    {
        return $this->favouriteImages()->count();
    }
}
