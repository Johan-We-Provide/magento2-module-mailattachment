<?php

namespace WeProvide\MailAttachment\ViewModel;

use Magento\Framework\ObjectManagerInterface;
use WeProvide\MailAttachment\Model\ConfigInterface;

class ViewModel implements ViewModelInterface
{
    /**
     * @var ConfigInterface
     */
    protected $config;
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * ViewModel constructor.
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getFileButtonAmount()
    {
        return $this->config->getFileAmount();
    }

    /**
     * @return array
     */
    public function getAllowedExtensions()
    {
        return $this->config->getAllowedExtensions();
    }
}
