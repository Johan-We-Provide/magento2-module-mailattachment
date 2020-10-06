<?php

namespace WeProvide\MailAttachment\ViewModel;
use Magento\Framework\View\Element\Block\ArgumentInterface;

interface ViewModelInterface extends ArgumentInterface
{
    /**
     * @return string
     */
    public function getFileButtonAmount();

    /**
     * @return array
     */
    public function getAllowedExtensions();
}
