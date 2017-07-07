<?php
/**
 * Created by PhpStorm.
 * User: voronkov_vs
 * Date: 18.07.2016
 * Time: 16:19
 */

namespace ZIMkaRU\CoreBundle\EventListener;

use Sonata\AdminBundle\Event\ConfigureMenuEvent;

class MenuBuilderListener
{
    public function addMenuItems(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        $child = $menu->addChild('reports', array(
            'route' => 'zimkaru_core_homepage',
            'labelAttributes' => array('icon' => 'fa fa-bar-chart'),
        ));

        $child->setLabel('Перейти на главную');
    }
}