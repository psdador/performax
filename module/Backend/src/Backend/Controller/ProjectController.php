<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Backend\Controller;

use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Backend\Model;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

class ProjectController extends AbstractActionController
{

    use ListActionTrait;
    use PaginatorTrait;
    private $_model = 'Projects';
    private $_pageNumLinks = 7;
    private $_resultsPerPage = 20;
    
    public function indexAction()
    {
        return new ViewModel();
    }

}
