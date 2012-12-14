<?php

namespace Dpn\CmsBundle\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use Dpn\CmsBundle\Cms\Page;

class SiteManager
{
    /**
     * @var ArrayCollection
     */
    protected $pages;

    /**
     * @param string $pagesDir
     * @throws \InvalidArgumentException
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function load($pagesDir)
    {
        $pagesDir = realpath($pagesDir);

        if (false === $pagesDir) {
            throw new \InvalidArgumentException("The provided pages directory does not exist.");
        }

        if (null === $this->pages) {
            $this->pages = $this->inspectDirectory($pagesDir);
        }

        return $this->pages;
    }

    /**
     * @param string $path
     * @param \Doctrine\Common\Collections\ArrayCollection $pages
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function find($path, ArrayCollection $pages)
    {
        if ($path === 'ROOT') {
            $root = new Page();
            $root
                ->setTitle('ROOT')
                ->setPath('/')
                ->setChildren($pages)
            ;

            return $root;
        }

        $pages = new ArrayCollection($this->flattenCollection($pages));

        $result = $pages
            ->filter(function($page) use ($path) {
                return $page->getPath() == $path;
            })
            ->current()
        ;

        return $result;
    }

    /**
     * @param string $dir
     * @param \Dpn\CmsBundle\Cms\Page $parent
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    private function inspectDirectory($dir, Page $parent = null)
    {
        $pages = new ArrayCollection();

        $dirs = new Finder();
        $dirs
            ->ignoreDotFiles(true)
            ->depth('== 0')
            ->in($dir)
            ->directories()
        ;

        foreach ($dirs as $directory)
        {
            $page = new Page();

            $modified = new \DateTime();
            $modified->setTimestamp($directory->getMTime());
            $nameRaw  = $directory->getFilename();
            $nameNorm = $nameRaw;
            $sort     = 0;
            $visible  = false;

            if (preg_match('/^(\d+)\-(.+)$/', $nameRaw, $match)) {
                $nameNorm = $match[2];
                $sort     = $match[1];
                $visible  = true;
            }

            $path = null !== $parent ? $parent->getPath().'/'.$nameNorm : $nameNorm;

            $page
                ->setModified($modified)
                ->setSort($sort)
                ->setVisible($visible)
                ->setPath($path)
                ->setParent($parent)
            ;

            $children = $this->inspectDirectory($directory->getRealPath(), $page);
            $page->setChildren($children);

            $files = new Finder();
            $files
                ->depth('== 0')
                ->in($directory->getRealPath())
                ->files()
            ;

            foreach ($files as $file)
            {
                /** @var $file \SPLFileInfo */
                if ('yml' == $file->getExtension()) {
                    $properties = Yaml::parse($file->getRealPath());
                    $page->setProperties($properties);
                } else {
                    if (false !== @getimagesize($file->getRealPath())) {
                        $page->addImage($file->getRealPath());
                    } else {
                        $page->addFile($file->getRealPath());
                    }
                }
            }

            $pages->add($page);
        }

        return $pages;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $collection
     * @param array $flattened
     * @return array
     */
    private function flattenCollection(ArrayCollection $collection, array $flattened = array())
    {
        foreach ($collection as $item)
        {
            $flattened[] = $item;

            if ($item->getChildren()) {
                $flattened += $this->flattenCollection($item->getChildren(), $flattened);
            }
        }

        return $flattened;
    }

}