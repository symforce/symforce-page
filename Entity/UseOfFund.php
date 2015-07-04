<?php

namespace Symforce\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symforce\AdminBundle\Compiler\Annotation as Admin ;


/**
 * @ORM\Entity
 * @ORM\Table(name="app_use_of_funds")
 * @Admin\Entity("use_of_funds", label="资金用途", icon="rss", dashboard="right" )
 */
class UseOfFund {
    
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
     * @Gedmo\Slug(fields={"name"}, updatable=false )
     * @ORM\Column(length=255, unique=false)
     * @Admin\Table()
     * @Admin\Form()
     */
    public $slug ;

    /**
     * @ORM\OneToOne(targetEntity="Symforce\AdminBundle\Entity\Page", cascade={"remove", "persist" } )
     * @Admin\Page(label="资金用途", path="fund", title="name" )
     * @Admin\Form("image")
     * @Admin\Form("order_by")
     * @Admin\Form("meta_keywords")
     * @Admin\Form("meta_description")
     * @Admin\Form(type="embed", copy_properties={"name":"title"})
     *
     */
    public $page ;

    /**
     * @ORM\OneToMany(targetEntity="Loan", mappedBy="use_of_fund", cascade={"detach"} )
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
