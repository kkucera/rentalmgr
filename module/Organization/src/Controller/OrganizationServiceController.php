<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/24/13
 */

namespace Organization\Controller;

use Application\Controller\AbstractCrudServiceController;
use Core\DataTable\SearchCriteria as DataTableSearchCriteria;;
use Core\Service\Address as AddressService;
use Core\Service\Phone as PhoneService;
use Organization\Entity\Organization as OrganizationEntity;
use Organization\Service as OrganizationService;
use Zend\View\Model\JsonModel;

class OrganizationServiceController extends AbstractCrudServiceController
{

    /**
     * @var AddressService
     */
    private $addressService;

    /**
     * @var OrganizationService
     */
    private $organizationService;

    /**
     * @var PhoneService
     */
    private $phoneService;

    /**
     * @param OrganizationService $orgService
     * @param AddressService $addressService
     * @param PhoneService $phoneService
     */
    public function __construct(
        OrganizationService $orgService,
        AddressService $addressService,
        PhoneService $phoneService
    )
    {
        $this->organizationService = $orgService;
        $this->addressService = $addressService;
        $this->phoneService = $phoneService;
    }

    /**
     * @return OrganizationEntity
     */
    protected function getEntity()
    {
        return new OrganizationEntity;
    }

    /**
     * @return OrganizationService
     */
    protected function getEntityService()
    {
        return $this->organizationService;
    }

    /**
     * @param \Core\Service\Address $addressService
     * @return OrganizationServiceController
     */
    public function setAddressService($addressService)
    {
        $this->addressService = $addressService;
        return $this;
    }

    /**
     * @return \Core\Service\Address
     */
    public function getAddressService()
    {
        return $this->addressService;
    }

    /**
     * @param \Core\Service\Phone $phoneService
     * @return OrganizationServiceController
     */
    public function setPhoneService($phoneService)
    {
        $this->phoneService = $phoneService;
        return $this;
    }

    /**
     * @return \Core\Service\Phone
     */
    public function getPhoneService()
    {
        return $this->phoneService;
    }

    /**
     * @return JsonModel
     */
    public function dataTableAction()
    {
        $params = $this->params()->fromPost();

        $searchCriteria = new DataTableSearchCriteria($params);
        /** @var OrganizationEntity[] $results */
        $results = $this->getEntityService()->getOrganizationList($searchCriteria);

        $data = array();
        foreach($results as $user){
            $data[] = array(
                $user->getId(),
                $user->getName(),
                $user->getCreated('Y-m-d H:i'),
                $user->getModified('Y-m-d H:i')
            );
        }

        return new JsonModel(array(
            'sEcho' => $params['sEcho'],
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($results),
            'aaData' => $data
        ));
    }

    /**
     *
     */
    public function saveAction()
    {
        $data = $this->params()->fromPost();

        $hydrator = $this->getEntityHydrator();
        /** @var OrganizationEntity $organization */
        $organization = $hydrator->hydrate($data, $this->getEntity());

        // remove id so hydration won't try to load the object again.
        unset($data['id']);

        $this->savePhone($data, $organization);
        $this->saveAddress($data, $organization);

        $service = $this->getEntityService();
        $organization = $service->save($organization);

        return new JsonModel($hydrator->extract($organization));
    }

    /**
     * @param $data
     * @param OrganizationEntity $organization
     */
    protected function savePhone($data, OrganizationEntity $organization)
    {
        $phoneService = $this->getPhoneService();
        if($organization->getPhoneCount() > 0){
            $phone = $organization->getPhone(0);
        }else{
            $phone = $phoneService->getPhoneEntity();
            $organization->setPhones(array($phone));
        }
        $hydrator = $this->getEntityHydrator($phone);
        $hydrator->hydrate($data,$phone);
        $phoneService->save($phone);
    }

    /**
     * @param $data
     * @param OrganizationEntity $organization
     */
    protected function saveAddress($data, OrganizationEntity $organization)
    {
        $addressService = $this->getAddressService();
        if($organization->getAddressCount() > 0){
            $address = $organization->getAddress(0);
        }else{
            $address = $addressService->getAddressEntity();
            $organization->setAddresses(array($address));
        }
        $hydrator = $this->getEntityHydrator($address);
        $hydrator->hydrate($data,$address);
        $addressService->save($address);
    }
}