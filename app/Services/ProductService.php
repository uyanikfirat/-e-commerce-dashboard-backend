<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Repositories\ProductRepository;
use App\Repositories\ProductVariantRepository;

class ProductService extends BaseService
{
    protected $productrepository;
    protected $productVariantRepository;

    public function __construct(ProductRepository $productrepository, ProductVariantRepository $productVariantRepository)
    {
        $this->productrepository = $productrepository;
        $this->productVariantRepository = $productVariantRepository;

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

        $product->size()->create($request->size);
        $product->ProductShipping()->create(['shipping_id' => $request->shipping_id]);
        $this->createVariants($request->product_variants, $product);
    }

    protected function createVariants(array $productVariants, Product $product)
    {
       foreach ($productVariants as $variant) {
          if (is_array($variant) && isset($variant['id'])) {
             $productVariant = $this->productVariantRepository->find($variant['id']);
             if ($productVariant) {

                $productVariantOption = $product->productVariantOptions()->create([
                   'product_variant_id' => $productVariant->id,
                   'value' => $variant['value']
                ]);

                $product->productVariantOptionInventories()->create([
                   'product_variant_option_id' => $productVariantOption->id,
                   'stock' => $variant['stock']
                ]);
                $product->productVariantOptionPrices()->create([
                   'product_variant_option_id' => $productVariantOption->id,
                   'price' => $variant['price']
                ]);
             }
          }
       }
    }

//request duzenlenicek fazla datalar gelmeyecek.
    public function update(int $id, Request $request)
    {
       $product = $this->productrepository->find($id);
       $product->fill($request->except(['size', 'images', 'shipping_id', 'product_variants', 'deleted_images', 'deleted_variants']));
       $product->save();
       $this->updateProductAssociations($product, $request);
    }

    protected function updateProductAssociations(Product $product, Request $request)
    {
        $this->manageProductImages($product, $request);
        $product->size()->updateOrCreate([], $request->size);
        $product->productShipping()->updateOrCreate([], ['shipping_id' => $request->shipping_id]);

     //   if ($request->has('deleted_variants') && is_array($request->deleted_variants) && count($request->deleted_variants)) {
     //      $this->deleteVariants($request->deleted_variants, $product);
     //   }

       if ($request->has('product_variants') && is_array($request->product_variants) && count($request->product_variants)) {
          $this->createVariants($request->product_variants, $product);
       }
    }

    protected function manageProductImages(Product $product, Request $request)
    {
       if ($request->has('deleted_images') && is_array($request->deleted_images) && count($request->deleted_images)) {
          foreach ($request->deleted_images as $image) {
             $product->images()->findOrFail($image['id'])->delete();
          }
       }

       if ($request->has('images') && is_array($request->images) && count($request->images)) {
          $images = $request->images;
          foreach ($images as $image) {
             if($image->isValid()){
                 $imageData = uploadImage($image, 'product');
                 $imageData['product_id'] = $product->id;
                 //relation ile kaydedebilirsiniz ama product modelde images diye relation olmasi lazim
                 $product->images()->create($imageData);
             }

          }
       }
    }


    protected function deleteProductAssociations(Product $product)
    {
        $product->images()->delete();
      $product->productShipping()->delete();
      $product->size()->delete();
      //$this->deleteVariants($product);
    }
    protected function deleteVariants(array $deleteVariants, Product $product)
    {
        if (is_array($deleteVariants) && count($deleteVariants)) {
            foreach ($deleteVariants as $variant) {
               if (isset($variant['id'])) {
                  // Find and delete the related product_variant_options_inventories
                  $product->productVariantOptionInventories()->where('stock', $variant['stock'])->delete();

                  // Find and delete the related product_variant_options_prices
                  $product->productVariantOptionPrices()->where('price', $variant['price'])->delete();

                  // Find and delete the related product_variant_options
                  $product->productVariantOptions()->where('id', $variant['id'])->delete();
              }
            }
         }

    }


    public function delete(int $id)
   {
      $product = $this->productrepository->find($id);
      $this->deleteProductAssociations($product);
      $product->delete();
   }



}
