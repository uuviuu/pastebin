<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\App;
use ReflectionException;
use ReflectionMethod;

abstract class CustomException extends \Exception
{
    protected $debugInfo = '';
    protected $messageKey = null;
    protected $params = [];
    protected $defaultHandler = null;
    protected $statusCode = 400;
    protected $headers = array();

    public function __construct(...$arguments)
    {
        $defHandler = $this->defaultHandler;
        if (!is_null($defHandler)) {
            call_user_func_array([$this, $defHandler], $arguments);
        }
        parent::__construct($this->getText());
    }

    public function isInitialized(): bool
    {
        return !is_null($this->messageKey);
    }

    public function getKey()
    {
        return $this->messageKey;
    }

    /**
     * @throws ReflectionException
     */
    protected function defaultByHandler(): CustomException
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        $funcName = $trace[1]['function'];
        $className = $trace[1]['class'];
        $this->params = [];
        $methodRef = new ReflectionMethod($className, $funcName);
        foreach ($methodRef->getParameters() as $i => $param) {
            $this->params[$param->name] = $trace[1]['args'][$i];
        }
        $spl = explode('\\', get_class($this));
        $shortClassName = array_pop($spl);
        $this->messageKey = $shortClassName . ucfirst($funcName);
        $this->message = $this->getText();
        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getText($locale = null)
    {
        if (is_null($locale)) {
            $locale = App::getLocale();
        }
        return trans('exceptions.' . $this->messageKey, $this->params, null, $locale);
    }

    public function getDebugInfo(): string
    {
        return $this->debugInfo;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

}