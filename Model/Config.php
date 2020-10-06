<?php


namespace WeProvide\MailAttachment\Model;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @inheritDoc
     */
    public function getFileAmount()
    {
        return $this->scopeConfig->getValue(
            ConfigInterface::XML_PATH_FILE_AMOUNT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @inheritDoc
     */
    public function getAllowedExtensions($asArray = false)
    {
        $value = $this->scopeConfig->getValue(
            ConfigInterface::XML_PATH_ALLOWED_EXTENSIONS,
            ScopeInterface::SCOPE_STORE
        );

        if ($asArray) {
            $value = array_map(function ($item) {
                return trim(preg_replace("/[^A-Za-z0-9 ]/", '', $item));
            }, explode(',', $value));

            $value = $this->checkJpeg($value);
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function isAllowedFileRenaming()
    {
        return $this->scopeConfig->getValue(
            ConfigInterface::XML_PATH_ALLOW_FILE_RENAME,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @inheritDoc
     */
    public function isAllowedFileDispersion()
    {
        return $this->scopeConfig->getValue(
            ConfigInterface::XML_PATH_ALLOW_FILE_DISPERSION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @param array $value
     * @return array
     */
    public function checkJpeg(array $value): array
    {
        if (in_array('jpg', $value) && !in_array('jpeg', $value)) {
            $value[] = 'jpeg';
        }

        if (!in_array('jpg', $value) && in_array('jpeg', $value)) {
            $value[] = 'jpg';
        }
        return $value;
    }
}
