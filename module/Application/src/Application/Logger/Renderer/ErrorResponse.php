<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/6/13
 */

namespace Application\Logger\Renderer;

use Application\Dto\ErrorResponse as ErrorResponseDto;
use Exception;
use LoggerRenderer;

class ErrorResponse implements LoggerRenderer
{

    /**
     * @param ErrorResponseDto $errorResponse
     * @return string
     */
    public function render($errorResponse)
    {
        $result = $errorResponse->getMessage();
        $result.= PHP_EOL.'URI: '.$errorResponse->getUri();
        $result.= $this->renderException($errorResponse->getException());


        return $result;
    }

    /**
     * @param Exception $exception
     * @return string
     */
    private function renderException($exception, $indent=3)
    {
        $result = '';
        if($exception){
            $result.= PHP_EOL.'Exception: '.get_class($exception);
            $result.= PHP_EOL.'File: '.$exception->getFile();
            $result.= PHP_EOL.'Line: '.$exception->getLine();
            $result.= PHP_EOL.$exception->getTraceAsString();
            $result.=$this->renderException($exception->getPrevious());
        }
        return $result;
    }

}