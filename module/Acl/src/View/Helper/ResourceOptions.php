<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/29/13
 */

namespace Acl\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Acl\Resource\AbstractResource;

class ResourceOptions extends AbstractHelper
{

    /**
     * @return string
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @param AbstractResource[] $resources
     * @return string
     */
    public function checkboxes($resources)
    {
        $html = '<div class="resource-block">'.PHP_EOL;
        foreach($resources as $resource){
            $html.='<div class="resource-option"><input type="checkbox" name="resource[]" value="'.$resource->getResourceId().'">';
            $html.='<span class="resource-name">'.$resource->getName().'</span>';
            $html.=' - <span class="resource-description">'.$resource->getDescription().'</span>';
            if($resource->hasChildren()){
                $html.=$this->checkboxes($resource->getChildren());
            }
            $html.='</div>'.PHP_EOL;
        }
        $html.='</div>';
        return $html;
    }
}