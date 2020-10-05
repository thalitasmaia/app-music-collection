<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    public function hasPermission()
    {
        if ($this->getUser())
            return true;
        else
            return false;
    }

    public function isAdministrator()
    {
        $user = $this->getUser();
        if ($user->getAdmin())
            return true;
        else
            return false;
    }
}
