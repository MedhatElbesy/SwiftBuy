<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','stock','price','rating','status','image','category_id','promotion','final_price'];


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

<<<<<<< HEAD
    // public function images()
    // {
    //     return $this->hasMany(ProductImage::class);
    // }

    public function carts()
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity');
    }


=======
>>>>>>> 0aa6fa64030bacc9c2d56f1e7492819d0105f730
}
