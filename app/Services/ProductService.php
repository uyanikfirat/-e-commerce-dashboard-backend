<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Repositories\ProductRepository;

class ProductService extends BaseService
{
    protected $productrepository;

    public function __construct(ProductRepository $productrepository)
    {
        $this->productrepository = $productrepository;
    }

    public function getAll()
    {
        return $this->productrepository->all();
    }

    public function find(int $id)
    {
        return $this->productrepository->find($id);
    }

    public function create(Request $request)
    {

        $product = $this->productrepository->create($request->except('images', 'size', 'shipping_id', 'product_variants'));

        if ($request->has('images') && is_array($request->images) && count($request->images)) {
            $images = $request->images;

            foreach ($images as $image) {
                $imageData = uploadImage($image, 'product');
                $imageData['product_id'] = $product->id;
                $product->images()->create($imageData);
            }
        }

        $product->product_sizes()->create($request->size);

        $product->ProductShipping()->create(['shipping_id' => $request->shipping_id]);
        $this->createVariants($request->product_variants, $product);
    }

    protected function createVariants(string $product_variants, Product $product)
    {


        $productvariants = json_decode($product_variants, true);
      
        foreach ($productvariants as $variant) {

            if (is_array($variant) && isset($variant['id'])) {
                $productvariantoption = $product->product_variant_options()->create([
                    'product_variant_id' => $variant['id'],
                    'value' => $variant['value']
                ]);

                $product->product_variant_option_inventories()->create([
                    'product_variant_option_id' => $productvariantoption->id,
                    'stock' => $variant['stock']
                ]);

                $product->product_variant_option_prices()->create([
                    'product_variant_option_id' => $productvariantoption->id,
                    'price' => $variant['price']
                ]);
            }
        }
    }

    public function update(int $id, Request $request)
    {
        return $this->productrepository->update($id, $request->all());
    }

    public function delete(int $id)
    {
        return $this->productrepository->delete($id);
    }
}
