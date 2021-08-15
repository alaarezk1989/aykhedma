<?php

namespace App\Events;


use App\Models\Category;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CategoryEditedEvent
{
    use Dispatchable , SerializesModels;
    public $category;
    public $message;
    public $objectType;
    public $objectId;

    /**
     * CategoryEditedEvent constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->message = 'updated';
        if ($category->wasChanged('active')) {
            $status = $category->active ? 'active' : 'disabled';
            $this->message = 'changed_status_to_' . $status;
        }

        $this->objectType = get_class($category);
        $this->objectId = $category->id;
    }
}
