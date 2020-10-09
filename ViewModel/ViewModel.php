<?php

declare(strict_types=1);

namespace WeProvide\MailAttachment\ViewModel;

use WeProvide\MailAttachment\Model\ConfigInterface;
use \Magento\Framework\View\Element\BlockFactory;
use Magento\Framework\View\Element\Template;

class ViewModel implements ViewModelInterface
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var BlockFactory
     */
    protected $blockFactory;

    /**
     * ViewModel constructor.
     * @param ConfigInterface $config
     * @param BlockFactory $blockFactory
     */
    public function __construct(ConfigInterface $config, BlockFactory $blockFactory)
    {
        $this->config = $config;
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function getFileInputAmount(): string
    {
        return $this->config->getFileAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllowedExtensions(): array
    {
        return $this->config->getAllowedExtensions();
    }

    /**
     * {@inheritDoc}
     */
    public function getFileInputsHtml(string $inputFieldName = 'files'): string
    {
        $fileFields = "";

        for ($i = 0; $i < $this->getFileInputAmount(); $i++) {
            $fileFields .= '<div class="field file">' .
                '<label for="' . $inputFieldName . '[' . $i . ']"><span>' . __('file') . '</span></label>' .
                '<div class="control">' .
                '<input type="file" name="' . $inputFieldName . '[' . $i . ']" accept="' . $this->getAllowedExtensions() . '" class="input-text">' .
                '</div>' .
                '</div>';
        }

        return $fileFields;
    }
}
