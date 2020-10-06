# Magento2 Module MailAttachment

Override the Magento TransportBuilder with attachment functionality

## Installation

1. `composer require weprovide/transportbuilder`
2. `bin/magento setup:upgrade`

## Usage example

```php
<?php
namespace YourNameSpace\YourModule\Controller\Email;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\DataObject;
use WeProvide\MailAttachment\Model\TransportBuilderInterface;

class Index extends Action
{
    protected $transportBuilder;

    /**
     * @var ContactConfigInterface
     */
    protected $contactConfig;

    public function __construct(
        Context $context,
        ContactConfigInterface $contactConfig,
        TransportBuilderInterface $transportBuilder
    ) {
        $this->transportBuilder  = $transportBuilder;
        parent::__construct($context);
    }

    /**
     * Execute view action
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $params = $this->mail->validatedParams($this->getRequest()->getParams());
        $attachments = $this->transportBuilder->createAttachments($this->getRequest()->getFiles()['images']);
        $this->mail->send(
                    $params['email'],
                    ['data' => new DataObject($params)],
                    $attachments,
                    $this->contactConfig
                );

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
```

## Api

`public function addAttachment(
    $content,
    $fileName = '',
    $fileType = ''
)`

For reference also check [the code](Model/TransportBuilder.php)
