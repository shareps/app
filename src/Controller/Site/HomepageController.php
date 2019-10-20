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

class HomepageController extends AbstractController
{
    /**
     * @Route("", name="homepage")
     * @Template("views/Site/Homepage/homepage.html.twig")
     */
    public function homepageAction(): array
    {
        return [
            'user' => $this->getUser(),
        ];
    }
}
