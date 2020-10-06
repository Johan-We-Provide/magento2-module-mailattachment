<?php


namespace WeProvide\MailAttachment\Model\System\Config\Backend;


use Magento\Cms\Model\Block;
use Magento\Config\Model\Config\Backend\Cache;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Store\Model\Store;

class Links extends Cache implements IdentityInterface
{
    /**
     * Cache tags to clean
     *
     * @var string[]
     */
    protected $_cacheTags = [Store::CACHE_TAG, Block::CACHE_TAG];

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [Store::CACHE_TAG, Block::CACHE_TAG];
    }
}
