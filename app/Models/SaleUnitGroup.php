<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleUnitGroup extends Model
{
    use HasFactory;
    protected $guared =[];
    public function saleUnits(){
        return $this->hasMany(SaleUnit::class);
    }
}
