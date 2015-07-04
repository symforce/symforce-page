<?php

namespace Symforce\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/**
 * @Route()
 */
class WebController extends BaseController {
 
    /**
     * @Route("/", name="app_web_home")
     * @Template()
     */
    public function indexAction(Request $request) {

        $page   = $this->getPageBySlug( '-1' ) ;

        return array(
            'page'  => $page ,
        ) ;
    }

}
