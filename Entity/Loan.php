<?php

namespace App\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\AdminBundle\Compiler\Annotation as Admin ;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_loan")
 * @Admin\Entity("loan", label="贷款申请", string="title", icon="rss", dashboard="right",
 * groups = {
 *      "default": "贷款信息" ,
 *      "trust": "利息信息" ,
 * } )
 * 
 * @Admin\Workflow("status", status = {
 *      "all": { "role":"ROLE_ADMIN" } ,
 *      "none": { "role":"ROLE_USER", "properties":"" } ,
 *      "removed":  { "source":"trash", "role":"ROLE_ADMIN" } ,
 * 
 *      "apply" : { "value":1, "source": "none", "label":"待接收" , "properties":" " , "duty":true } ,
 *      "accepted" : { "value":2, "source": "apply", "label":"已接受" , "properties":" " } ,
 *      "rejected" : { "value":3, "source": "apply", "label":"已拒绝" , "action":"拒绝", "btn":"danger", "properties":" " } ,
 *
 *      "process" : { "value":4, "source": "accepted", "label":"正在受理" , "properties":" " } ,
 *
 *      "finished" : { "value":20, "source": "process", "label":"已经完成" } ,
 *      "released" : { "value":24, "source": "finished", "label":"已封存"} ,
 * 
 *      "trash": { "value":31, "source":"rejected,released", "label":"垃圾箱", "action":"丢弃", "properties":" " } ,
 * }, properties="#$*, #id")
 * 
 */
class Loan
{
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
     */
    public $title ;
    
    /**
     * @ORM\ManyToOne(targetEntity="UseOfFund", inversedBy="loans", cascade={"detach"} )
     * @Admin\Table()
     * @Admin\Form(auth=true)
     */
    public $use_of_fund ;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Admin\Form(label="联系电话")
     */
    public $phone ;
    
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2 )
     * @Admin\Form(label="借贷金额", type="range", unit="万", min=1, max=1000, choices={
     *    1, 10, 100, 2, 20, 200, 3, 30, 300, 4, 40, 400, 5, 50, 500,
     *    6, 60, 60, 7, 70, 8, 80, 9, 90 }, precision=2)

     */
    public $money  ;
    /**
     * @ORM\Column(type="integer")
     * @Admin\Form(label="借款周期", type="range", unit="个月", icon="月", trans_unit={"12":"年"}, min=3, max=56, choices={ 3, 4, 6, 8, 12, 24, 36, 48, 56 })
     */
    public $loan_life = 12 ;

    /**
     * @ORM\Column(type="boolean")
     * @Admin\Form(label="是否有抵押")
     */
    public $has_mortgage = true ;
    
    /**
     * @ORM\ManyToOne(targetEntity="MortgageType", inversedBy="loans", cascade={"detach"} )
     * @Admin\Form( show_on={"has_mortgage":1})
     * @Admin\Table()
     */
    public $mortgage_type ;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Admin\Form( type="textarea", height=5, label="抵押物描述", show_on={"has_mortgage":1} )
     * @Admin\Table()
     */
    public $mortgage_desc ;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Admin\Form(type="textarea", label="贷款描述", required=true, min_length=20, show_on={"has_mortgage":0} )
     */
    public $content ;
    
    /**
     * @ORM\ManyToOne(targetEntity="\App\UserBundle\Entity\User", cascade={"persist"} )
     * @Admin\Owner
     * @Admin\Form()
     * @Admin\Table()
     *
     */
    public $user ;
    
    /**
     * @ORM\Column(type="integer")
     * @Admin\Form(label="状态", group="trust")
     */
    protected $status ;
    
    /**
     * @ORM\Column(type="integer")
     * @Admin\Table() 
     * @Admin\Form(label="付息方式", group="trust", type="choice", choices={
     *  "1":"按季付息", "2":"按半年付息", 3:"按年付息", 4:"到期付息", "31":"其他"
     * })
     */
    public $interest_type = 3 ;
    
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2 )
     * @Admin\Form(label="预期利率", group="trust", type="range", unit="%", min=5, max=999, choices={ 
     *      8, 9, 10, 11, 12, }, precision=2, group="trust")
     * @Admin\Table(order=true)
     */
    public $expected_revenue = 8;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Admin\Form(label="总利息金额", type="money", group="trust", currency="CNY" )
     */
    public $interest_money ;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Admin\Form(label="服务佣金", type="money", group="trust", currency="CNY" )
     */
    public $service_money ;
    
    /**
     * @ORM\Column(type="datetime")
     * @Admin\Form(type="datetime",  group="trust",  label="付息日期" )
     */
    public $interest_date ;


    /**
     * @ORM\OneToMany(targetEntity="Invest", mappedBy="loan", cascade={"detach"} )
     * @Admin\Table()
     */
    public $invests ;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created ;
    
    /**
     * @ORM\OneToMany(targetEntity="LoanComment", mappedBy="loan", cascade={"detach"} )
     * @Admin\Table()
     */ 
    public $comments ;
    
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
    
    public function __toString() {
        return $this->title ;
    }
}