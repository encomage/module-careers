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

namespace Encomage\Careers\Model\Careers;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use Encomage\Careers\Model\ResourceModel\Careers\CollectionFactory;

/**
 * Class DataProvider
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\Careers
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * Loaded Data
     *
     * @var $_loadedData
     */
    private $loadedData;

    /**
     * Data Interface
     *
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * DataProvider constructor.
     *
     * @param string                 $name                     Name
     * @param string                 $primaryFieldName         Primary Field Name
     * @param string                 $requestFieldName         Request Field Name
     * @param CollectionFactory      $contactCollectionFactory Collection
     * @param DataPersistorInterface $dataPersistor            Data Persistor
     * @param array                  $meta                     Mata
     * @param array                  $data                     Data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $contactCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }

    /**
     * Get Data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $career) {
            $this->loadedData[$career->getId()] = $career->getData();
        }
        $data = $this->dataPersistor->get('careers_item');
        if (!empty($data)) {
            $item = $this->collection->getNewEmptyItem();
            $item->setData($data);
            $this->loadedData[$item->getId()] = $item->getData();
            $this->dataPersistor->clear('careers_item');
        }

        return $this->loadedData;
    }
}