<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/31/13
 */

namespace Acl\Marshal;

use Acl\Resource\AbstractResource;

class ResourceToArray
{
    /**
     * @param AbstractResource $resource
     * @return array
     */
    public function marshal(AbstractResource $resource)
    {
        return array(
            'resourceId'=>$resource->getResourceId(),
            'name'=>$resource->getName(),
            'description'=>$resource->getDescription(),
            'children'=>($resource->hasChildren()?array_map( array($this,'marshal'), $resource->getChildren() ) : array())
        );
    }
}