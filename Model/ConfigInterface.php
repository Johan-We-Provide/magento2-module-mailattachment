<?php


namespace WeProvide\MailAttachment\Model;


interface ConfigInterface
{
    /**
     * Enabled xml config path
     */
    const XML_PATH_ENABLED = 'mail_attachments/general/enabled';

    /**
     * Amount of files on the form xml path
     */
    const XML_PATH_FILE_AMOUNT = 'mail_attachments/settings/add_file_amount';

    /**
     * The allowed extensions for uploading xml path
     */
    const XML_PATH_ALLOWED_EXTENSIONS = 'mail_attachments/settings/allowed_extensions';

    /**
     * Allow file renaming or not xml path
     */
    const XML_PATH_ALLOW_FILE_RENAME = 'mail_attachments/settings/allow_file_rename';

    /**
     * Allow file dispersion or not xml path
     */
    const XML_PATH_ALLOW_FILE_DISPERSION = 'mail_attachments/settings/allow_file_dispersion';

    /**
     * Check if transport builder module is enabled
     *
     * @return bool
     * @since 100.2.0
     */
    public function isEnabled();

    /**
     * Get the file amount allowed on the form
     *
     * @return string
     * @since 100.2.0
     */
    public function getFileAmount();

    /**
     * Get the allowed extensions
     *
     * @param bool $asArray
     * @return string|array
     * @since 100.2.0
     */
    public function getAllowedExtensions($asArray = false);

    /**
     * Check if file renaming is allowed
     *
     * @return bool
     * @since 100.2.0
     */
    public function isAllowedFileRenaming();

    /**
     * Check if file dispersion is enabled
     *
     * @return bool
     * @since 100.2.0
     */
    public function isAllowedFileDispersion();
}
