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

namespace Encomage\Careers\Block\Careers\View;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Serialize\Serializer\Json;
use Encomage\Careers\Helper\Config;

/**
 * Class Form
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Block\Careers\View
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Form extends Template
{
    /**
     * Json
     *
     * @var Json
     */
    protected $_json;

    /**
     * Helper
     *
     * @var Config
     */
    protected $_helperConfig;

    /**
     * Form constructor.
     *
     * @param Template\Context $context      Context
     * @param Json             $json         Json
     * @param Config           $helperConfig Helper
     * @param array            $data         Data
     */
    public function __construct(
        Template\Context $context,
        Json $json,
        Config $helperConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_json = $json;
        $this->_helperConfig = $helperConfig;
    }

    /**
     * Get Submit Url
     *
     * @return string
     */
    public function getSubmitUrl()
    {
        return $this->getUrl('careers/send/email');
    }

    /**
     * Get Max Size
     *
     * @return bool|string
     */
    public function getMaxSizeInMb()
    {
        return round($this->_helperConfig->getMaxSizeForUploadFile() / 1000000);
    }

    /**
     * Get JS Config
     *
     * @return bool|string
     */
    public function getJsConfig()
    {
        $allowedExtensions = explode(
            ',',
            $this->_helperConfig->getAllowedExtensions()
        );

        return $this->_json->serialize(
            [
                'max_size'           => $this->_helperConfig
                    ->getMaxSizeForUploadFile(),
                'allowed_extensions' => $allowedExtensions,
            ]
        );
    }
}