<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/28/13
 */

namespace Application\Controller;

use Application\CrudServiceAbstract;
use Application\Exception\EntityNotFound;
use InvalidArgumentException;
use Application\Marshal\ArrayToEntity;
use Application\Marshal\EntityToArray;
use Application\Marshal\EntitiesToArray;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\View\Model\JsonModel;
use Application\Hydrator\Entity as EntityHydrator;

abstract class AbstractCrudServiceController extends AbstractServiceController
{

    /**
     * @return Object
     */
    abstract protected function getEntity();

    /**
     * @return CrudServiceAbstract
     */
    abstract protected function getEntityService();

    /**
     * @return EntityHydrator
     */
    protected function getEntityHydrator()
    {
        return new EntityHydrator($this->getEntity());
    }

    public function indexAction()
    {
        throw new ServiceNotFoundException('There is no default crud service.');
    }

    /**
     * Hook for validating and filtering data
     * @param $data
     */
    protected function createPrepareData($data)
    {
        return $data;
    }

    /**
     * Hook for child classes to modify the entity before it is saved.
     * @param $entity
     * @return mixed
     */
    protected function createPrepareEntity($entity)
    {
        return $entity;
    }

    public function createAction()
    {
        $data = $_POST;

        $data = $this->createPrepareData($data);

        $hydrator = $this->getEntityHydrator();
        $entity = $hydrator->hydrate($data, $this->getEntity());

        $entity = $this->createPrepareEntity($entity);

        $service = $this->getEntityService();
        $entity = $service->save($entity);

        return new JsonModel($hydrator->extract($entity));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('Missing required parameter [id].');
        }

        $service = $this->getEntityService();
        $service->delete($id);

        return new JsonModel(array(
            'id' => $id,
            'success' => true,
        ));
    }

    public function getAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('Missing required parameter [id].');
        }

        $service = $this->getEntityService();
        $entity = $service->load($id);
        if(empty($entity)){
            throw new EntityNotFound('The entity '.get_class($this->getEntity()).' with id ['.$id.'] was not found.');
        }

        $hydrator = $this->getEntityHydrator();

        return new JsonModel($hydrator->extract($entity));
    }

    public function updateAction()
    {
        $data = $_POST;

        $id = (int) $this->params()->fromRoute('id', 0);
        if(empty($id)){
            throw new InvalidArgumentException('Missing required parameter [id].');
        }

        $service = $this->getEntityService();
        $entity = $service->load($id);
        if(empty($entity)){
            throw new EntityNotFound('The entity '.get_class($this->getEntity()).' with id ['.$id.'] was not found.');
        }

        $hydrator = $this->getEntityHydrator();
        $entity = $hydrator->hydrate($data, $entity);

        return new JsonModel($hydrator->extract($entity));
    }

    public function getListAction()
    {
        $service = $this->getEntityService();
        $entities = $service->getList();
        $hydrator = $this->getEntityHydrator();
        return new JsonModel($hydrator->extractAll($entities));
    }

}