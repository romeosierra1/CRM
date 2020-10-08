<?php

namespace SBCamp\ElasticSearchBundle\Mapper;

use Doctrine\Common\Annotations\AnnotationReader;

class DoctrineEntityToElasticSearchMapping
{
    /**
     * @param $object
     * @return array
     */
    public static function getPropertiesArray($object):array
    {
        $properties = array();
        if($object != null)
        {
            $reflectionClass = new \ReflectionClass($object);;
            $reflectionProps = $reflectionClass->getProperties();
            foreach ($reflectionProps as $reflectionProp) {
                $reader = new AnnotationReader();
                $annotations = $reader->getPropertyAnnotations($reflectionProp);
                foreach ($annotations as $annotation) {
                    $annotationArray = (array)$annotation;
                    if (is_a($annotation, 'Doctrine\ORM\Mapping\Id')) {
                        // Do Something
                    } elseif (is_a($annotation, 'Doctrine\ORM\Mapping\Column')) {
                        $properties[$reflectionProp->getName()] = array('type' => $annotationArray['type']);
                    } elseif (is_a($annotation, 'Doctrine\ORM\Mapping\OneToOne')) {
                        // Do Something
                    } elseif (is_a($annotation, 'Doctrine\ORM\Mapping\OneToMany')) {
                        if($annotationArray['targetEntity'] != $reflectionClass->getName()) {
                            //$entityReflection = new \ReflectionClass($annotationArray['targetEntity']);
                            //$entityReflectionObj = new EntityToESMapping( $entityReflection->newInstanceArgs());
                            //$this->properties[$reflectionProp->getName()] = $entityReflectionObj->getPropertiesArray();
                        }
                    } elseif (is_a($annotation, 'Doctrine\ORM\Mapping\ManyToOne')) {
                        $entityReflection = new \ReflectionClass($annotationArray['targetEntity']);
                        $properties[$reflectionProp->getName()] = DoctrineEntityToElasticSearchMapping::getPropertiesArray($entityReflection->newInstanceArgs());
                    } elseif (is_a($annotation, 'Doctrine\ORM\Mapping\ManyToMany')) {
                        // Do something
                    }

                }
            }
        }
        return $properties;
    }
}
