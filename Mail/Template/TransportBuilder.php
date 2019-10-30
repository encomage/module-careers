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

namespace Encomage\Careers\Mail\Template;

/**
 * Class TransportBuilder
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Mail\Template
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
    /**
     * Add Attachment
     *
     * @param string $file File
     * @param string $name Name
     *
     * @return $this
     */
    public function addAttachment($file, $name)
    {
        if (!empty($file) && file_exists($file)) {
            $this->message
                ->createAttachment(
                    file_get_contents($file),
                    \Zend_Mime::TYPE_OCTETSTREAM,
                    \Zend_Mime::DISPOSITION_ATTACHMENT,
                    \Zend_Mime::ENCODING_BASE64,
                    basename($name)
                );
        }

        return $this;
    }
}