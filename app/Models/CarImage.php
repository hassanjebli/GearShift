<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CarImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['image_path', 'position'];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function getUrl()
    {
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return Storage::url($this->image_path);
    }
}
