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

namespace Encomage\Careers\Model\Config\Source;

use Encomage\Careers\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class Categories
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\Config\Source
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Categories implements ArrayInterface
{
    /**
     * Collection Factory
     *
     * @var CollectionFactory
     */
    private $careersCategoryCollectionFactory;

    /**
     * Options
     *
     * @var $_options
     */
    private $options;

    /**
     * Categories constructor.
     *
     * @param CollectionFactory $collectionFactory Collection Factory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->careersCategoryCollectionFactory = $collectionFactory;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $collection = $this->careersCategoryCollectionFactory->create()->toOptionArray();
            $emptyArr[] =
                [
                    'label' => ' ',
                    'value' => ' '
                ];
            $collection = array_merge($emptyArr, $collection);
            $this->options = $collection;
        }

        return $this->options;
    }
}