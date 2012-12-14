<?php

namespace Dpn\CmsBundle\Cms;

use Knp\Menu\NodeInterface;
use Doctrine\Common\Collections\ArrayCollection;

class Page implements NodeInterface
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var Page
     */
    protected $parent;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $children;

    /**
     * @var \DateTime
     */
    protected $modified;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $files;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $images;

    /**
     * @var int
     */
    protected $sort = 0;

    /**
     * @var bool
     */
    protected $visible = false;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @param array $properties
     */
    public function __construct(array $properties = array())
    {
        $this->setProperties($properties);
        $this->children = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    /**
     * @param string $path
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->path;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $children
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function setChildren(ArrayCollection $children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @param \Dpn\CmsBundle\Cms\Page $page
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function addChild(Page $page)
    {
        $this->children->add($page);

        return $this;
    }

    /**
     * @param \Dpn\CmsBundle\Cms\Page $page
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function removeChild(Page $page)
    {
        $this->children->removeElement($page);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $files
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function setFiles(ArrayCollection $files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @param string $file
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function addFile($file)
    {
        $this->files->add($file);

        return $this;
    }

    /**
     * @param string $file
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function removeFile($file)
    {
        $this->files->removeElement($file);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $images
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function setImages(ArrayCollection $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @param string $image
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function addImage($image)
    {
        $this->images->add($image);

        return $this;
    }

    /**
     * @param string $image
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function removeImage($image)
    {
        $this->images->removeElement($image);

        return $this;
    }
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param \DateTime $modified
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function setModified(\DateTime $modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param \Dpn\CmsBundle\Cms\Page $parent
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function setParent(Page $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param int $sort
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function setSort($sort)
    {
        $this->sort = (int) $sort;

        return $this;
    }

    /**
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param bool $visible
     * @return Page
     */
    public function setVisible($visible)
    {
        $this->visible = (bool) $visible;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @param array $properties
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return bool|string
     */
    public function getTemplate()
    {
        if (!array_key_exists('template', $this->properties)) {
            return false;
        }

        return $this->properties['template'];
    }

    /**
     * @return bool|int
     */
    public function getMaxAge()
    {
        if (!array_key_exists('max_age', $this->properties)) {
            return false;
        }

        return $this->properties['max_age'];
    }

    /**
     * @param string $property
     * @param mixed $value
     * @return \Dpn\CmsBundle\Cms\Page
     */
    public function __set($property, $value)
    {
        $this->properties[$property] = $value;

        return $this;
    }

    /**
     * @param string $property
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function __get($property)
    {
        if (!array_key_exists($property, $this->properties)) {
            throw new \InvalidArgumentException(sprintf("The property '%s' does not exist.", $property));
        }

        return $this->properties[$property];
    }

    /**
     * @param string $property
     * @return bool
     */
    public function __isset($property)
    {
        return array_key_exists($property, $this->properties);
    }

    /**
     * @param string $method
     * @param array $args
     * @return \Dpn\CmsBundle\Cms\Page
     * @throws \InvalidArgumentException
     */
    public function __call($method, $args)
    {
        if (substr($method, 0, 3) == 'get') {
            $property = strtolower(substr($method, 3));

            if (!array_key_exists($property, $this->properties)) {
                throw new \InvalidArgumentException(sprintf("The property '%s' does not exist.", $property));
            }

            return $this->properties[$property];
        }

        if (substr($method, 0, 2) == 'is') {
            $property = strtolower(substr($method, 2));

            if (!array_key_exists($property, $this->properties)) {
                throw new \InvalidArgumentException(sprintf("The property '%s' does not exist.", $property));
            }

            return $this->properties[$property];
        }

        if (substr($method, 0, 3) == 'set') {
            $property = strtolower(substr($method, 3));
            $this->properties[$property] = reset($args);

            return $this;
        }
    }

    /**
     * @param string $direction
     * @param int $method
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function sortChildren($direction = 'asc', $method = SORT_REGULAR)
    {
        $helper    = array();
        $children  = array();
        $direction = strtolower($direction) == 'asc' ? SORT_ASC : SORT_DESC;

        /** @var $child \Dpn\CmsBundle\Cms\Page */
        foreach ($this->children as $idx => $child)
        {
            if ($child->isVisible()) {
                $helper[$idx]  = $child->getSort();
                $children[$idx] = $child;
            }
        }

        array_multisort($helper, $direction, $method, $children);

        $sorted = new ArrayCollection($children);

        return $sorted;
    }

    /**
     * Get the options for the factory to create the item for this node
     *
     * @return array
     */
    public function getOptions()
    {
        return array(
            'label' => $this->getTitle(),
            'route' => 'dpn_cms_page',
            'routeParameters' => array('path' => $this->getPath()),
            'display' => $this->isVisible(),
        );
    }

}