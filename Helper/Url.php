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

namespace Encomage\Careers\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Url
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Helper
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Url extends AbstractHelper
{
    /**
     * Helper
     *
     * @var Config
     */
    protected $configHelper;

    /**
     * Url constructor.
     *
     * @param Context $context Context
     * @param Config  $config  Helper
     */
    public function __construct(Context $context, Config $config)
    {
        parent::__construct($context);
        $this->configHelper = $config;
    }

    /**
     * Get View Url
     *
     * @param int $identifier Identifier
     *
     * @return string
     */
    public function getViewUrl($identifier)
    {
        return $this->_getUrl(null, ['_direct' => $identifier]);
    }

    /**
     * Get Careers Url
     *
     * @return string
     */
    public function getCareersListUrl()
    {
        return $this->_getUrl(
            null,
            ['_direct' => $this->configHelper->getFrontendRouterLink()]
        );
    }
}