<?php

namespace App\Controller;
use App\Entity\TypeJobs;
use App\Repository\TypeJobsRepository;
use App\Form\ContratType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class TypesController extends AbstractController
{



   private $manager;
    public function __construct(TypeJobsRepository $TypeJobsRepository ,EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->TypeJobsRepository=$TypeJobsRepository;
    }

    /**
     * @Route("/dashboard/types", name="dashboard_Types")
     */
    public function index(){
        $typejob = $this->manager->getRepository(TypeJobs::class)->findAll();
      
        foreach ($typejob as $typejob){
            $typejobsArray[] = [
            
                'title' => $typejob->getTitle(),
               
                
            
                


            ];
        }

        return $this->render('dashboard/types/index.html.twig', [
            'typejobs' => $typejobsArray,'countAllTypes' => $this->TypeJobsRepository->countAllTypes()
        ]);
    }



  /**
     * @Route("/dashboard/types/ajouter", name="add_types")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
         $em = $this->getDoctrine()->getManager();
        $data = new TypeJobs();
        $form = $this->createForm(ContratType::class, $data);
        $form->handleRequest($request);
   $types = $this->manager->getRepository(TypeJobs::class)->findAll();
            
        foreach ($types as $type){
            $typesArray[] = strtolower(str_replace(' ', '',$type->getTitle()));
            
        }

       
            if($form->isSubmitted() && $form->isValid()) {
                
                if(in_array(strtolower(str_replace(' ', '',$form->get('title')->getData())), $typesArray)){
                
               
                    $this->addFlash('error', 'Ce nom existe déja');
                }else{
                    $em->persist($data);
                $em->flush();
                    $this->addFlash('success', 'la compétence a été ajoutée avec succès!');
                }
                
                return $this->redirectToRoute('dashboard_Types');
                      
            }
        return $this->render('dashboard/types/ajouter.html.twig', [
            "form" => $form->createView()
        ]);
    }



   /**
     * @Route("dashboard/types/{title}/edit", name="type_edit")
     * @param TypeJobs $type
     * @param Request $request
     * @return Response
     */
    public function edit(TypeJobs $type, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data = new TypeJobs();
        $form = $this->createForm(ContratType::class, $type);
        $form->handleRequest($request);
         $check = $em->getRepository(TypeJobs::class)->findBy(["title" => $data->getTitle()]);
             
            if($check) {
                $this->addFlash('error', 'Ce nom existe déja');
                return $this->redirectToRoute('dashboard_Types');
            }
            else {
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
               $em->persist($data);
              $em->remove($type);
            $em->flush();
               if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Le type a été Modifié avec succès!');
        }

            return $this->redirectToRoute('dashboard_Types');
        }}
        return $this->render("dashboard/types/modifier.html.twig", [
            "form" => $form->createView()
        ]);
    }


     /**
     * @Route("dashboard/types/{title}/delete", name="type_delete")
     * @param TypeJobs $type
     * @return RedirectResponse
     */
    public function delete(TypeJobs $type): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($type);
        $em->flush();


        return $this->redirectToRoute("dashboard_Types");
    }



}