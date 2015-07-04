<?php

namespace App\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\AdminBundle\Compiler\Annotation as Admin ;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_faq")
 * @Admin\Entity("faq", label="FAQ", icon="faq" , dashboard="public")
 * 
 */
class FAQ
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Admin\Table(order=true)
     */
    protected $id ;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Admin\Table(order=true)
     * @Admin\Form(label="问题")
     * @Admin\ToString()
     */
    public $question ;
    
    /**
     * @Gedmo\Slug(fields={"question"}, updatable=false )
     * @ORM\Column(length=255, unique=false)
     * @Admin\Table()
     * @Admin\Form()
     */
    public $slug ;
    
    /**
     * @ORM\Column(type="integer")
     * @Admin\Form()
     * @Admin\Table()
     */
    public $order_by = 0 ;
    
    
    /**
     * @ORM\Column(type="boolean")
     * @Admin\Form(label="发布")
     * @Admin\Table()
     */
    public $published = 1 ;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Admin\Form(type="html", required=true, min_length=10, label="答案", valid_elements="a[href|target=_blank],strong/b,!p")
     */
    public $answer ;
    
    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    public function getId()
    {
        return $this->id ;
    }
    
    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
}