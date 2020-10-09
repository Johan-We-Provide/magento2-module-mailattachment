# Magento2 Module MailAttachment

Override the Magento TransportBuilder with attachment functionality

## Installation

1. `composer require weprovide/transportbuilder`
2. `bin/magento setup:upgrade`

## Usage example controller

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
## Usage example ViewModel
If you are using a ViewModel for your Block, extend the ViewModel with the ViewModel from MailAttachments
```php
<?php
namespace YourNameSpace\YourModule\ViewModel;

use WeProvide\MailAttachment\ViewModel\ViewModel;

class MyViewModel extends ViewModel
{

}
```
## Usage inside Block class (If ViewModel can't be loaded as a child of MyBlock)
If you want to load the MailAttachments ViewModel in your Block class
```php
<?php
namespace YourNameSpace\YourModule\Block;

use Magento\Framework\View\Element\Template;
use WeProvide\MailAttachment\ViewModel\ViewModelInterface;

class MyBlock extends Template
{
    /**
    * @var ViewModelInterface
    */
    protected $viewModel;

    /**
    * Block constructor

    * @param Template\Context $context
    * @param ViewModelInterface $viewModel
    * @param array $data
    */
    public function __construct(Template\Context $context, ViewModelInterface $viewModel, array $data = []) 
    {
        parent::__construct($context, $data);
        $this->viewModel = $viewModel;
    }
    
    /**
    * @return ViewModelInterface
    */
    public  function getViewModel()
    {
        return $this->viewModel;
    }

}
```

The ViewModel of the Mailattachments module has 3 methods that can be used to display the file input fields
```php
    /**
     * Get the amount of file input fields that can be shown on the form.
     *
     * @return string
     */
    public function getFileInputAmount();

    /**
     * Get the allowed file extensions for the file input fields
     *
     * @return array
     */
    public function getAllowedExtensions();

    /**
     * Get the html for the file input fields
     *
     * @param string $inputFieldName
     * @return string
     */
    public function getFileInputsHtml(string $inputFieldName = 'files');
```
## Api

`public function addAttachment(
    $content,
    $fileName = '',
    $fileType = ''
)`

For reference also check [the code](Model/TransportBuilder.php)
