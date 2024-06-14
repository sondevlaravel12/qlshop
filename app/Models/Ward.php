<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ward extends Model
{
    use HasFactory;
    protected $guarded =[];

    // one district (quan or huyen) has many wards (phuong, xa,thi tran )
    //inverse with father
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class,'district_code','code');
    }

    //end--------- relationship --------------------//
}
