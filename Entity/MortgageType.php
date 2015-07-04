<?php

namespace App\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\AdminBundle\Compiler\Annotation as Admin ;


/**
 * @ORM\Entity
 * @ORM\Table(name="app_mortgage_type")
 * @Admin\Entity("mortgage_type", label="抵押物类别", icon="rss", dashboard="right" )
 */
class MortgageType {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Admin\Table()
     */
    protected $id ;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Admin\Table()
     * @Admin\Form()
     * @Admin\ToString()
     */
    public $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Loan", mappedBy="mortgage_type", cascade={"detach"} )
     * @Admin\Table()
     */ 
    public $loans ;
    
    public function getId()
    {
        return $this->id ;
    }
    
    public function __toString() {
        return $this->name ;
    }
    
}
