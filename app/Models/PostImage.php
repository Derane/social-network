<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PostImage extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function getUrlAttribute()
    {
        return url('storage/' . $this->path);
    }

    public static function clearStorage()
    {
        $images = PostImage::where('user_id', auth()->id())
            ->where('post_id', null)->get();
        $images->each(function ($image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        });
    }
}
