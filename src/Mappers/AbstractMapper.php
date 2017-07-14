<?php

namespace Fenix007\Wrapper\Mappers;

use Illuminate\Support\Arr;
use Fenix007\Wrapper\Common\ObjectHydrator;
use Fenix007\Wrapper\Models\AbstractModel;

/**
 * Class Mapper
 * @package Fenix007\Wrapper\Mappers
 */
abstract class AbstractMapper
{
    /** @var  ObjectHydrator */
    protected $objectHydrator;
    protected $response;
    protected $time;
    protected $version;
    protected $errors;
    protected $status;

    /** @var  string */
    protected $model;
    protected $field;

    /**
     * Mapper constructor.
     * @param      $content
     * @throws \InvalidArgumentException
     */
    public function __construct($content)
    {
        if (! $response = @\json_decode($content, true)) {
            throw new \InvalidArgumentException('json_decode error: ' . json_last_error_msg());
        }

        if (isset($response['errors']) && count($response['errors'])) {
            throw new \InvalidArgumentException(implode(',', $response['errors']));
        }

        if (! $response['data']) {
            throw new \InvalidArgumentException('Response data');
        }

        $this->response = $response['data'];
        $this->status = $response['status'] ?? 400;
        $this->errors = $response['errors'] ?? [];

        if (isset($response['version'])) {
            $this->version = $response['version'];
        }

        $this->objectHydrator = new ObjectHydrator();
    }

    /**
     * @return \Fenix007\Wrapper\Models\AbstractModel|array
     */
    public function get()
    {
        $this->checkModelExists();

        $data = $this->response[$this->field] ?? $this->response;

        if (Arr::isAssoc($data)) {
            return $this->hydrateToModel($data);
        }

        return array_map([$this, 'hydrateToModel'], $data);
    }

    protected function hydrateToModel(array $data) : AbstractModel
    {
        return $this->objectHydrator->hydrate(new $this->model, $data);
    }

    protected function checkModelExists() : void
    {
        if (!$this->model) {
            throw new \InvalidArgumentException(sprintf(
                'Model for Mapper "%s" does not exists',
                get_class($this)
            ));
        }

        if (!class_exists($this->model)) {
            throw new \InvalidArgumentException(sprintf(
                'Model "%s" does not exists',
                $this->model
            ));
        }
    }
}
