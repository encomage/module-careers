<?php

/**
 * Encomage_Careers
 *
 * PHP version 7.0
 *
 * @category Magento2-module
 * @package  Encomage_Careers
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */

namespace Encomage\Careers\Controller\Send;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Encomage\Careers\Helper\Config;
use Magento\Framework\App\Action\Action;

/**
 * Class Email
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Send
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Email extends Action
{
    /**
     * Email Template
     */
    const CAREERS_EMAIL_TEMPLATE = 'careers_settings/email_settings/email_template';

    /**
     * Scope Config
     *
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Store Interface
     *
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Transport Builder
     *
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * Context
     *
     * @var Context
     */
    protected $context;

    /**
     * Uploader Factory
     *
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * File System
     *
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * Helper
     *
     * @var Config
     */
    protected $helperConfig;

    /**
     * Email constructor.
     *
     * @param ScopeConfigInterface  $scopeConfig      Scope Interface
     * @param StoreManagerInterface $storeManager     Store Manager
     * @param TransportBuilder      $transportBuilder Transport Builder
     * @param UploaderFactory       $uploaderFactory  Uploader Factory
     * @param Filesystem            $fileSystem       File System
     * @param Context               $context          Context
     * @param Config                $helperConfig     Helper
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        UploaderFactory $uploaderFactory,
        Filesystem $fileSystem,
        Context $context,
        Config $helperConfig
    ) {
        parent::__construct($context);
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        $this->_transportBuilder = $transportBuilder;
        $this->uploaderFactory = $uploaderFactory;
        $this->fileSystem = $fileSystem;
        $this->helperConfig = $helperConfig;
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if (!$post) {
            $this->messageManager->addErrorMessage(__('Incorrect params'));
            $result->setUrl($this->_redirect->getRefererUrl());

            return $result;
        } else {
            if (empty($post['name']) || empty($post['user_email'])) {
                $this->messageManager
                    ->addErrorMessage(
                        __('Name and e-mail is required fields')
                    );
                $result->setUrl($this->_redirect->getRefererUrl());

                return $result;
            } else {
                $validator = new \Zend\Validator\EmailAddress();
                if ($validator->isValid($post['user_email'])) {
                } else {
                    $this->messageManager
                        ->addErrorMessage('Invalid email address');
                    $result->setUrl($this->_redirect->getRefererUrl());

                    return $result;
                }
            }
        }
        foreach ($this->getRequest()->getFiles() as $key => $file) {
            switch ($key) {
            case 'resume':
                (empty($file['name'])) ?
                    $this->messageManager
                        ->addErrorMessage(__('Resume is required ')) :
                    $resume = $this->uploaderFactory->create(['fileId' => 'resume'])
                        ->validateFile();
                break;
            case 'letter':
                (empty($file['name'])) ?
                    $letter = null :
                    $letter = $this->uploaderFactory->create(['fileId' => 'letter'])
                        ->validateFile();
                break;
            }
        }
        $postObject = new \Magento\Framework\DataObject();
        $postObject->setData($post);
        $storeId = $this->_storeManager->getStore()->getId();
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $sender = [
            'name'  => $post['name'],
            'email' => $post['user_email'],
        ];
        $recipient = [
            'name'  => $this->helperConfig->getRecipientName(),
            'email' => $this->helperConfig->getRecipientEmail(),
        ];
        try {
            $this->_transportBuilder->setTemplateIdentifier(
                $this->_scopeConfig
                    ->getValue(self::CAREERS_EMAIL_TEMPLATE, $storeScope, $storeId)
            )
                ->setTemplateOptions(
                    ['area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                     'store' => $storeId]
                )
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($sender)
                ->addTo($recipient);
            if (!empty($resume)) {
                $this->_transportBuilder
                    ->addAttachment($resume['tmp_name'], $resume['name']);
            } else {
                $result->setUrl($this->_redirect->getRefererUrl());

                return $result;
            }
            if (!empty($letter)) {
                $this->_transportBuilder
                    ->addAttachment($letter['tmp_name'], $letter['name']);
            }
            $transport = $this->_transportBuilder->getTransport();
            $transport->sendMessage();
            $this->messageManager
                ->addSuccessMessage(__('Your resume was uploaded'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $path = (empty($this->helperConfig->getFrontendRouterLink()))
            ? 'careers'
            : $this->helperConfig->getFrontendRouterLink();

        return $result->setPath($path);
    }
}