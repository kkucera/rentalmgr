<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/3/13
 */

namespace Application\Dto;

use Exception;

class ErrorResponse {

    /**
     * @var string
     */
    private $message;

    /**
     * @var Exception
     */
    private $exception;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @param \Exception $exception
     * @return ErrorResponse
     */
    public function setException($exception)
    {
        $this->exception = $exception;
        return $this;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param string $message
     * @return ErrorResponse
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        $message = $this->message;
        if($this->exception instanceof Exception){
            $message = $this->exception->getMessage();
        }
        return $message;
    }

    /**
     * @param string $uri
     * @return ErrorResponse
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param int $statusCode
     * @return ErrorResponse
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    protected function getExceptionArray()
    {
        if($this->exception){
            return array(
                'exception' => get_class($this->exception),
                'file' => $this->exception->getFile(),
                'line' => $this->exception->getLine(),
                'trace' => $this->exception->getTraceAsString()
            );
        }
        return array();
    }

    /**
     * @return array
     */
    public function getResponseArray()
    {
        return array(
            'error' => array(
                'status' => $this->statusCode,
                'message' => $this->getMessage(),
                'uri' => $this->getUri(),
                'exception' => $this->getExceptionArray()
            )
        );
    }

}