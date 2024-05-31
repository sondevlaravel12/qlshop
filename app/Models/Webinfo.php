<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Manipulations;

class Webinfo extends Model implements HasMedia
{
    use HasFactory;
    protected $guarded = [];

    use InteractsWithMedia;


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('logo')
            ->acceptsMimeTypes(['image/jpeg','image/png','image/svg'])
            ->onlyKeepLatest(3)
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('medium')
                    ->width(400)
                    ->height(150);
                $this
                    ->addMediaConversion('small')
                    ->width(200)
                    ->height(75);
            })
            ;
    }

    ////  ------------------ Accessor--------------------------------- ////

    // protected function address(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value){
    //             if( !empty($value) && strpos($value,':') !== FALSE ){
    //                 $get_option = explode(':',$value);

    //                 //Build html
    //                 $result = "<div> <b>{$get_option[0]}</b>: {$get_option[1]} </div>";

    //                 return $result;

    //             }
    //             return FALSE;
    //         },
    //     );
    // }
    // protected function address2(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value){
    //             if( !empty($value) && strpos($value,':') !== FALSE ){
    //                 $get_option = explode(':',$value);

    //                 //Build html
    //                 $result = "<div> <b>{$get_option[0]}</b>: {$get_option[1]} </div>";

    //                 return $result;

    //             }
    //             return FALSE;
    //         },
    //     );
    // }

    protected function phone(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                if( !empty($value) && strpos($value,':') !== FALSE ){
                    $get_option = explode(':',$value);

                    //Build html
                    $result = "<div> <b>{$get_option[0]}</b>: <a href='tel:{$get_option[1]}' style='color:red'> {$get_option[1]} </a> </div>";

                    return $result;

                }
                return FALSE;
            },
        );
    }
    // relation ship
    // public function metatag()
    // {
    //     return $this->morphOne(MetaTag::class, 'model');
    // }
    // --------------------- other functions -----------------------------//
    public function beautify_address($address_number=1):string{
        if($address_number==1){
            $address = $this->address;
        }else{
            $address = $this->address_2;
        }
        if( !empty($address) && strpos($address,':') !== FALSE ){
            $get_option = explode(':',$address);
            //Build html
            $result = "<div> <b>{$get_option[0]}</b>: > {$get_option[1]} </a> </div>";

            return $result;
        }
            return FALSE;
    }
    //end --------------------- other functions -----------------------------//
}
