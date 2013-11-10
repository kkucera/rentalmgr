<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/27/13
 */

namespace Auth\Initializer\Interfaces;

use User\Entity\User;

interface RequireAuthenticationInterface
{
    /**
     * @return User
     */
    public function getUser();

    /**
     * @param User $user
     */
    public function setUser(User $user);


}