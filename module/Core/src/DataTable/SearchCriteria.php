<?php
/**
 * @category Kevin Kucera
 * @package rentalmgr
 * @copyright Copyright (c) 2013 Kevin Kucera
 * @user: kevin
 * @date: 11/15/13
 */

namespace Core\DataTable;

use Core\DataTable\SortColumn;

class SearchCriteria {
    /**
     * @var string
     */
    private $searchTerm;

    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var SortColumn[]
     */
    private $sortColumns;

    /**
     * @param $params
     */
    public function __construct($params)
    {
        $this->setSearchTerm($params['sSearch']);
        $this->setLimit($params['iDisplayLength']);
        $this->setStart($params['iDisplayStart']);
        for ( $i=0 ; $i<intval( $params['iSortingCols'] ) ; $i++ ){
            if ( $params[ 'bSortable_'.intval($params['iSortCol_'.$i]) ] == "true" ){
                $order = ($params['sSortDir_'.$i] === 'asc' ? SortColumn::ASC : SortColumn::DESC);
                $this->addSortColumn(new SortColumn($i, $order));
            }
        }
    }

    /**
     * @param int $limit
     * @return SearchCriteria
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param string $searchTerm
     * @return SearchCriteria
     */
    public function setSearchTerm($searchTerm)
    {
        $this->searchTerm = $searchTerm;
        return $this;
    }

    /**
     * @return string
     */
    public function getSearchTerm()
    {
        return $this->searchTerm;
    }

    /**
     * @param int $start
     * @return SearchCriteria
     */
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param SortColumn $sortColumn
     */
    public function addSortColumn(SortColumn $sortColumn)
    {
        $this->sortColumns[] = $sortColumn;
    }

    /**
     * @param \Core\DataTable\SortColumn[] $sortColumns
     * @return SearchCriteria
     */
    public function setSortColumns($sortColumns)
    {
        $this->sortColumns = $sortColumns;
        return $this;
    }

    /**
     * @return \Core\DataTable\SortColumn[]
     */
    public function getSortColumns()
    {
        return $this->sortColumns;
    }

}