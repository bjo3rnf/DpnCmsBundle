<?php

namespace Dpn\CmsBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\NodeInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Dpn\CmsBundle\Manager\SiteManager;

class CmsMenuProvider implements MenuProviderInterface
{
    /**
     * @var \Knp\Menu\FactoryInterface
     */
    protected $factory;

    /**
     * @var \Dpn\CmsBundle\Manager\SiteManager
     */
    protected $siteManager;

    /**
     * @var string
     */
    protected $pagesDir;

    /**
     * @param \Knp\Menu\FactoryInterface $factory
     * @param \Dpn\CmsBundle\Manager\SiteManager $siteManager
     * @param string $pagesDir
     */
    public function __construct(FactoryInterface $factory, SiteManager $siteManager, $pagesDir)
    {
        $this->factory     = $factory;
        $this->siteManager = $siteManager;
        $this->pagesDir    = $pagesDir;
    }

    /**
     * @param string $name
     * @param array $options
     * @return \Knp\Menu\ItemInterface
     * @throws \InvalidArgumentException
     */
    public function get($name, array $options = array())
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('The menu name may not be empty');
        }

        $pages = $this->siteManager->load($this->pagesDir);
        $menu  = $this->siteManager->find($name, $pages);

        if (false === $menu) {
            throw new \InvalidArgumentException(sprintf('The menu "%s" is not defined.', $name));
        }

        if (!$menu instanceof NodeInterface) {
            throw new \InvalidArgumentException(sprintf('The menu at "%s" is not a valid menu item', $name));
        }

        $menuItem = $this->factory->createFromNode($menu);

        return $menuItem;
    }

    /**
     * @param string $name
     * @param array $options
     * @return bool
     */
    public function has($name, array $options = array())
    {
        if ($name == 'ROOT') {
            return true;
        }

        $pages = $this->siteManager->load($this->pagesDir);
        $menu  = $this->siteManager->find($name, $pages);

        return $menu !== false;
    }
}