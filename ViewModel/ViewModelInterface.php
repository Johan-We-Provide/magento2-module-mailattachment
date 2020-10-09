<?php

declare(strict_types=1);

namespace WeProvide\MailAttachment\ViewModel;
use Magento\Framework\View\Element\Block\ArgumentInterface;

interface ViewModelInterface extends ArgumentInterface
{
    /**
     * Get the amount of file input fields that can be shown on the form.
     *
     * @return string
     */
    public function getFileInputAmount(): string;

    /**
     * Get the allowed file extensions for the file input fields
     *
     * @return array
     */
    public function getAllowedExtensions(): array;

    /**
     * Get the html for the file input fields
     *
     * @param string $inputFieldName
     * @return string
     */
    public function getFileInputsHtml(string $inputFieldName = 'files'): string;
}
