<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 8/31/13
 */
namespace Books\Controller;

use Books\Entity\Expense;
use Property\Marshal\ArrayToProperty;
use User\Controller\AuthenticatedController;
use Books\Expense\Service;

class ExpenseController extends AuthenticatedController
{
    /**
     * @return Expense
     */
    protected function getExpense()
    {
        return new Expense();
    }

    /**
     * @return ArrayToProperty
     */
    protected function getArrayToPropertyMarshaller()
    {
        return new ArrayToProperty();
    }

    /**
     * @return Service
     */
    protected function getExpenseService()
    {
        return new Service();
    }

    public function indexAction()
    {
    }

    public function addAction()
    {
        $data = $_POST;

        $marshaller = $this->getArrayToPropertyMarshaller();
        $expense = $marshaller->marshal($data);

        $service = $this->getExpenseService();
        $expense = $service->create($expense);

        die(var_dump($expense->getId())); // yes, I'm lazy
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}