<?php

namespace Symforce\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symforce\AdminBundle\Compiler\Annotation as Admin ;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_blog")
 * @Admin\Entity("news", label="新闻", icon="rss")
 * 
 * @Admin\Action("list")
 * 
 */
class News
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
     * @Admin\Form()
     * @Admin\ToString()
     */
    public $title ;
    
    /**
     * @Gedmo\Slug(fields={"title"}, updatable=false )
     * @ORM\Column(length=255, unique=false)
     * @Admin\Table()
     * @Admin\Form()
     */
    public $slug ;
    
    /**
     * @ORM\ManyToOne(targetEntity="NewsType", inversedBy="news", cascade={"persist"} )  
     * @Admin\Page(path="thread")
     * @Admin\Table() 
     * @Admin\Form()
     */
    public $news_type ;
    
    /**
     * @ORM\Column(type="boolean")
     * @Admin\Form(label="置顶")
     * @Admin\Table()
     */
    public $always_top = false ;
    
    
    /** 
     * @ORM\OneToOne(targetEntity="Symforce\AdminBundle\Entity\File")
     * @Admin\Form(label="插图", type="image", max_size="1m", image_size="120x130", small_size="12x12" )
     */
    public $image ;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Admin\Form(type="html")
     */
    public $content ;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Symforce\UserBundle\Entity\User", cascade={"persist"} )
     * @Admin\Owner
     */
    public $user ;
    
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
    
    public function __toString() {
        return $this->title ;
    }
}