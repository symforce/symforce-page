<?php

namespace App\WebBundle\Admin ;

abstract class NewsTypeAdmin extends \App\AdminBundle\Compiler\Cache\AdminCache {
 
    protected function configureObjectMenu11(\Knp\Menu\MenuItem $menu, $with_parent = false ) {
        parent::configureObjectMenu($menu, $with_parent) ;
        
        if( !$with_parent || !$this->route_parent ) {
            if( $this->object_id  ) {
                $object = $this->getRouteObject() ;

                $route  = $this->container->get('router') ;
                $url    = $route->generate('news_column', array(
                    'column'    => $object->page->slug ,
                ));
                $options    = array(
                    'uri'   => $url ,
                    'linkAttributes' => array(
                        'target'    => '_blank' ,
                    ) ,
                );
                $menu->addChild( $this->getLabel() . ': ' . $this->string($object) , $options );
            }
        }
    }
    
    public function getNewsChoice($object) {
        $id     = $this->getId( $object ) ;
        if( ! $id ) {
            return array() ;
        }
        $dql   = sprintf("SELECT a FROM AppWebBundle:news a WHERE a.news_type=%s ORDER BY a.always_top DESC, a.created DESC", $id );
        $em = $this->getManager() ;
        $query = $em->createQuery($dql);
        $query->setMaxResults( 99 ) ;
        $list = $query->getResult() ;
        $options    = array(
        );
        foreach($list as $news) {
            $options[ $news->getId() ] = $news->__toString() ;
        }
        return  $options ;
    }
    
    public function getNewsList( $tag , $limit = 9 ) {
        $repo = $this->getRepository();
        $news_type   = $repo->findOneBy( array(
            'slug'  => $tag ,
        ));
        $news_type_id   = 0 ;
        $top_id  = 0 ;
        if( $news_type ) {
            $news_type_id   = $this->getId( $news_type ) ;
            if( $news_type->top ) {
                $top_id  = $news_type->top->getId() ;
            }
        }
        if( $news_type_id ) {
            $dql   = sprintf("SELECT a FROM AppWebBundle:news a WHERE a.news_type=%s AND a.id!=%d ORDER BY a.always_top DESC, a.created DESC", $news_type_id, $top_id  );
        } else {
            $dql   = sprintf("SELECT a FROM AppWebBundle:news a WHERE a.id!=%d ORDER BY a.always_top DESC, a.created DESC", $top_id );
        }
        $em = $this->getManager() ;
        $query = $em->createQuery($dql);
        $query->setMaxResults( $limit ) ;
        $list = $query->getResult() ;
        if( $top_id ) {
            array_unshift($list, $news_type->top);
        }
        if( !$news_type ) {
             $news_type = new \App\WebBundle\Entity\NewsType();
             $news_type->name  = $tag ;
             $this->getReflectionProperty('id')->setValue($news_type, $tag );
        } else if( !($news_type instanceof $this->class_name) ) {
            throw new \Exception(sprintf("expect class `%s`, get `%s`", $this->class_name, \Dev::type($news_type) ));
        }
        return array($news_type, $list) ;
    }
    
}
