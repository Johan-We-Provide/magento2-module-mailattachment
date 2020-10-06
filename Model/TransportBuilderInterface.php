<?php

namespace WeProvide\MailAttachment\Model;

use Exception;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Exception\InvalidArgumentException;
use Magento\Framework\Mail\TemplateInterface;
use Magento\Framework\Mail\TransportInterface;

interface TransportBuilderInterface
{
    /**
     * Create the attachments for the email.
     *
     * @param array $files
     * @return array
     * @throws Exception
     */
    public function createAttachments(array $files);

    /**
     * @param mixed $content
     * @param string $filename
     * @param string $filetype
     * @return $this
     */
    public function addAttachment($content, string $filename, string $filetype);

    /**
     * Add cc address
     *
     * @param array|string $address
     * @param string $name
     *
     * @return $this
     */
    public function addCc($address, $name = '');

    /**
     * Add to address
     *
     * @param array|string $address
     * @param string $name
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addTo($address, $name = '');

    /**
     * Add bcc address
     *
     * @param array|string $address
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addBcc($address);

    /**
     * Set Reply-To Header
     *
     * @param string $email
     * @param string|null $name
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setReplyTo($email, $name = null);

    /**
     * Set mail from address by scopeId
     *
     * @param string|array $from
     * @param string|int|null $scopeId
     *
     * @return $this
     * @throws InvalidArgumentException
     * @throws MailException
     * @since 102.0.1
     */
    public function setFromByScope($from, $scopeId = null);

    /**
     * Set template identifier
     *
     * @param string $templateIdentifier
     *
     * @return $this
     */
    public function setTemplateIdentifier(string $templateIdentifier);

    /**
     * Set template model
     *
     * @param string $templateModel
     *
     * @return $this
     */
    public function setTemplateModel(string $templateModel);

    /**
     * Set template vars
     *
     * @param array $templateVars
     *
     * @return $this
     */
    public function setTemplateVars(array $templateVars);

    /**
     * Set template options
     *
     * @param array $templateOptions
     * @return $this
     */
    public function setTemplateOptions(array $templateOptions);

    /**
     * Get mail transport
     *
     * @return TransportInterface
     * @throws LocalizedException
     */
    public function getTransport();

    /**
     * Reset object state
     *
     * @return $this
     */
    public function reset();

    /**
     * Get template
     *
     * @return TemplateInterface
     */
    public function getTemplate();

    /**
     * Prepare message.
     *
     * @return $this
     * @throws LocalizedException if template type is unknown
     */
    public function prepareMessage();

    /**
     * Handles possible incoming types of email (string or array)
     *
     * @param string $addressType
     * @param string|array $email
     * @param string|null $name
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function addAddressByType(string $addressType, $email, ?string $name = null);
}
