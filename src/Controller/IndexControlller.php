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
     * @Route("/offres", name="offres")
     */
    public function index(){
        $jobs = $this->manager->getRepository(Jobs::class)->findAll();
      
        foreach ($jobs as $job){
             $title=$job->getTitle();

              $skills=[];
            foreach($job->getSkills() as $skill)
            {
             $skills[]=[
             'id'=>$skill->getId() ,
             'title'=>$skill->getTitle()
             ] ;

            }
            $jobsArray[] = [
                'id' => $job->getId(),
                'title' => $job->getTitle(),
                'country' => $job->getCountry(),
                'image'=>$job->getImage(),
                'city' => $job->getCity(),
                'beginAt' => $job->getCreatedAt(),
                'expireAt' => $job->getExpiredAt(),
                'type' => $job->getTypeid()->getTitle(),
                'exp' => $job->getExp()->getTitle() ,
                'presentation' => $job->getPresentation(),
                'resp' => $job->getResp() ,
                'req' => $job->getReq (),
                'slug'=> strtolower(str_replace(' ', '-',$title))
                
                


                


            ];
        }
        

        return $this->render('offres/index.html.twig', [
            'jobs' => $jobsArray 
        ]);
    }

    /**
     * @Route("/offres/{slug}/{id}", name="offre_get")
     */
     public function details(Jobs $job): Response
    {

     
        return $this->render('offres/offre.html.twig', compact('job'));
    }
}