<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/9/13
 */

namespace Acl\Marshal;

use Acl\Entity\UserGroup;

class UserGroupsWithResourceNamesToArray {

    /**
     * @param UserGroup[] $userGroups
     * @return array
     */
    public function marshal($userGroups)
    {
        $marshaled = array();
        foreach($userGroups as $userGroup){
            $group = $userGroup->getGroup();
            $resources = array();
            foreach($group->getResources() as $resource){
                $resources[] = $resource->getId();
            }
            $marshaled[] = array(
                'name'=>$group->getName(),
                'id'=>$group->getId(),
                'resources' => $resources
            );
        }
        return $marshaled;
    }

}