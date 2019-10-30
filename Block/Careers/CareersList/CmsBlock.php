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

namespace Encomage\Careers\Block\Careers\CareersList;

use Encomage\Careers\Helper\Config;
use Magento\Framework\View\Element\Context;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Cms\Model\BlockFactory;
use Magento\Cms\Block\Block;

/**
 * Class CmsBlock
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Block\Careers\CareersList
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class CmsBlock extends Block
{
    /**
     * Helper
     *
     * @var Config
     */
    protected $configHelper;

    /**
     * CmsBlock constructor.
     *
     * @param Context               $context        Context
     * @param FilterProvider        $filterProvider FilterProvider
     * @param StoreManagerInterface $storeManager   Store Manager
     * @param BlockFactory          $blockFactory   Block Factory
     * @param Config                $config         Config
     * @param array                 $data           Data
     */
    public function __construct(
        Context $context,
        FilterProvider $filterProvider,
        StoreManagerInterface $storeManager,
        BlockFactory $blockFactory,
        Config $config,
        array $data = []
    ) {
        $this->configHelper = $config;
        parent::__construct(
            $context,
            $filterProvider,
            $storeManager,
            $blockFactory,
            $data
        );
    }

    /**
     * Get Block Id
     *
     * @return mixed
     */
    public function getBlockId()
    {
        return $this->configHelper->getFrontendListingCmsBlock();
    }
}