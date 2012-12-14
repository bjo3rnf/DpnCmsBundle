<?php

namespace Dpn\CmsBundle\Tests\Twig;

use Dpn\CmsBundle\Twig\MarkdownExtension;

class MarkdownExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testTransformToHtmlFilter()
    {
        $extension = new MarkdownExtension();

        $markdown = '# Headline';

        $html = $extension->markdownFilter($markdown);

        $this->assertRegExp('/^<h1>Headline<\/h1>$/', $html);
    }
}