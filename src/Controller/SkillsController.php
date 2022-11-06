<?php

namespace App\Controller;
use App\Entity\Jobs;
use App\Entity\Skills;
use App\Form\SkillsType;
use App\Repository\SkillsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SkillsController extends AbstractController
{
     private $manager;
    public function __construct(SkillsRepository $SkillsRepository, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->SkillsRepository = $SkillsRepository;
    }

    /**
     * 
     * @Route("/dashboard/skills", name="dashboard_skills")
     */
    public function index(){
        $skills = $this->manager->getRepository(Skills::class)->findAll();
  
        foreach ($skills as $skill){
            $skillsArray[] = [
            
                'title' => $skill->getTitle()
              
                
                


                


            ];
        }

   
        return $this->render('dashboard/skills/index.html.twig', [
            'skills' => $skillsArray ,'countAllSkills' => $this->SkillsRepository->countAllSkills()
        ]);
    }


    /**
     * @Route("dashboard/skills/{title}/edit", name="skills_edit")
     * @param Skills $skills
     * @param Request $request
     * @return Response
     */
    public function edit(Skills $skills, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data= new Skills();
        $form = $this->createForm(SkillsType::class, $skills);
        $form->handleRequest($request);
          $skills = $this->manager->getRepository(Skills::class)->findAll();
            
        foreach ($skills as $skill){
            $skillsArray[] = str_replace(' ', '',$skill->getTitle());
            
        }

       
            if($form->isSubmitted() && $form->isValid()) {
                
                if(in_array(str_replace(' ', '',$form->get('title')->getData()), $skillsArray)){
                
          
                    $this->addFlash('error', 'Ce nom existe déja');

                }else{
                
                $em->flush();
                    $this->addFlash('success', 'la compétence a été ajoutée avec succès!');
                }
                
                return $this->redirectToRoute('dashboard_skills');
                      
            }
    
        return $this->render("dashboard/skills/modifier.html.twig", [
            "form" => $form->createView()
        ]);
    }


      /**
     * @Route("/dashboard/skills/ajouter", name="add_skills")
     * @param Request $request

     * @return Response
     */
    public function new( Request $request ): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data= new Skills();
        $form= $this->createForm(SkillsType::class ,$data);
       
        $form->handleRequest($request);
        $skills = $this->manager->getRepository(Skills::class)->findAll();
            
        foreach ($skills as $skill){
            $skillsArray[] = strtolower(str_replace(' ', '',$skill->getTitle()));
            
        }

       
            if($form->isSubmitted() && $form->isValid()) {
                
                if(in_array(strtolower(str_replace(' ', '',$form->get('title')->getData())), $skillsArray)){
                
               
                    $this->addFlash('error', 'Ce nom existe déja');
                }else{
                    $em->persist($data);
                $em->flush();
                    $this->addFlash('success', 'la compétence a été ajoutée avec succès!');
                }
                
                return $this->redirectToRoute('dashboard_skills');
                      
            }

            

    
        return $this->render('dashboard/skills/ajouter.html.twig', [
            "form" => $form->createView()
        ]);
    }


   /**
     * @Route("dashboard/skills/{title}/delete", name="skills_delete")
     * @param Skills $skill
     * @return RedirectResponse
     */
    public function delete(Skills $skill): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($skill);
        $em->flush();


        return $this->redirectToRoute("dashboard_skills");
    }









}