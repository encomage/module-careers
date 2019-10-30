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

use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Config
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Helper
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Config extends AbstractHelper
{
    /**
     * Settings that are set in adminhtml
     */
    const
        XML_PATH_FRONTEND_IS_ENABLED        = 'careers_settings/frontend/is_enabled',
        XML_PATH_FRONTEND_ROUTER_LINK       = 'careers_settings/frontend/front_name',
        XML_PATH_FRONTEND_MENU_LINK_TITLE   = 'careers_settings/frontend/menu_link_title',
        XML_PATH_FRONTEND_LISTING_CMS_BLOCK = 'careers_settings/frontend/cms_block_listing_page',
        XML_PATH_SHARING_ADD_TO_ANY_CODE    = 'careers_settings/sharing_add_to_any/code',
        XML_PATH_TEXT_EMPTY_VACANCY_PAGE    = 'careers_settings/frontend/text_empty_vacancy_page',
        XML_PATH_SORT_BY                    = 'careers_settings/sort/sort_by',
        XML_PATH_SORT_ORDER                 = 'careers_settings/sort/sort_order',
        XML_PATH_MAX_SIZE_FOR_UPLOAD_FILE   = 'careers_settings/email_settings/max_size',
        XML_PATH_EMAIL_TEMPLATE             = 'careers_settings/email_settings/email_template',
        XML_PATH_ALLOWED_EXTENSION          = 'careers_settings/email_settings/allowed_extensions',
        XML_PATH_SEND_RECIPIENT_NAME        = 'careers_settings/email_settings/recipient_name',
        XML_PATH_SEND_RECIPIENT_EMAIL       = 'careers_settings/email_settings/recipient_email',
        XML_PATH_CAREERS_META_TITLE         = 'careers_settings/seo/meta_title',
        XML_PATH_CAREERS_META_KEYWORDS      = 'careers_settings/seo/meta_keywords',
        XML_PATH_CAREERS_META_DESCRIPTION   = 'careers_settings/seo/meta_description',
        XML_PATH_CAREERS_H1_PAGE_TITLE      = 'careers_settings/seo/h1_page_title';

    /**
     * Enable on Front
     *
     * @return bool
     */
    public function isEnabledOnFront()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_FRONTEND_IS_ENABLED);
    }

    /**
     * Get Frontend Link Title
     *
     * @return mixed
     */
    public function getFrontendLinkTitle()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_FRONTEND_MENU_LINK_TITLE);
    }

    /**
     * Get Frontend Router Link
     *
     * @return mixed
     */
    public function getFrontendRouterLink()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_FRONTEND_ROUTER_LINK);
    }

    /**
     * Get Frontend Listing CMS Block
     *
     * @return mixed
     */
    public function getFrontendListingCmsBlock()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_FRONTEND_LISTING_CMS_BLOCK);
    }

    /**
     * Get Share To any Code
     *
     * @return mixed
     */
    public function getShareToAnyCode()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SHARING_ADD_TO_ANY_CODE);
    }

    /**
     * Get Text Empty Vacancy Page
     *
     * @return mixed
     */
    public function getTextEmptyVacancyPage()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_TEXT_EMPTY_VACANCY_PAGE);
    }

    /**
     * Get Max Size for Uploader File
     *
     * @return mixed
     */
    public function getMaxSizeForUploadFile()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_MAX_SIZE_FOR_UPLOAD_FILE);
    }

    /**
     * Get Sort By
     *
     * @return mixed
     */
    public function getSortBy()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SORT_BY);
    }

    /**
     * Get Email Template
     *
     * @return mixed
     */
    public function getEmailTemplate()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_EMAIL_TEMPLATE);
    }

    /**
     * Get Allowed Extensions
     *
     * @return mixed
     */
    public function getAllowedExtensions()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ALLOWED_EXTENSION);
    }

    /**
     * Get Sort Order
     *
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SORT_ORDER);
    }

    /**
     * Get Recipient Name
     *
     * @return mixed
     */
    public function getRecipientName()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SEND_RECIPIENT_NAME);
    }

    /**
     * Get Recipient Email
     *
     * @return mixed
     */
    public function getRecipientEmail()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SEND_RECIPIENT_EMAIL);
    }

    /**
     * @return mixed
     */
    public function getCareersPageMetaTitle()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CAREERS_META_TITLE);
    }

    /**
     * @return mixed
     */
    public function getCareersPageMetaKeywords()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CAREERS_META_KEYWORDS);
    }

    /**
     * @return mixed
     */
    public function getCareersPageMetaDescription()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CAREERS_META_DESCRIPTION);
    }

    /**
     * @return mixed
     */
    public function getCareersPageH1Title()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CAREERS_H1_PAGE_TITLE);
    }
}
