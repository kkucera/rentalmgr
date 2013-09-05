<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/1/13
 */
namespace Application\Dao;

abstract class DoctrineCrud extends Doctrine
{

    /**
     * @param object $model
     * @return object
     */
    protected function save($model)
    {
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