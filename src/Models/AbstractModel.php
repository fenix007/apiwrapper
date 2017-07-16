<?php
namespace Fenix007\Wrapper\Models;

/**
 * Class AbstractModel
 * @package Fenix007\Wrapper\Model
 */
abstract class AbstractModel
{
    /**
     * List of properties to populate by the ObjectHydrator
     *
     * @var array
     */
    public static $properties = [];

    /**
     * AbstractModel constructor.
     */
    public function __construct()
    {
        self::$properties = array_keys(get_object_vars($this));
    }

    public function toJson() : string
    {
        return \json_encode($this);
    }
}
