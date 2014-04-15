<?php
namespace Imp\AppBundle\Menu;

use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root', array(
            'navbar' => true,
        ));
        $menu->addChild('Home', array('route' => 'imp_app_home'));
//        $menu->addChild('About me', array('route' => 'gh_blog_about'));
//        $menu->addChild('Guestbook', array('route' => 'gh_guestbook_message'));
        return $menu;
    }
}