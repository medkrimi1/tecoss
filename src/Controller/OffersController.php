<?php

namespace App\Controller;
use App\Data\SearchData;
use App\Entity\Jobs;
use App\Repository\JobsRepository;
use App\Form\SearchForm;
use App\Form\JobsAddType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OffersController extends AbstractController
{
     private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    /**
     * @Route("/dashboard/offres", name="dashboard_offers")
     */
     public function index(JobsRepository $repository , Request $request ){ 
        $data=new SearchData();
         $data->page = $request->query->getInt('page', 1);
        $form= $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request) ;
        $jobs = $repository->findSearch($data);
     
       
   foreach ($jobs as $job){
       $bb=$job->getCreatedAt()->format('Y-m-d');
        $expired=$job->getExpiredAt()->format('Y-m-d');
           $datexpire= $job->getExpiredAt();
           $ccc= $job->getCreatedAt();
           $title=$job->getTitle();
             $candidates=[];
            foreach($job->getApplications() as $candidate)
            {
             $candidates[]=[
             'id'=>$candidate->getId() ,
             'applicant'=>$candidate->getCandidate()->getfname(),
             

             ] ;

            }

            $jobsArray[] = [

                   'id' => $job->getId(),
                'title' => $job->getTitle(),
                'image' => $job->getImage(),
                'cover' => $job->getCover(),
                'country' => $job->getCountry(),
                'city' => $job->getCity(),
                'beginAt'=>$job->getCreatedAt(),
                'expireAt' => $job->getExpiredAt(),
                'type' => $job->getTypeid()->getTitle(),
                'exp' => $job->getExp()->getTitle() ,
                'presentation' => $job->getPresentation(),
                'resp' => $job->getResp() ,
                'req' => $job->getReq (),
                'today'=>strtotime(date('Y/m/d')),
               'applications'=>$job->getApplications(),
               'applicant'=> $candidates,
                'slug'=> str_replace(' ', '-',$title),
                'expire'=>strtotime($expired),
                 'time'=>strtotime($bb),
               

 
            ];
        }
     
         
         if(empty($jobsArray)){$jobsArray=[];}
      
   
        return $this->render('dashboard/offres/offers.html.twig', [
            'jobs' => $jobsArray  ,'form' => $form-> createView()
        ]);
    }
 
  

     /**
     * @Route("/dashboard/offres/Ajouter", name="dashboard_offers_add")
     * @param Request $request
     * @return Response
     * 
     */
    public function new( Request $request, EntityManagerInterface $em)
    {
        $jobs = new Jobs();
        $form = $this->createForm(JobsAddType::class, $jobs);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($jobs);
            $em->flush();
             if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedImage = $form['imagefield']->getData();
            $uploadedCover = $form['coverfield']->getData();

            $ImageName = $form['image']->getData();
            $CoverName = $form['cover']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/images/jobs';
            if ($uploadedImage) {
               
                $newImageName = $ImageName;
                $uploadedImage->move($destination,$newImageName);
               
               
               
            }
             if ($uploadedCover) {
               
              
                $newCoverName = $CoverName;
                $uploadedCover->move($destination,$newCoverName);
               
               
            }
        }
         
                    $this->addFlash('success', 'l\'offre d\'emploi a été ajoutée avec succès!');
            return $this->redirectToRoute('dashboard_offers');

        }
        return $this->render('dashboard/offres/Ajouter.html.twig', [
            "form" => $form->createView()
        ]);
    }



      /**
     * @Route("/dashboard/offres/modifier/{id}", name="offers_edit")
     * @param Request $request
     * @return Response
     */
    public function edit(Jobs $job, Request $request): Response
    {
        $jobs = new Jobs();
        $form = $this->createForm(JobsAddType::class, $job);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($job);
            $em->flush();
   if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['imagefield']->getData();
            $filename = $form['image']->getData();
           
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir').'/public/images/jobs';
               
                $newFilename = $filename;
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
               
               
            }
        }
            return $this->redirectToRoute('dashboard_offers');

        }
        return $this->render('dashboard/offres/modifier.html.twig', [
            "form" => $form->createView()
        ]);
    }


 /**
     * @Route("/dashboard/offres/supprimer{id}", name="offre_delete")
     * @param Jobs $jobs
     * @return RedirectResponse
     */
    public function delete(Jobs $jobs): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($jobs);
        $em->flush();

        return $this->redirectToRoute("dashboard_offers");
    }


     /**
     * @Route("dashboard/offres/{id}", name="postulants")
    *
     */
     public function details(Jobs $job): Response
    {
   
     
        return $this->render('dashboard/offres/postulants.html.twig', compact('job'));
    }



}
