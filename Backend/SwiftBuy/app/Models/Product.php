<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','stock','price','rating','status','image','category_id','promotion','final_price'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($product) {
    //         $product->images()->delete();
    //     });
    // 
    public function carts()
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity');
    }

}
