<?php

namespace App\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\AdminBundle\Compiler\Annotation as Admin ;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_invest")
 * @Admin\Entity("invest", label="投资请求", icon="bars", dashboard="right", groups = {
 *      "trust": "信托信息" ,
 *      "project": "项目信息" ,
 *      "default": "投资信息" ,
 *      "pay": "付款信息" ,
 *      "audit": "审计" ,
 *      "bank": {"name":"银行信息", "show_on":{"status":"5,6"} } ,
 *      } )
 *
 * @Admin\Workflow("status", status = {
 *      "all": { "role":"ROLE_ADMIN" } ,
 *      "none": { "role":"ROLE_USER", "properties":"" } ,
 *      "removed":  { "source":"trash", "role":"ROLE_ADMIN" } ,
 * 
 *      "apply" : { "value":1, "source": "none", "label":"待接收" , "properties":" " , "duty":true } ,
 *      "accepted" : { "value":2, "source": "apply,none", "label":"已接受" , "properties":" " } ,
 *      "rejected" : { "value":3, "source": "apply", "label":"已拒绝" , "action":"拒绝", "btn":"danger", "properties":" " } ,
 * 
 *      "finished" : { "value":20, "source": "apply", "label":"已经完成" } ,
 *      "released" : { "value":24, "source": "finished", "label":"已结束"} ,
 * 
 *      "trash": { "value":31, "source":"rejected", "label":"垃圾箱", "action":"丢弃", "properties":" " } ,
 * }, properties="#$*, #id, &money, &content")
 */
class Invest
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Admin\Table(order=true)
     */
    protected $id ;

    /**
     * @ORM\ManyToOne(targetEntity="Loan", inversedBy="invests", cascade={"detach"} )
     * @Admin\Table()
     * @Admin\Form(auth=true)
     */
    public $loan ;

    /**
     * @ORM\Column(type="integer")
     * @Admin\Form(label="投资金额", type="money", currency="CNY", min=100000, max=10000000)
     * @Admin\Table(order=true)
     */
    public $money ;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Admin\Form(type="textarea", label="预约付款备注", required=false, min_length=10 )
     */
    public $content ;
    
    /**
     * @ORM\ManyToOne(targetEntity="\App\UserBundle\Entity\User", cascade={"persist"} )
     * @Admin\Owner
     * @Admin\Form(label="投资人", auth=true)
     * @Admin\Table()
     */
    public $user ;
    
    /**
     * @ORM\Column(type="integer")
     * @Admin\Form(label="状态", group="audit")
     */
    protected $status ;
    
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
    
    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function getStatus() {
        return $this->status ;
    }
    
    public function setStatus( $value ) {
         $this->status = $value ;
    }
    
    public function setUser(\App\UserBundle\Entity\User  $user) {
        $this->user = $user ;
    }
    
    /**
     * @return \App\UserBundle\Entity\User 
     */
    public function getUser() {
        return $this->user ;
    }
    
}