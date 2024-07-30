<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FavouriteImage extends Model
{
    use HasFactory;

    protected $table = 'favourite_images';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'image_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }
}
