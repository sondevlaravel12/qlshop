<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guared =['id'];

    ////  ------------------ Accessor--------------------------------- ////
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0, ',', '.'),
        );
    }
    protected function originalPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0, ',', '.'),
        );
    }
    ////  ------------------End Accessor--------------------------------- ////
    public static function getMainProducts(){
        return Product::where('parent_id',null)->latest()->get();
    }
}
