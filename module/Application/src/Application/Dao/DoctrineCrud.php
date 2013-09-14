<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/1/13
 */
namespace Application\Dao;

use Application\Logger\Factory as LoggerFactory;
use Logger;

abstract class DoctrineCrud extends Doctrine
{

    /**
     * @return Logger
     */
    protected function getLogger()
    {
        return LoggerFactory::get($this);
    }

    /**
     * @param $msg
     */
    protected function trace($msg)
    {
        $this->getLogger()->trace(__CLASS__.'::'.__FUNCTION__.' - '.$msg);
    }

    /**
     * @param object $model
     * @return object
     */
    public function save($model)
    {
        $this->trace('save: '.get_class($model));
        if ($model != null)
        {
            $this->getEntityManager()->persist($model);
        }

        return $model;
    }

    /**
     * Creates a model based on the supplied criteria.
     * @param object $model
     * @return object
     */
    public function create($model)
    {
        return $this->save($model);
    }

    /**
     * Deletes a model based on the supplied model criteria.
     * @param object $model
     * @return object
     */
    public function delete($model)
    {
        $this->trace('delete: '.get_class($model));
        if ($model != null)
        {
            $this->getEntityManager()->remove($model);
        }

        return $model;
    }

    /**
     * Loads a model based on the supplied model criteria.
     * @param int $id
     * @return object
     */
    public function load($id)
    {
        $this->trace('load: '.$id);
        $model = null;

        if ($id > -1)
        {
            $model = $this->getRepository()->findOneBy(array($this->getSingleIdentifierFieldName() => $id));
        }

        return $model;
    }


    /**
     * Returns collection of models
     * @return object[]
     */
    public function getList()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * Updates a model based on the supplied criteria.
     * @param object $model
     * @return object
     */
    public function update($model)
    {
        return $this->save($model);
    }

}