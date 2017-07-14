<?php

namespace Fenix007\Wrapper\Mappers;

trait MapperTrait
{
    /**
     * @param string|\Closure $mapper
     *
     * @return string|\Closure
     */
    public function checkMapper($mapper)
    {
        if (is_string($mapper) &&
            class_exists($mapper) &&
            is_subclass_of($mapper, AbstractMapper::class, true)
        ) {
            return $mapper;
        }

        if ($mapper instanceof \Closure) {
            return $mapper;
        }

        return null;
    }

    /**
     * @param string|\Closure $mapper
     *
     * @return mixed
     */
    public function map($mapper)
    {
        $data = $this->getContentOrNull();
        $mapper = $this->checkMapper($mapper);

        if (!$mapper) {
            return $data;
        }

        if ($mapper instanceof \Closure) {
            return call_user_func_array($mapper, [$data]);
        }

        /** @var AbstractMapper $mapper */
        $mapper = new $mapper($data);

        return $mapper->get();
    }
}
