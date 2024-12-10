<?php
/**
 * Copyright © Wubinworks. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Wubinworks\JwtAuthPatch\Service\Reflection;

/**
 * Get and set class property value. Possible to modify private property.
 */
class ReflectionProperty
{
    /**
     * Get private property value
     *
     * @param object $object
     * @param string $name Property name
     * @param null|string $class Class for Reflection. If null, use the class of $object
     * @return mixed
     */
    public function getPropertyValue($object, string $name, ?string $class = null)
    {
        return $this->getProperty($object, $name, $class)->getValue($object);
    }

    /**
     * Set private property value
     *
     * @param object $object
     * @param string $name Property name
     * @param mixed $value Property value
     * @param null|string $class Class for Reflection. If null, use the class of $object
     * @return void
     */
    public function setPropertyValue($object, string $name, $value, ?string $class = null)
    {
        return $this->getProperty($object, $name, $class)->setValue($object, $value);
    }

    /**
     * Get reflection property
     *
     * @param object $object
     * @param string $name Property name
     * @param null|string $class Class for Reflection. If null, use the class of $object
     * @return \ReflectionProperty
     *
     * @throws \RuntimeException Don't throw \InvalidArgumentException, it will be caught
     */
    protected function getProperty($object, string $name, ?string $class = null): \ReflectionProperty
    {
        if (!is_object($object)) {
            throw new \RuntimeException(sprintf(
                'Type of parameter $object should be object, %s type was given.',
                // phpcs:ignore Magento2.Functions.DiscouragedFunction.Discouraged
                gettype($object)
            ));
        }
        if ($class === null) {
            $class = get_class($object);
        }
        return $this->getReflectionProperty(new \ReflectionClass($class), $name);
    }

    /**
     * Get reflection property
     *
     * @param \ReflectionClass $reflectionClass
     * @param string $name Property name
     * @return \ReflectionProperty
     *
     * @throws \RuntimeException
     */
    protected function getReflectionProperty(
        \ReflectionClass $reflectionClass,
        string $name
    ): \ReflectionProperty {
        if ($reflectionClass->hasProperty($name)) {
            $reflectionProperty = $reflectionClass->getProperty($name);
        } else {
            throw new \RuntimeException(sprintf(
                'Property "%s" is not found in class %s.',
                $name,
                $reflectionClass->getName()
            ));
        }

        if (PHP_VERSION_ID < 80100) {
            $reflectionProperty->setAccessible(true);
        }

        return $reflectionProperty;
    }
}
