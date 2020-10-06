<?php

namespace WeProvide\MailAttachment\Model;

use Exception;

interface MailInterface
{
    /**
     * Send email from contact form
     *
     * @param string $replyTo Reply-to email address
     * @param array $variables Email template variables
     * @param null $config
     * @param array|null $attachments
     * @return void
     * @since 100.2.0
     */
    public function send($replyTo, array $variables, array $attachments = null, $config = null);

    /**
     * Validate the parameters coming from the form.
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function validatedParams(array $params);
}
