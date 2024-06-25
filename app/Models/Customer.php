<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customer extends Model
{
    use HasFactory, SoftDeletes;
    // use HasFactory;
    protected $guarded =[];
    //--------- relationship --------------------//
    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }
    //end --------- relationship --------------------//


}
