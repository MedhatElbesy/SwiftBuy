<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','stock','price','rating','status','category_id'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            $product->images()->delete();
        });
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
