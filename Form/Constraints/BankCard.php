<?php

namespace Symforce\PageBundle\Form\Constraints ;

class BankCard extends \Symfony\Component\Validator\Constraint {
    public $message = 'This value is not a valid Bank ID Card.' ;
    public $bypass_code = null ;
}
