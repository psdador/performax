<?php
namespace Backend\Controller;
use Zend\Http\Request;
use Zend\View\Model\ViewModel;
use Backend\Model;

trait ListActionTrait
{
    public function listAction()
    {

        $class = new \ReflectionClass(__CLASS__);
        $parentClassName = str_replace('Controller', '', $class->getShortName());

        unset($class);
        $this->layout()->pageTitle = 'List ' . $parentClassName;
        $this->layout()->pageDesc = 'Search and find ' . $parentClassName;

        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        // $_GET data to be passed on view to generate sort and paginate links
        $request = $this->getRequest();
        $getData = $request->getQuery()->toArray();

        // instantiate Data Model
        $className = 'Backend\Model\\'.$this->_model;
        $dataModel = new $className();
        $dataModel->setDbAdapter($dbAdapter);

        // page default parameters
        $currentPage = 0;
        $search = NULL;
        $sortBy = 1;
        $orderby = 1;

        // change per page if there is a parameter $_GET['page']
        if(!empty($getData['page']) && $getData['page'] > 1){
            $currentPage = $getData['page'];
        }

        // check $_GET['q'] for search
        if(!empty($getData['q'])){
            $search = $getData['q'];
        }

        // check $_GET['order'] for ordering 
        $orderby = 'DESC';
        if(!empty($getData['order']) && $getData['order'] == 'ASC')
            $orderby = 'ASC';

        // check $_GET['order'] for ordering 
        if(!empty($getData['sort'])){
            $sortBy = $getData['sort'];
        }


        // get all Users
        $offset = $currentPage * $this->_resultsPerPage;

        $data = $dataModel->getlist($search, $offset, $sortBy, $orderby);
        $dataCount = $dataModel->getTotalCount($search);
        $columnList = $dataModel->getColumnlist();
        $columnId = $dataModel->getColumnId();

        // computation of pagination links
        $pagination = $this->_determinePagination($dataCount, $this->_resultsPerPage, $currentPage, $this->_pageNumLinks);


        return new ViewModel(['data' => $data,
                              'pagination' => $pagination,
                              'getParam' => $getData,
                              'columnList' => $columnList,
                              'columnId' => $columnId,
                              'totalCount' => $dataCount,
                              ]);

    }
}