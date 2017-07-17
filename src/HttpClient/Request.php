<?php

namespace Fenix007\Wrapper\HttpClient;

use Fenix007\Wrapper\Models\AbstractModel;
use Illuminate\Support\Str;

/**
 * Class Request
 * @package Fenix007\Wrapper\HttpClient
 */
class Request
{
    const METHODS = [
        'GET',
        'HEAD',
        'PUT',
        'POST',
        'PATCH',
        'DELETE'
    ];

    const TIMESTAMP_FIELD = 'timestamp';

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $parameters;

    /**
     * Request constructor.
     *
     * @param string $path
     * @param string $method
     * @param array  $parameters
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($method = 'GET', $path = '/', array $parameters = [])
    {
        if (!in_array($method, self::METHODS)) {
            throw new \InvalidArgumentException("Unsupproted method '$method'");
        }

        $this->path       = $path;
        $this->method     = $method;
        $this->parameters = $parameters;

        $this->replaceVariables();
    }

    /**
     * Replace $params in url like {id} to it's value
     */
    public function replaceVariables()
    {
        $path    = $this->getPath();

        foreach ($this->parameters as $key => $value) {
            if (strpos($path, '{' . $key . '}') !== false) {
                $path = Str::replaceFirst('{' . $key . '}', $value, $path);
                unset($this->parameters[$key]);
            }
        }

        $this->setPath($path);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->checkModelInParams() ?
            [$this->toJson()] :
            $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters) : void
    {
        $this->parameters = $parameters;
    }

    public function addParameter(string $key, $value) : self
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public static function createFromMethod(array $method, array $options = []) : Request
    {
        return new static(
            $method['method'],
            $method['path'],
            $options
        );
    }

    protected function checkModelInParams() : bool
    {
        return count(array_filter($this->parameters, function ($el) {
            return $el instanceof AbstractModel;
        }));
    }

    public function toJson() : string
    {
        if (!count($this->parameters)) {
            return '';
        }

        $parameters = [];
        foreach ($this->parameters as $parameter) {
            $parameters []= $parameter instanceof AbstractModel ?
                $parameter->toJson() :
                $parameter;
        }

        return \json_encode($parameters);
    }

    public function addHeader($name, $value) : void
    {
        $headers = $this->parameters['headers'] ?? [];

        $headers[$name] = $value;

        $this->parameters['header'] = $headers;
    }

    public function addTimestamp() : self
    {
        $this->addParameter(static::TIMESTAMP_FIELD, time());

        return $this;
    }

    public function addSignature($value, $field = 'signature') : self
    {
        $this->addParameter($field, $value);

        return $this;
    }
}
