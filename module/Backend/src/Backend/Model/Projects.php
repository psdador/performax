<?php

namespace Backend\Model;
use Zend\Validator;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;

class Projects
{

    use GetListTrait;
    use GetTotalCountTrait;
    private $_dbAdapter;
    private $_dbTable = 'projects';
    private $_columnId = 'project_id';
    private $_searchableColumns = ['name'];
    private $_columnList  = [ 'project_id' => 'int',
                              'name' => 'string',
                              'active' => 'bool',
                              'date_created' => 'datetime',
                              ];
    public function setDbAdapter($dbAdapter)
    {
        $this->_dbAdapter = $dbAdapter;
    }


    public function getColumnId()
    {
      return $this->_columnId;
    }
}