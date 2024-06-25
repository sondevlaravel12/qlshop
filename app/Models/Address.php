<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Address extends Model
{
    use HasFactory;
    protected $guarded =['id'];
    //--------- relationship --------------------//
    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class);
    }
    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class,'ward_code','code');
    }
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }
    //end --------- relationship --------------------//


}
