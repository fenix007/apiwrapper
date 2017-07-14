<?php

namespace Fenix007\Wrapper\Mappers;

/**
 * Class SimpleMapper
 * @package Fenix007\Wrapper\Mappers
 */
class SimpleMapper extends AbstractMapper
{
    public function get()
    {
        return $this->response;
    }
}
