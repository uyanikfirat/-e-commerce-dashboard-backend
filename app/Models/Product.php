<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['product_category', 'discount', 'images' ];

    protected $appends = ['product_variants', 'shipping_id'];


    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function product_variant_options()
    {
        return $this->hasMany(ProductVariantOption::class, 'product_id', 'id');
    }

    public function product_variant_option_inventories()
    {
        return $this->hasMany(ProductVariantOptionInventory::class, 'product_id', 'id');
    }

    public function ProductShipping()
    {
        return $this->hasOne(ProductShipping::class);
    }

    public function product_shippings()
    {
        return $this->hasMany(Shipping::class, 'product_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id','id');
    }

    public function product_sizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id','id');
    }

    public function product_variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id','id');
    }

    public function product_variant_option_prices()
    {
        return $this->hasMany(ProductVariantOptionPrice::class, 'product_id', 'id');
    }

    public function getShippingIdAttribute()
    {
        return optional($this->productShipping)->shipping_id;
    }


    public function getProductvariantsAttribute()
    {
        $productvariants = [];

        foreach($this->product_variant_option_inventories as $index => $pvoi){
        $productvariants[$index]['id'] = $pvoi->id;
        $productvariants[$index]['stock'] = $pvoi->stock;
    }
        foreach($this->product_variant_option_prices as $index => $pvop){
            $productvariants[$index]['id'] = $pvop->id;
            $productvariants[$index]['price'] = $pvop->price;
        }
        foreach($this->product_variant_options as $index => $pvo){
            $productvariants[$index]['value'] = $pvo->value;
        } return $productvariants;

    }

    public function getImageUrlAttribute()
{
    $image = $this->images()->orderBy('id', 'asc')->first();

    if ($image) {
        return $image->image_url;
    } else {
        return '/default-image.jpg'; // Varsayılan resim yolunu belirleyebilirsiniz
    }
}






}
