<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/24/13
 */

namespace Organization\Controller;

use Auth\Controller\AuthenticatedController;
use InvalidArgumentException;
use Organization\Entity\Organization as OrganizationEntity;
use Organization\Service as OrganizationService;
use Zend\View\Model\ViewModel;

class OrganizationController extends AuthenticatedController
{

    /**
     * @var OrganizationService
     */
    private $organizationService;

    /**
     * @param OrganizationService $orgService
     */
    public function __construct(OrganizationService $orgService)
    {
        $this->organizationService = $orgService;
    }

    /**
     * @return array|ViewModel
     */
    public function indexAction()
    {
    }

    /**
     * @return ViewModel
     * @throws \InvalidArgumentException
     */
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $organization = $phone = $address = null;
        if(!empty($id)){
            /** @var OrganizationEntity $organization */
            $organization = $this->organizationService->load($id);
            if(empty($organization)){
                throw new InvalidArgumentException('A organization with id ['.$id.'] was not found');
            }
            $address = $organization->getAddress(0);
            $phone = $organization->getPhone(0);
        }

        return new ViewModel(array(
            'id' => $organization ? $organization->getId() : null,
            'name' => $organization ? $organization->getName() : null,
            'address1' => $address ? $address->getAddress1() : null,
            'address2' => $address ? $address->getAddress2() : null,
            'city' => $address ? $address->getCity() : null,
            'state' => $address ? $address->getState() : null,
            'zip' => $address ? $address->getZip() : null,
            'number' => $phone ? $phone->getNumber() : null,
        ));
    }
}