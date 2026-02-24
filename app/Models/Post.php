<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'thumbnail', 'content', 'category', 'is_published'];

    public function getImageUrlAttribute()
    {
        if (!$this->thumbnail) {
            return asset('images/default-blog.jpg');
        }
        return str_starts_with($this->thumbnail, 'http') 
            ? $this->thumbnail 
            : asset('storage/' . $this->thumbnail);
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('thumbnail') && $model->thumbnail && !str_starts_with($model->thumbnail, 'http')) {
                self::optimizeImage($model->thumbnail);
            }
        });
    }

    protected static function optimizeImage($path)
    {
        try {
            $fullPath = storage_path('app/public/' . $path);
            if (file_exists($fullPath)) {
                $image = \Intervention\Image\Laravel\Facades\Image::read($fullPath);
                if ($image->width() > 1200) {
                    $image->scale(width: 1200);
                }
                $image->save($fullPath, 80);
            }
        } catch (\Exception $e) {
            \Log::error('Image optimization failed: ' . $e->getMessage());
        }
    }
}
