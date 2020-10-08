<?php

namespace SBCamp\CRMBundle\Helper;

class FieldNameHelper
{
    /**
     * @var string[]
     */
    private static $adjectiveArray = array('Tasty', 'Stale', 'Awesome', 'Hot', 'Cheap', 'Nasty', 'Best', 'Fresh', 'Delicious', 'Worst');

    /**
     * @var string[]
     */
    private static $tasteArray = array('Tangy', 'Sour', 'Sweet', 'Bitter', 'Salty', 'Spicy', 'Bland', 'Pungent', 'Astringent', 'Metallic');

    /**
     * @var string[]
     */
    private static $foodArray = array('Pizza', 'Soup', 'Salad', 'Burger', 'Dumplings', 'Lentils', 'Chicken', 'Cheese', 'Veggies', 'Bread');

    /**
     * @return string
     */
    public static function generateRandomFieldName(): string
    {
        $name = '';
        for ($index = 1; $index <= 8; $index++) {
            $ascii = random_int(97, 122);
            $char = chr($ascii);
            $name = $name . $char;
        }
        return $name;
    }

    /**
     * @param array $adjectiveArray
     * @param array $tasteArray
     * @param array $foodArray
     * @return string
     */
    public static function generateFieldName(array $adjectiveArray, array $tasteArray, array $foodArray): string
    {
        return $adjectiveArray[random_int(0, count($adjectiveArray) - 1)] . $tasteArray[random_int(0, count($tasteArray) - 1)] . $foodArray[random_int(0, count($foodArray) - 1)];
    }

    /**
     * @return string[]
     */
    public static function seedElasticFieldNames(): array
    {
        $combinations = array();
        $count = 0;

        while (true) {
            $alreadyInList = false;
            $fieldName = FieldNameHelper::generateFieldName(FieldNameHelper::$adjectiveArray, FieldNameHelper::$tasteArray, FieldNameHelper::$foodArray);
            for ($index = 0; $index < count($combinations); $index++) {
                if ($fieldName == $combinations[$index]) {
                    $alreadyInList = true;
                    break;
                }
            }

            if (!$alreadyInList) {
                $combinations[] = $fieldName;
                $count++;
            }

            if (count($combinations) == (count(FieldNameHelper::$adjectiveArray)*count(FieldNameHelper::$tasteArray)*count(FieldNameHelper::$foodArray))) {
                break;
            }
        }

        return $combinations;
    }
}