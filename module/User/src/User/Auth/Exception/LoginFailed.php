<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/7/13
 */

namespace User\Auth\Exception;

use Exception;

class LoginFailed extends Exception{

    public function __construct($messages){
        if(is_array($messages)){
            $messages = implode(', ',$messages);
        }
        parent::__construct($messages);
    }

}