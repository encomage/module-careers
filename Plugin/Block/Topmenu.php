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

namespace Encomage\Careers\Plugin\Block;

use Encomage\Careers\Helper\Config as HelperConfig;
use Encomage\Careers\Helper\Url as UrlHelper;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Theme\Block\Html\Topmenu as HtmlTopmenu;

/**
 * Class Topmenu
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Plugin\Block
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Topmenu
{
    /**
     * Helper Url
     *
     * @var UrlHelper
     */
    protected $urlHelper;

    /**
     * Node Factory
     *
     * @var \Magento\Framework\Data\Tree\NodeFactory
     */
    private $nodeFactory;

    /**
     * Config Helper
     *
     * @var HelperConfig
     */
    private $configHelper;

    /**
     * Topmenu constructor.
     *
     * @param NodeFactory  $nodeFactory  Node Factory
     * @param UrlHelper    $urlHelper    Helper Url
     * @param HelperConfig $configHelper Config Helper
     */
    public function __construct(
        NodeFactory $nodeFactory,
        UrlHelper $urlHelper,
        HelperConfig $configHelper
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->configHelper = $configHelper;
        $this->urlHelper = $urlHelper;
    }

    /**
     * Before Get Html
     *
     * @param HtmlTopmenu $subject           Html Top Menu
     * @param string      $outermostClass    Outermost Class
     * @param string      $childrenWrapClass Wraps Class
     * @param int         $limit             Limit
     *
     * @return void
     */
    public function beforeGetHtml(
        HtmlTopmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        if ($this->configHelper->isEnabledOnFront()) {
            $node = $this->nodeFactory->create(
                [
                        'data' => [
                        'name' => $this->configHelper->getFrontendLinkTitle(),
                        'id'   => 'careers',
                        'url'  => $this->urlHelper->getCareersListUrl(),
                        ],
                        'idField'  => 'id',
                        'tree'     => $subject->getMenu()->getTree(),
                ]
            );
            $subject->getMenu()->addChild($node);
        }
    }
}