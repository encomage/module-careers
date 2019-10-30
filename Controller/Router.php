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

namespace Encomage\Careers\Controller;

use Encomage\Careers\Api\CareersRepositoryInterface;
use Encomage\Careers\Helper\Config;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\RouterInterface;

/**
 * Class Router
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Router implements RouterInterface
{
    /**
     * Action Factory
     *
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * Manager Interface
     *
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * Store Interface
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Careers Interface
     *
     * @var CareersRepositoryInterface
     */
    protected $careersRepository;

    /**
     * @var
     */
    protected $appState;

    /**
     * Url Interface
     *
     * @var UrlInterface
     */
    protected $url;

    /**
     * Response Interface
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Helper
     *
     * @var Config
     */
    protected $configHelper;

    /**
     * Router constructor.
     *
     * @param ActionFactory              $actionFactory     Action Factory
     * @param ManagerInterface           $eventManager      Manager Interface
     * @param UrlInterface               $url               Url Interface
     * @param CareersRepositoryInterface $careersRepository Careers Interface
     * @param Config                     $config            Helper
     * @param StoreManagerInterface      $storeManager      Store Interface
     * @param ResponseInterface          $response          Response Interface
     */
    public function __construct(
        ActionFactory $actionFactory,
        ManagerInterface $eventManager,
        UrlInterface $url,
        CareersRepositoryInterface $careersRepository,
        Config $config,
        StoreManagerInterface $storeManager,
        ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->eventManager = $eventManager;
        $this->url = $url;
        $this->careersRepository = $careersRepository;
        $this->storeManager = $storeManager;
        $this->response = $response;
        $this->configHelper = $config;
    }

    /**
     * Match
     *
     * @param \Magento\Framework\App\RequestInterface $request Request Interface
     *
     * @return \Magento\Framework\App\ActionInterface|null
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        if (!$this->configHelper->isEnabledOnFront()) {
            return null;
        }
        $identifier = trim($request->getPathInfo(), '/');
        $params = explode('/', $identifier);
        if (count($params) > 1) {
            $identifier = array_shift($params);
        }
        $condition = new \Magento\Framework\DataObject(
            ['identifier' => $identifier, 'continue' => true]
        );
        $this->eventManager->dispatch(
            'careers_controller_router_match_before',
            ['router' => $this, 'condition' => $condition]
        );
        $identifier = $condition->getIdentifier();
        if ($condition->getRedirectUrl()) {
            $this->response->setRedirect($condition->getRedirectUrl());
            $request->setDispatched(true);

            return $this->actionFactory
                ->create(\Magento\Framework\App\Action\Redirect::class);
        }
        if (!$condition->getContinue()) {
            return null;
        }
        if ($identifier == $this->configHelper->getFrontendRouterLink()) {
            $request->setModuleName('careers')
                ->setControllerName('index')
                ->setActionName('index');
        } else {
            try {
                $vacancy = $this->careersRepository->getByIdentifier($identifier);
            } catch (NoSuchEntityException $e) {
                return null;
            }
            $request->setModuleName('careers')
                ->setControllerName('view')
                ->setActionName('index')
                ->setParam('id', $vacancy->getId());
        }

        $request->setAlias(
            \Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS,
            $identifier
        );

        return $this->actionFactory
            ->create(\Magento\Framework\App\Action\Forward::class);
    }
}