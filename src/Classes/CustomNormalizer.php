<?php
/**
 * Created by PhpStorm.
 * User: JonathanBarros
 * Date: 17/08/18
 * Time: 10:31
 */

namespace App\Classes;

use App\Entity\Person;
use App\Entity\ShipOrder;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorResolverInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CustomNormalizer extends ObjectNormalizer
{
    public function __construct(ClassMetadataFactoryInterface $classMetadataFactory = null, NameConverterInterface $nameConverter = null, PropertyAccessorInterface $propertyAccessor = null, PropertyTypeExtractorInterface $propertyTypeExtractor = null, ClassDiscriminatorResolverInterface $classDiscriminatorResolver = null)
    {
        parent::__construct($classMetadataFactory, $nameConverter, $propertyAccessor, $propertyTypeExtractor, $classDiscriminatorResolver);

        /**
         * This is a way to prevent the problem of Circular Reference
         * Because of the relations of entities to one another, the serialization enter in infinite loop
         * So here it is defined which data is returned upon the call of the relation method
         */
        $this->setCircularReferenceHandler(function ($object) {
            if ($object instanceof Person) {
                return $object->getName();
            } elseif ($object instanceof ShipOrder) {
                return $object->getOrderId();
            }
        });
    }
}