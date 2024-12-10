<?php
/**
 * Copyright © Wubinworks. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Wubinworks\JwtAuthPatch\Plugin\JwtUserToken\Model;

use Wubinworks\JwtAuthPatch\Service\Reflection\ReflectionProperty;

/**
 * Fix the JWT authentication vulnerability due to a bug
 * @link https://experienceleague.adobe.com/en/docs/commerce-knowledge-base/kb/troubleshooting/known-issues-patches-attached/troubleshooting-encryption-key-rotation-cve-2024-34102
 */
class SecretBasedJwksFactory
{
    /**
     * @var ReflectionProperty
     */
    protected $reflectionProperty;

    /**
     * Constructor
     *
     * @param ReflectionProperty $reflectionProperty
     */
    public function __construct(
        ReflectionProperty $reflectionProperty
    ) {
        $this->reflectionProperty = $reflectionProperty;
    }

    /**
     * Remove old keys
     *
     * @param \Magento\JwtUserToken\Model\SecretBasedJwksFactory $subject
     * @return null
     */
    public function beforeCreateFor(
        \Magento\JwtUserToken\Model\SecretBasedJwksFactory $subject
    ) {
        $keys = $this->reflectionProperty->getPropertyValue(
            $subject,
            'keys',
            \Magento\JwtUserToken\Model\SecretBasedJwksFactory::class
        );
        $this->reflectionProperty->setPropertyValue(
            $subject,
            'keys',
            [end($keys)],
            \Magento\JwtUserToken\Model\SecretBasedJwksFactory::class
        );
        return null;
    }
}
