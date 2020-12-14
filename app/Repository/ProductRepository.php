<?php


namespace App\Repository;

use App\Entities\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository extends BaseRepositories
{
    /**
     * @return Product
     */
    public function getModel(): Product
    {
        return new Product();
    }

    /**
     * @param $request
     * @return LengthAwarePaginator
     */
    public function getProductIndex($request): LengthAwarePaginator
    {
        return $this->getModel()::with('category')
            ->productInfo($request->input('search'))
            ->paginate();
    }

    /**
     * @param $data
     * @return void
     */
    public function create($data): void
    {
        $product = parent::create($data);

       if ($data['tags']) {
           $product->tags()->sync($data['tags']);
        }

        if (key_exists('file', $data)) {
            $file = $data['file']->store('images');
            $product->file = Storage::url($file);
            $product->update();
        }
    }

    /**
     * @param $object
     * @param $data
     * @return void
     */
    public function update($object, $data): void
    {
        parent::update($object, $data);

        if (key_exists('tags', $data)){
            $object->tags()->sync($data['tags']);
        }

        if (key_exists('file', $data)) {
            if ($object->file) {
                Storage::delete($object->file);
            }

            $file = $data['file']->store('images');
            $object->file = Storage::url($file);
            $object->save();
        }
    }

    public function delete($object)
    {
        if ($object->file){

            Storage::delete(@unlink(storage_path(asset($object->file))));
        }
        parent::delete($object);
    }
}
