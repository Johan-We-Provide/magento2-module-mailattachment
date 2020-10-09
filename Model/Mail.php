<?php

declare(strict_types=1);

namespace WeProvide\MailAttachment\Model;

use Exception;
use Magento\Framework\App\Area;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Contact\Model\ConfigInterface;

class Mail implements MailInterface
{
    /**
     * @var ConfigInterface
     */
    private $contactConfig;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * Initialize dependencies.
     *
     * @param ConfigInterface $contactConfig
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param DriverInterface $driver
     * @param StoreManagerInterface|null $storeManager
     */
    public function __construct(
        ConfigInterface $contactConfig,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        DriverInterface $driver,
        StoreManagerInterface $storeManager = null
    ) {
        $this->contactConfig = $contactConfig;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager ?: ObjectManager::getInstance()->get(StoreManagerInterface::class);
        $this->driver = $driver;
    }

    /**
     * @inheritDoc
     */
    public function send($replyTo, array $variables, array $attachments = null, $config = null)
    {
        if (is_null($config)) {
            $config = $this->contactConfig;
        }
        $replyToName = !empty($variables['data']['name']) ? $variables['data']['name'] : null;

        $this->inlineTranslation->suspend();
        try {
            $builder = $this->transportBuilder
                ->setTemplateIdentifier($config->emailTemplate())
                ->setTemplateOptions(
                    [
                        'area' => Area::AREA_FRONTEND,
                        'store' => $this->storeManager->getStore()->getId()
                    ]
                )
                ->setTemplateVars($variables)
                ->setFromByScope($config->emailSender())
                ->addTo($config->emailRecipient(), 'Name')
                ->setReplyTo($replyTo, $replyToName);
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $file = $attachment['path'] . $attachment['file'];
                    $builder = $builder->addAttachment(
                        $this->driver->fileGetContents($file),
                        $attachment['type'],
                        $attachment['name']
                    );
                }
            }

            $transport = $builder->getTransport();

            if ($variables) {
                $transport->sendMessage();
            }
        } finally {
            $this->inlineTranslation->resume();
        }
    }

    /**
     * @inheritDoc
     */
    public function validatedParams(array $params)
    {
        $toCheck = $params;

        if (isset($toCheck['g-recaptcha-response'])) {
            unset($toCheck['g-recaptcha-response']);
        }

        if (isset($toCheck['recaptcha-validate-'])) {
            unset($toCheck['recaptcha-validate-']);
        }

        foreach ($toCheck as $param => $value) {
            if ($param == 'hideit' && !empty($value)) {
                throw new Exception();
            } elseif ($param != 'hideit' && empty($value)) {
                throw new LocalizedException(__($param));
            }
        }

        return $params;
    }
}
