<?php

namespace Blog\BlogModule\Model\Allblog\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $allBlog;

    public function __construct(\Blog\BlogModule\Model\Allblog $allBlog)
    {
        $this->allBlog = $allBlog;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->allBlog->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
