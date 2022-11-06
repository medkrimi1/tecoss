<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ParametersController extends AbstractController
{
    /**
     * @Route("/dashboard/parameters/profile", name="dashboard_parameters_profile")
     */
    public function index(){
        return $this->render('dashboard/parameters/profile.html.twig');
    }
}