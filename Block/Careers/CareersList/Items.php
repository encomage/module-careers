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

use Magento\Framework\View\Element\Template\Context;
use Encomage\Careers\Helper\Data as DataHelper;
use Magento\Framework\View\Element\Template;
use Encomage\Careers\Helper\Config as ConfigHelper;

/**
 * Class Items
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Block\Careers\CareersList
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Items extends Template
{
    /**
     * Categories Block
     *
     * @var Categories
     */
    protected $categoriesBlock;

    /**
     * Data Helper
     *
     * @var DataHelper
     */
    protected $dataHelper;

    /**
     * Default Template
     *
     * @var string
     */
    protected $defaultTemplate = 'Encomage_Careers::list/items.phtml';

    /**
     * Config Helper
     *
     * @var ConfigHelper
     */
    protected $configHelper;

    /**
     * Items constructor.
     *
     * @param Context    $context    Context
     * @param DataHelper $dataHelper Data Helper
     * @param ConfigHelper $configHelper Config Helper
     * @param array      $data       Data
     */
    public function __construct(
        Context $context,
        DataHelper $dataHelper,
        ConfigHelper $configHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->dataHelper = $dataHelper;
        $this->configHelper = $configHelper;
        $this->setTemplate($this->defaultTemplate);
    }

    /**
     * Get Careers Items
     *
     * @return mixed
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCareersItems()
    {
        return $this->dataHelper->getCareersItems((int)$this->getCareersCategoryId());
    }

    /**
     * Get Categories Block
     *
     * @return Categories
     */
    public function getCategoriesBlock()
    {
        return $this->categoriesBlock;
    }

    /**
     * Set Categories Block
     *
     * @param Categories $categories Categories
     *
     * @return $this
     */
    public function setCategoriesBlock(Categories $categories)
    {
        $this->categoriesBlock = $categories;

        return $this;
    }

    /**
     * No vacancy text
     *
     * @return mixed
     */
    public function getNoVacancyText()
    {
        return $this->configHelper->getTextEmptyVacancyPage();
    }
}
