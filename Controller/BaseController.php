<?php

namespace Symforce\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


abstract class BaseController extends Controller {

    /**
     * @return
     */
    protected function getAdminLoader(){
        return $this->container->get('sf.admin.loader') ;
    }

    /**
     * @return \AppAdminCache\UseOfFunds\AdminUseOfFunds
     */
    protected function getUseOfFundsAdmin(){
        return $this->container->get('sf.admin.loader')->getAdminByName('use_of_funds') ;
    }

    /**
     * @return  \AppAdminCache\Loan\AdminLoan
     */
    protected function getLoanAdmin(){
        return $this->container->get('sf.admin.loader')->getAdminByName('loan') ;
    }
    /**
     * @return  \AppAdminCache\AppPage\AdminAppPage
     */
    protected function getPageAdmin(){
        return $this->container->get('sf.admin.loader')->getAdminByName('app_page') ;
    }

    /**
     * @param $slug
     * @return \Symforce\AdminBundle\Entity\Page
     */
    protected function getPageBySlug( $slug){
        return $this->getPageAdmin()->getRepository()->findOneBy( array('slug' => $slug ) ) ;
    }
}