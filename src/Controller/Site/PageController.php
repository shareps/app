<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Controller\Site;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/site/page", name="site_page")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/contact", name="_contact")
     * @Template("views/Site/Page/contact.html.twig")
     */
    public function contactAction(): array
    {
        return [
            'user' => $this->getUser(),
        ];
    }
}
