<?php
namespace Blog\BlogModule\Block\Adminhtml;

class Allblog extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_allblog';
        $this->_blockGroup = 'Blog_BlogModule';
        $this->_headerText = __('Manage Blog');

        parent::_construct();

        if ($this->_isAllowedAction('Blog_BlogModule::save')) {
            $this->buttonList->update('add', 'label', __('Add Blog'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
