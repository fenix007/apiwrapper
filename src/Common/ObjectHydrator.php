<?php

namespace Fenix007\Wrapper\Common;

use Fenix007\Wrapper\Models\AbstractModel;

/**
 * Utilisation class to hydrate objects.
 *
 * Class ObjectHydrator
 * @package Fenix007\Wrapper\Common
 */
class ObjectHydrator
{
    /**
     * Hydrate the object with data
     *
     * @param  AbstractModel    $object
     * @param  array            $data
     * @return AbstractModel
     * @throws \RuntimeException
     */
    public function hydrate(AbstractModel $object, $data = [])
    {
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (in_array($k, $object::$properties)) {
                    $object->$k = $v;
                }
            }
        }

        return $object;
    }

    /**
     * Transforms an under_scored_string to a camelCasedOne
     *
     * @see https://gist.github.com/troelskn/751517
     *
     * @param  string $candidate
     * @return string
     */
    public function camelize($candidate)
    {
        return lcfirst(
            implode(
                '',
                array_map(
                    'ucfirst',
                    array_map(
                        'strtolower',
                        explode(
                            '_',
                            $candidate
                        )
                    )
                )
            )
        );
    }
}
