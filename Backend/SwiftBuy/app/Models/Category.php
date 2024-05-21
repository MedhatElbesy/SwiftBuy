<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'description','status','cover_image'];

    public function products(){
        return $this->hasMany(Product::class);
    }
}