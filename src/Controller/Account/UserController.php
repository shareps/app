<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Controller\Account;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/account/user", name="account_user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/me", name="_me")
     * @Template("views/Account/User/me.html.twig")
     */
    public function meAction(): array
    {
        return [
            'user' => $this->getUser(),
        ];
    }
}
