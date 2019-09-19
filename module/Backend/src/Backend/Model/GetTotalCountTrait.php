<?php

namespace Backend\Model;

trait GetTotalCountTrait
{
    public function getTotalCount($search = NULL)
    {
        $sql = "SELECT count(1) as totalcount FROM `{$this->_dbTable}` ";

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

        $statement = $this->_dbAdapter->createStatement($sql);
        $result = $statement->execute(); 
        return (int) $result->current()['totalcount'];
    }
}