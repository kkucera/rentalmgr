<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 9/2/13
 */

namespace User\Controller\Service;

use Application\Controller\AbstractCrudServiceController;
use User\Dto\SearchCriteria;
use User\Entity\User;
use User\Service as UserService;
use Zend\View\Model\JsonModel;

class UserController extends AbstractCrudServiceController
{
    /**
     * @return Object
     */
    protected function getEntity()
    {
        return new User();
    }

    /**
     * @return UserService
     */
    protected function getEntityService()
    {
        return $this->getServiceLocator()->get('User\Service');
    }

    /**
     * @return JsonModel
     */
    public function searchAction()
    {
        $data = $this->params()->fromPost();

        $searchType = $data['type']?: 'name';
        $searchValue = $data['value']?: '';

        $searchCriteria = new SearchCriteria();
        if($searchType == 'email'){
            $searchCriteria->setEmail($searchValue);
        }else{
            $searchCriteria->setName($searchValue);
        }

        $results = $this->getEntityService()->searchUsers($searchCriteria);
        $hydrator = $this->getEntityHydrator();
        return new JsonModel(array(
            'users'=>$hydrator->extractAll($results)
        ));
    }
}