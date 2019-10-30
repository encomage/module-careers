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

namespace Encomage\Careers\Block\Adminhtml\Careers\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\RequestInterface;

/**
 * Class GenericButton
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Block\Adminhtml\Careers\Edit
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class GenericButton
{
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * Request
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * GenericButton constructor.
     *
     * @param Context          $context  Context
     * @param Registry         $registry Registry
     * @param RequestInterface $request  Request
     */
    public function __construct(
        Context $context,
        Registry $registry,
        RequestInterface $request
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
        $this->request = $request;
    }

    /**
     * Get Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->request->getParam('id', null);
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route  Route
     * @param array  $params Params
     *
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}