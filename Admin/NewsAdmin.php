<?php

namespace App\WebBundle\Admin ;

abstract class NewsAdmin extends \App\AdminBundle\Compiler\Cache\AdminCache {
    
    protected function configureObjectMenu11(\Knp\Menu\MenuItem $menu, $with_parent = false ) {
        parent::configureObjectMenu($menu, $with_parent);
        
        if( !$with_parent && $this->object_id ) {
            
            $object = $this->getRouteObject() ;
            
            $route  = $this->container->get('router') ;
            $url    = $route->generate('news_item', array(
                'column'    => $object->news_type->page->slug ,
                'id'    => $object->getId() ,
            ));
            $options    = array(
                'uri'   => $url ,
                'linkAttributes' => array(
                    'target'    => '_blank' ,
                ) ,
            );
            $menu->addChild( $this->getLabel() . ': ' .  $this->string($object) , $options );
        }
    }
    
    
    
}
