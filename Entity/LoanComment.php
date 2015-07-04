<?php

namespace Symforce\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symforce\AdminBundle\Compiler\Annotation as Admin ;

/**
 * @ORM\Entity
 * @ORM\Table(name="sf_loan_comments")
 * @Admin\Entity("loan_comment", label="贷款评论", icon="rss" )
 * 
 */
class LoanComment {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Admin\Table()
     */
    protected $id ;
    
    /**
     * @ORM\ManyToOne(targetEntity="Loan", inversedBy="comments", cascade={"detach"} )
     * @Admin\Form()
     */
    public $loan ;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Symforce\UserBundle\Entity\User", cascade={"persist"} )
     * @Admin\Owner
     */
    public $user ;
    
    /**
     * @ORM\Column(type="boolean")
     * @Admin\Form(label="公开显示")
     * @Admin\Table
     */
    public $published = false ;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Admin\Form(type="textarea", label="评论内容", required=true, min_length=20 )
     */
    public $content ;
    
    
    
    public function __toString() {
        return $this->id ;
    }
    
}
