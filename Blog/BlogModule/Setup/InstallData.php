<?php

namespace Blog\BlogModule\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $date;
 
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        $this->date = $date;
    }
    
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $dataBlogRows = [
            [
                'title' => 'Blog Title 1',
                'description' => 'Here is write blog description 1',
                'status' => 1,
                'updated_at' => $this->date->date(),
                'created_at' => $this->date->date()
            ],
            [
                'title' => 'Blog Title 2',
                'description' => 'Here is write blog description 2',
                'status' => 1,
                'updated_at' => $this->date->date(),
                'created_at' => $this->date->date()
            ]
        ];
        
        foreach($dataBlogRows as $data) {
            $setup->getConnection()->insert($setup->getTable('blog_blogmodule'), $data);
        }
    }
}

