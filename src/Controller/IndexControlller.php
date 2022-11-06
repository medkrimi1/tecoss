<?php

namespace App\Controller;

use App\Entity\Jobs;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\JobsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Gedmo\Mapping\Annotation as Gedmo; 

class IndexControlller extends AbstractController
{
    private $manager;
    public function __construct(JobsRepository $JobsRepository, EntityManagerInterface $manager)
    {

        $this->manager = $manager;
        $this->JobsRepository = $JobsRepository;
    }

    /**
     * @Route("/", name="offres")
     */
    public function index(){
       
        

        return $this->render('offres/index.html.twig');
    }

  
}