<?php

namespace Dpn\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Dpn\CmsBundle\Manager\SiteManager;

class PageController
{
    /**
     * @var \Dpn\CmsBundle\Manager\SiteManager
     */
    protected $siteManager;

    /**
     * @var string
     */
    protected $pagesDir;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    protected $templating;

    /**
     * @param \Dpn\CmsBundle\Manager\SiteManager $siteManager
     * @param string $pagesDir
     * @param \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating
     */
    public function __construct(SiteManager $siteManager, $pagesDir, EngineInterface $templating)
    {
        $this->siteManager = $siteManager;
        $this->pagesDir    = $pagesDir;
        $this->templating  = $templating;
    }

    /**
     * @param string $path
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction($path)
    {
        $pages = $this->siteManager->load($this->pagesDir);

        $page = $this->siteManager->find($path, $pages);

        if (false === $page) {
            throw new NotFoundHttpException();
        }

        $response = new Response();

        if ($page->getMaxAge()) {
            $response->setPublic();
            $response->setSharedMaxAge($page->getMaxAge());
        }

        $template = false === $page->getTemplate() ?
            'DpnCmsBundle::default.html.twig' : $page->getTemplate();

        $html = $this->templating->render($template, array('page' => $page));

        $response->setContent($html);

        return $response;
    }
}