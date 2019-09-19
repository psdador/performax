<?php

namespace Backend\Model;
use Zend\Validator;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;

class Users
{

    use GetListTrait;
    use GetTotalCountTrait;
    private $_dbAdapter;
    private $_dbTable = 'users';
    private $_columnId = 'user_id';
    private $_searchableColumns = [ 'fullname', 'username'];
    private $_columnList  = [ 'user_id' => 'int',
                              'username' => 'string',
                              'fullname' => 'string',
                              'nickname' => 'string',
                              // 'email' => 'string',
                              'position' => 'string',
                              'contact' => 'string',
                              'locked' => 'bool',
                              ];

    public function setDbAdapter($dbAdapter)
    {
        $this->_dbAdapter = $dbAdapter;
    }

    public function getColumnId()
    {
      return $this->_columnId;
    }
    public function changePassword($username, $password, $staticSalt)
    {
        $updateStatement = "UPDATE `{$this->_dbTable}`
                            SET `password` = MD5(CONCAT('$staticSalt', ?))
                            WHERE `username`='$username';";

        $statement = $this->_dbAdapter->createStatement($updateStatement, array($password));
        return $statement->execute();
    }



}