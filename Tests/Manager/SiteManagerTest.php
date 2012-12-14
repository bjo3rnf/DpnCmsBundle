<?php

namespace Dpn\CmsBundle\Tests\Manager;

use Dpn\CmsBundle\Manager\SiteManager;

class SiteManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $fixturesDir;

    public function setUp()
    {
        $this->fixturesDir = realpath(__DIR__.'/../Fixtures/pages');
    }

    public function testFindPage()
    {
        $siteManager = new SiteManager();
        $pages = $siteManager->load($this->fixturesDir);

        $this->assertInstanceOf('Dpn\CmsBundle\Cms\Page', $siteManager->find('home', $pages));
        $this->assertInstanceOf('Dpn\CmsBundle\Cms\Page', $siteManager->find('about/foo/bar', $pages));
        $this->assertFalse($siteManager->find('not-existing', $pages));
    }

    public function testPageProperties()
    {
        $siteManager = new SiteManager($this->fixturesDir);
        $pages = $siteManager->load($this->fixturesDir);

        $page = $siteManager->find('home', $pages);

        $this->assertEquals('Home', $page->getTitle());
        $this->assertEquals(1, $page->getSort());
        $this->assertCount(0, $page->getFiles());
        $this->assertCount(1, $page->getImages());
        $this->assertCount(0, $page->getChildren());

        $page = $siteManager->find('about', $pages);
        $this->assertEquals('About', $page->getTitle());
        $this->assertEquals(2, $page->getSort());
        $this->assertCount(0, $page->getFiles());
        $this->assertCount(0, $page->getImages());
        $this->assertCount(1, $page->getChildren());
    }
}