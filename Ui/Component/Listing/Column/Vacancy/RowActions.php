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

namespace Encomage\Careers\Ui\Component\Listing\Column\Vacancy;

use \Magento\Framework\UrlInterface;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\Escaper;

/**
 * Class RowActions
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Ui\Component\Listing\Column\Vacancy
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class RowActions extends Column
{
    /**
     * Url path
     */
    const
        URL_PATH_EDIT   = 'careers/index/edit',
        URL_PATH_DELETE = 'careers/index/delete';

    /**
     * Url Builder
     *
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * Escaper
     *
     * @var Escaper
     */
    private $escaper;

    /**
     * RowActions constructor.
     *
     * @param ContextInterface   $context            Context
     * @param UiComponentFactory $uiComponentFactory Ui Component Factory
     * @param Escaper            $escaper            Escaper
     * @param UrlInterface       $urlBuilder         Url Builder
     * @param array              $components         Components
     * @param array              $data               Data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Escaper $escaper,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->escaper = $escaper;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource Data Source
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['id'])) {
                    $title = $this->escaper->escapeHtml($item['title']);
                    $item[$this->getData('name')] = [
                        'edit'   => [
                            'href'  => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'id' => $item['id'],
                                ]
                            ),
                            'label' => __('Edit'),
                        ],
                        'delete' => [
                            'href'    => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'id' => $item['id'],
                                ]
                            ),
                            'label'   => __('Delete'),
                            'confirm' => [
                                'title'   => __('Delete %1', $title),
                                'message' =>
                                    __(
                                        'Are you sure you want to delete a %1 record?',
                                        $title
                                    ),
                            ],
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}