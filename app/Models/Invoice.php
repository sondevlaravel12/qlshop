<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded =[];
    public function customer(){
        return $this->hasOne(Customer::class,'id','customer_id');
    }
    public function invoiceDetails(){
        return $this->hasMany(InvoiceDetail::class);
    }
     ////  ------------------ Accessor and multator--------------------------------- ////
     protected function subtotal(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => number_format($value, 0, ',', '.'),
             set: fn ($value) => preg_replace('/\./','',$value),
         );
     }
     protected function amountOff(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => number_format($value, 0, ',', '.'),
             set: fn ($value) => preg_replace('/\./','',$value),
         );
     }
     protected function subtotalDiscounted(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => number_format($value, 0, ',', '.'),
             set: fn ($value) => preg_replace('/\./','',$value),
         );
     }
     protected function shipping(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => number_format($value, 0, ',', '.'),
             set: fn ($value) => preg_replace('/\./','',$value),
         );
     }
     protected function total(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => number_format($value, 0, ',', '.'),
             set: fn ($value) => preg_replace('/\./','',$value),
         );
     }
     protected function date(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => date("d/m/Y",strtotime($value)),
             set: fn ($value) => date('Y-m-d',strtotime($value))// make it the same format with created_at, updated_at..
         );
     }


      ////  ------------------ End Accessor and multator--------------------------------- ////
}
