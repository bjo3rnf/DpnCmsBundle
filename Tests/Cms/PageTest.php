<?php

namespace Dpn\CmsBundle\Tests\Cms;

use Dpn\CmsBundle\Cms\Page;

class PageTest extends \PHPUnit_Framework_TestCase
{
    public function testGettersSetters()
    {
        $properties = array(
            'title' => 'Home',
            'foo' => 'Bar',
        );

        $page = new Page($properties);

        $this->assertEquals('Home', $page->title);
        $this->assertEquals('Home', $page->getTitle());

        $this->assertEquals('Bar', $page->foo);
        $this->assertEquals('Bar', $page->getFoo());

        $this->setExpectedException('InvalidArgumentException');
        $fail = $page->getBaz();

        $this->setExpectedException('InvalidArgumentException');
        $fail = $page->baz;
    }

    public function testSortChildren()
    {
        $page = new Page();

        $firstChild = new Page();
        $firstChild
            ->setSort(3)
            ->setVisible(true)
        ;

        $page->addChild($firstChild);

        $secondChild = new Page();
        $secondChild
            ->setSort(2)
            ->setVisible(true)
        ;

        $page->addChild($secondChild);

        $thirdChild = new Page();
        $thirdChild
            ->setSort(1)
            ->setVisible(true)
        ;

        $page->addChild($thirdChild);

        // Add a non-visible child
        $fourthChild = new Page();

        $page->addChild($fourthChild);

        $sorted = $page->sortChildren('asc');

        $this->assertNotEquals($page->getChildren(), $sorted);

        $this->assertEquals(1, $sorted->get(0)->getSort());
        $this->assertEquals(2, $sorted->get(1)->getSort());
        $this->assertEquals(3, $sorted->get(2)->getSort());

        $sorted = $page->sortChildren('desc');

        $this->assertEquals(3, $sorted->get(0)->getSort());
        $this->assertEquals(2, $sorted->get(1)->getSort());
        $this->assertEquals(1, $sorted->get(2)->getSort());
    }
}