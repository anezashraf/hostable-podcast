<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{

    /**
     * @Route("/dashboard", name="dashboard")
     * @Route("/dashboard/{all}", name="dashboard_all" , requirements={"all"=".$"})
     */
    public function index()
    {
        return $this->render(
            'dashboard/index.html.twig'
        );
    }
}
