<?php

namespace Backend\Model;

trait GetListTrait
{

    public function getColumnlist()
    {
        return $this->_columnList;
    }
    public function getlist($search = NULL, $offset = 0, $sortBy = NULL, $orderby = 'DESC')
    {

        // generate column string from list columns
        $columnList = array_keys($this->_columnList);
        $columns = implode(",", $columnList);

        $sql = "SELECT {$columns} FROM `{$this->_dbTable}`";

        // get all searchable fields and generate where statement
        // be sure to add 'OR' if there are multiple searchable columns
        // output should be WHERE <COLUMN> = '%SEARCH STRING%' OR <COLUMN2> = '%SEARCH%'
        if(!empty($search)){
            $tmp = " WHERE ";
            $firstLoop = true;
            foreach ($this->_searchableColumns as $column){
                if(!$firstLoop){
                    // only add OR on second loop
                    // means multiple searchable columns are declared
                    $tmp .= " OR ";
                }
                $tmp .= " {$column} LIKE '%{$search}%' ";
                $firstLoop = false;
            }
            $sql .= $tmp;
        }

        if(!empty($sortBy)){
            $sql .= " ORDER BY {$sortBy} {$orderby} "; 
        }
        $sql .= " LIMIT {$offset}, 20;";

        // prepare statement
        $statement = $this->_dbAdapter->createStatement($sql);

        // var_dump($sql);exit;
        return $statement->execute();
    }
}