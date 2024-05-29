<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $guarded =[];

    ////  ------------------ Accessor and multator--------------------------------- ////
    protected function amountOff(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0, ',', '.'),
            set: fn ($value) => preg_replace('/\./','',$value),
        );
    }
    protected function sellingPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0, ',', '.'),
            set: fn ($value) => preg_replace('/\./','',$value),
        );
    }
    protected function lineTotal(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0, ',', '.'),
            set: fn ($value) => preg_replace('/\./','',$value),
        );
    }


     ////  ------------------ End Accessor and multator--------------------------------- ////
    //  ----------------------relationship -----------------------------------------------//
    // public function product(): HasOne
    // {
    //     return $this->hasOne(Product::class);
    // }
    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
    //  ----------------------end relationship -----------------------------------------------//
}
