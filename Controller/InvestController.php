<?php

namespace App\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/invests")
 */
class InvestController extends BaseController {

    /**
     * @Route("/", name="invest_list")
     * @Template()
     */
    public function indexAction(Request $request) {

        return array() ;
    }
}