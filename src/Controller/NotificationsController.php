<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NotificationsController extends AbstractController
{
    /**
     * @Route("/dashboard/notifications", name="dashboard_notifications")
     */
    public function index(){
        return $this->render('dashboard/notifications/index.html.twig');
    }
}