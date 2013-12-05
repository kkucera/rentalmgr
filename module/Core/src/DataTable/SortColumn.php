<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/15/13
 */

namespace Core\DataTable;


class SortColumn {

    const DESC = 'DESC';
    const ASC = 'ASC';

    /**
     * @var int
     */
    private $column;

    /**
     * @var string
     */
    private $order;

    /**
     * @param $column
     * @param $order
     */
    public function __construct($column, $order)
    {
        $this->setColumn($column);
        $this->setOrder($order);
    }

    /**
     * @param int $column
     * @return SortColumn
     */
    public function setColumn($column)
    {
        $this->column = $column;
        return $this;
    }

    /**
     * @return int
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param string $order
     * @return SortColumn
     */
    public function setOrder($order)
    {
        $this->order = $order == self::ASC ? self::ASC : self::DESC;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }



}