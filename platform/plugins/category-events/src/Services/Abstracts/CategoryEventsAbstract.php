<?php

namespace Platform\CategoryEvents\Services\Abstracts;

use Platform\PostEvents\Models\PostEvents;
use Platform\CategoryEvents\Repositories\Interfaces\CategoryEventsInterface;
use Illuminate\Http\Request;

abstract class CategoryEventsAbstract
{
    /**
     * @var CategoryEventsInterface
     */
    protected $categoryEventsRepository;

    /**
     * StoreCategoryServiceAbstract constructor.
     * @param CategoryEventsInterface $categoryEventsRepository
     */
    public function __construct(CategoryEventsInterface $categoryEventsRepository)
    {
        $this->categoryEventsRepository = $categoryEventsRepository;
    }

    /**
     * @param Request $request
     * @param PostEvents $postEvents
     * @return mixed
     */
    abstract public function execute(Request $request, PostEvents $postEvents);
}