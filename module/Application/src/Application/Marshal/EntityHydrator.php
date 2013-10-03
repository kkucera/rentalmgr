<?php
/**
 * Extends the Doctrine object hydrator to automatically add strategies for target types.
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 10/2/13
 */

namespace Application\Marshal;

use Application\Marshal\Strategy\DoctrineEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Application\Marshal\Strategy\DatetimeToString;
use DoctrineModule\Stdlib\Hydrator\Strategy\AllowRemoveByValue;
use DoctrineModule\Stdlib\Hydrator\Strategy\AllowRemoveByReference;

class EntityHydrator extends DoctrineObject
{

    /**
     * Prepare the hydrator by adding strategies to every collection valued associations
     *
     * @return void
     */
    protected function prepare()
    {
        $metadata = $this->metadata;

        $fieldNames = $metadata->getFieldNames();
        foreach ($fieldNames as $fieldName) {
            $type = $metadata->getTypeOfField($fieldName);
            if ($type === 'datetime') {
                $this->addStrategy($fieldName, new DatetimeToString());
            }
        }

        $associations = $metadata->getAssociationNames();
        foreach ($associations as $association) {
            // We only need to prepare collection valued associations
            if ($metadata->isCollectionValuedAssociation($association)) {
                if ($this->byValue) {
                    $this->addStrategy($association, new AllowRemoveByValue());
                } else {
                    $this->addStrategy($association, new AllowRemoveByReference());
                }
            }else{
                //echo ' association name: '.$association;
                $this->addStrategy($association, new DoctrineEntity());
            }
        }
    }

}