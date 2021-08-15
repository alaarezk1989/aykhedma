<?php

namespace App\Events;


use App\Models\Category;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CategoryDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $category;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * CategoryDeletedEvent constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->message = 'deleted';
        $this->objectType = get_class($category);
        $this->objectId = $category->id;
    }
}
