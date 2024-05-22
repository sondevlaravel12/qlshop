<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleUnit extends Model
{
    protected $guared =[];
    public function saleUnitGroup(){
        return $this->belongsTo(SaleUnitGroup::class);
    }
    // public function variants(){
    //     return $this->hasMany(Variant::class);
    // }
}
