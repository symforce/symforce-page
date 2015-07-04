<?php

namespace Symforce\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symforce\AdminBundle\Compiler\Annotation as Admin ;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_blog_type")
 * @Admin\Entity("news_type", label="新闻分类", icon="rss", menu="sys", position=4, dashboard=true, groups={
 *      "default": "默认",
 *      "seo":"SEO"
 * } )
 * 
 * @Admin\Action("list")
 * 
 */
class NewsType
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
    public $name ;
    
    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false )
     * @ORM\Column(length=255, unique=false)
     * @Admin\Table()
     * @Admin\Form()
     */
    public $slug ;
    
    /**
     * @ORM\Column(type="boolean")
     * @Admin\Form(label="允许会员发帖")
     */
    public $allow_user_thread = false ;
    
    /**
     * @ORM\Column(type="boolean")
     * @Admin\Form(label="允许会员评论")
     */
    public $allow_user_reply = false ;
    
    /** 
     * @ORM\OneToOne(targetEntity="Symforce\AdminBundle\Entity\Page", cascade={"remove", "persist" } )
     * @Admin\Page(label="新闻分类", path="blog", title="name" )
     * @Admin\Form("order_by")
     * @Admin\Form("meta_keywords")
     * @Admin\Form("meta_description")
     * @Admin\Form(type="embed", copy_properties={"name":"title"})
     * 
     */
    public $page ;
    
    /**
     * @ORM\OneToMany(targetEntity="News", mappedBy="news_type", cascade={"remove"} )
     * @Admin\Table(label="版块内容")
     */
    public $news ;
    
    /**
     * @ORM\OneToOne(targetEntity="News", cascade={"remove"} )
     * @Admin\Form(label="首页新闻", choice_code="getNewsChoice", empty_value=" ")
     * @Admin\Table
     */
    public $top ;
    
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
        return $this->name ;
    }
    
}