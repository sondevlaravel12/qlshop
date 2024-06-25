<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Stancl\Tenancy\Database\Concerns\CentralConnection;

class Province extends Model
{
    use HasFactory;
    protected $guarded =[];
    // protected $connection = 'central';
    //--------- relationship --------------------//
    // one province(should be named Zone can be city or province) has many districts (quan or huyen)
    public function districts(): HasMany
    {
        return $this->hasMany(District::class,'province_code','code');
    }

    //end--------- relationship --------------------//
}
