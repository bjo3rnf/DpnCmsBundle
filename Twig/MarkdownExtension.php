<?php

namespace Dpn\CmsBundle\Twig;

use dflydev\markdown\MarkdownParser;
use dflydev\markdown\MarkdownExtraParser;

class MarkdownExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            'markdown' => new \Twig_Filter_Method($this, 'markdownFilter', array('is_safe' => array('html'))),
        );
    }

    /**
     * @param string $text
     * @param bool $extra
     * @return string
     */
    public function markdownFilter($text, $extra = false)
    {
        $parser = $extra ? new MarkdownExtraParser() : new MarkdownParser();

        return $parser->transform($text);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'markdown';
    }
}