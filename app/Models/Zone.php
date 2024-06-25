<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Zone extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    //--------------- relationship -------------------//
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class,'district_code','code');
    }
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class,'province_code','code');
    }
    //end--------------- relationship -------------------//
}
