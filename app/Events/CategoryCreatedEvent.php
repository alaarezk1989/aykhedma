<?php

namespace App\Events;


use App\Models\Category;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CategoryCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $category;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * CategoryCreatedEvent constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->message = 'created';
        $this->objectType = get_class($category);
        $this->objectId = $category->id;
    }
}
