<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;
    protected $guarded =[];
    // one district (quan or huyen) has many wards (phuong, xa,thi tran )
    public function wards(): HasMany
    {
        return $this->hasMany(Ward::class,'district_code','code');
    }
    //inverse with father
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class,'province_code','code');
    }

    //end--------- relationship --------------------//
}
