<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model implements HasMedia
{
    use HasFactory;
    protected $guarded =['id'];
    use InteractsWithMedia;
    use HasSlug;

    // ------------------- Spatie Slug ---------------------------//
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    // ------------------- End Spatie Slug ---------------------------//

    // ------------------- Spatie Media ---------------------------//
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('inventory_product')
            ->acceptsMimeTypes(['image/jpeg','image/png','image/svg'])
            //->withResponsiveImages()
            ->onlyKeepLatest(1)
            ;

    }
    public function registerMediaConversions(Media $media = null): void
    {

        $this
            ->addMediaConversion('thumb')
            ->width(200)
            ->height(200);
    }
    // -------------------End Spatie Media ---------------------------//
    ////  ------------------ Accessor--------------------------------- ////
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0, ',', '.'),
        );
    }
    protected function originalPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 0, ',', '.'),
        );
    }
    ////  ------------------End Accessor--------------------------------- ////
    ////  ------------------ Relationship--------------------------------- ////
    public function children(){
        return $this->hasMany(Product::class,'parent_id','id');
    }
    public function parent(){
        return $this->belongsTo(Product::class,'parent_id','id');
    }
    ////  ------------------ End Relationship--------------------------------- ////

    public function getImage(){
        return $this->getFirstMediaUrl('products','medium')? $this->getFirstMediaUrl('products','medium'):'noimage.png';
    }
    public static function getMainProducts(){
        return Product::where('parent_id',null)->latest()->get();
    }
    public static function generateSKU(string $lastSKU){
        $stringCharacters = "SP";
        $numberLength = 6;
        $number = substr($lastSKU,2);
        $newnumber = ((int)$number) +1;
        $currentNumberLen = strlen($newnumber);
        $numberOfZeroAppend = $numberLength - $currentNumberLen;
        $sku =  $stringCharacters . str_repeat("0",$numberOfZeroAppend) . $newnumber;
        return $sku;

    }
    public static function generateMultipleSKUs(string $lastSKU, int $numberOfSku){
        $stringCharacters = "SP";
        $numberLength = 6;
        $number = substr($lastSKU,2);
        $skuList = [];
        for ($i = 0; $i < $numberOfSku; $i++) {
            $newnumber = ((int)$number) +$i +1;
            $currentNumberLen = strlen($newnumber);
            $numberOfZeroAppend = $numberLength - $currentNumberLen;
            $sku =  $stringCharacters . str_repeat("0",$numberOfZeroAppend) . $newnumber;
            $skuList[$i] = $sku;
        }

        return $skuList;

    }
    public function getFirstImage($size='thumb'){
        if($this->getFirstMedia('products')){
            return $this->getFirstMedia('products')->getUrl($size);
        }else{
            return global_asset('asset/noimage.jpeg');
        }
    }
}
