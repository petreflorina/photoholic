<?php

namespace AppBundle\Helper;

/**
 * |--------------------------------------------------------------------------
 *
 * @author : Florina Petre, August 2016
 *
 * |--------------------------------------------------------------------------
 *
 *
 *
 *
 *
 */

class EntityHelper
{
    /**
     * @param $propertyPath
     * @param $returnFormatted
     * @param string $format
     * @return \DateTime|null|string
     */
    public static function getDateTime($propertyPath, $returnFormatted, $format = \DateTime::ATOM)
    {
        if ($propertyPath instanceof \DateTime) {
            return $returnFormatted
                ?
                $propertyPath->format($format)
                :
                $propertyPath;
        }

        return null;
    }

}