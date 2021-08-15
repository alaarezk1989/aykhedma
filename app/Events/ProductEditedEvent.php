<?php


namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Product;

class ProductEditedEvent
{
    use Dispatchable, SerializesModels;

    public $product;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * ProductEvent constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->message = 'updated';
        if ($product->wasChanged('active')) {
            $status = $product->active ? 'active' : 'disabled';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($product);
        $this->objectId = $product->id;
    }


}
