<?php

namespace App\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/dai")
 */
class LoanController extends BaseController {

    /**
     * @Route("/{slug}/{page_number}", name="loan_list", requirements={"slug":"\w+", "page_number":"\d+" } )
     * @Template()
     */
    public function indexAction(Request $request, $slug , $page_number = 1 ) {

        $fund   = $this->getUseOfFundsAdmin()->getRepository()->findOneBy( array('slug' => $slug ) ) ;

        if( !$fund ) {
            throw $this->createNotFoundException();
        }

        $admin  = $this->getLoanAdmin() ;
        $form   = $this->createSearchFrom($admin, $fund) ;

        $dispatcher = $this->container->get('event_dispatcher');

        $event = new \App\AdminBundle\Event\FormEvent($form, $request);
        $dispatcher->dispatch('app.event.form', $event) ;
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $em = $this->container->get('doctrine')->getManager() ;
        // a.status=" . $admin->getStatusValueByName('published') . "
        $dql = "SELECT a FROM AppWebBundle:Loan a WHERE a.use_of_fund=" . $fund->getId() ; // . " ORDER BY a.id DESC ";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, $page_number , 9
        );


        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {

            }
            \Dev::dump( $form->isValid() ) ; exit;
        }

        return array(
            'found' => $fund ,
            'form'  => $form->createView() ,
            'page' => $fund->page ,
            'pagination'   => $pagination ,
        ) ;
    }


    /**
     * @Route("/{slug}/apply", name="loan_apply", requirements={"slug":"\w+"} )
     * @Template()
     */
    public function applyAction(Request $request, $slug ) {

        $fund   = $this->getUseOfFundsAdmin()->getRepository()->findOneBy( array('slug' => $slug ) ) ;

        if( !$fund ) {
            throw $this->createNotFoundException();
        }

        $admin  = $this->getLoanAdmin() ;
        $form   = $this->createApplyFrom($admin, $fund) ;

        $dispatcher = $this->container->get('event_dispatcher');

        $event = new \App\AdminBundle\Event\FormEvent($form, $request);
        $dispatcher->dispatch('app.event.form', $event) ;
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {
                $object = $form->getData() ;
                \Dev::dump($object); exit;
            }
        }

        return array(
            'found' => $fund ,
            'form'  => $form->createView() ,
            'page' => $fund->page ,
        ) ;
    }



    /**
     * @Route("/{slug}/view/{id}", name="loan_view", requirements={"slug":"\w+", "id":"\d+" } )
     * @Template()
     */
    public function viewAction(Request $request, $slug ) {

        $fund   = $this->getUseOfFundsAdmin()->getRepository()->findOneBy( array('slug' => $slug ) ) ;

        if( !$fund ) {
            throw $this->createNotFoundException();
        }

        return array(
            'found' => $fund ,
            'page' => $fund->page ,
        ) ;
    }

    private function createSearchFrom(\AppAdminCache\Loan\AdminLoan $admin, \App\WebBundle\Entity\UseOfFund $fund){
        $domain    = $admin->getDomain() ;
        $app_domain    = $admin->getAppDomain() ;
        $tr     = $this->container->get('translator');

        $constraints   = array() ;

        if( !$this->container->getParameter('kernel.debug') ) {

        }

        $builder = $this->container->get('form.factory')->createNamedBuilder('form', 'form', null, array(
            'label'  => '搜索' . $fund->name ,
            'translation_domain' => $domain ,
        )) ;

        $admin->addFormElement($builder, 'money', array(
            'help_widget_popover' => array(
                'title' => '不足一万可用小数表示',
                // 'content' => '不足一万可用小数表示'
            ),
            'attr' => array(
                //'placeholder' => "10",
            )
        ));

        $admin->addFormElement($builder, 'loan_life', array(
            'help_widget_popover' => array(
                'title' => '必须是整数月份',
                // 'content' => '不足一万可用小数表示'
            ),
            'attr' => array(
                //'placeholder' => "10",
            )
        ));


        return $builder->getForm();
    }


    private function createApplyFrom(\AppAdminCache\Loan\AdminLoan $admin, \App\WebBundle\Entity\UseOfFund $fund){
        $domain    = $admin->getDomain() ;
        $app_domain    = $admin->getAppDomain() ;
        $tr     = $this->container->get('translator');

        $constraints   = array() ;

        if( !$this->container->getParameter('kernel.debug') ) {

        }

        $object = $admin->newObject() ;

        $builder = $this->container->get('form.factory')->createNamedBuilder('form', 'form', $object, array(
            'label'  => '申请' . $fund->name ,
            'translation_domain' => $domain ,
        )) ;

        $admin->addFormElement($builder, 'money', array(

        ));

        $admin->addFormElement($builder, 'loan_life', array(

        ));

        $admin->addFormElement($builder, 'has_mortgage', array(

        ));

        $admin->addFormElement($builder, 'mortgage_type', array(

        ));

        $admin->addFormElement($builder, 'mortgage_desc', array(

        ));

        $admin->addFormElement($builder, 'content', array(

        ));

        $admin->buildDynamicForm($builder, $object ) ;

        return $builder->getForm();
    }
}