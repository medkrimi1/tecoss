<?php

namespace App\Entity;

use App\Repository\JobsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @ORM\Entity(repositoryClass=JobsRepository::class)
 *
 */
class Jobs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;
   

 

    /**
     * @ORM\ManyToOne(targetEntity=TypeJobs::class, inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeid;

 


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity=Experience::class, inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exp;

   

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $req;

   
    /**
    
     * @ORM\Column(name="CreatedAt", type="datetime")
     */
    private $CreatedAt;

   
    /**
     * @ORM\ManyToMany(targetEntity=Skills::class, inversedBy="jobs")
     */
    private $skills;

    /**
     * @ORM\OneToMany(targetEntity=Applications::class, mappedBy="job")
     */
    private $appdate;

    /**
     * @ORM\OneToMany(targetEntity=Applications::class, mappedBy="job")
     */
    private $applications;

   

  
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cover;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ExpiredAt;

 
   
   

    public function __construct()
    {
       
        $this->skills = new ArrayCollection();
        $this->appdate = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->setCreatedAt(new \Datetime());
        $this->setExpiredAt(new \Datetime());
        $this->setImage(uniqid());
        $this->setCover(uniqid());
        $this->startdate=new \Datetime();


      
        



    }

   


  
  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
   

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

  
    
    

  

    

    public function getTypeid(): ?TypeJobs
    {
        return $this->typeid;
    }

    public function setTypeid(?TypeJobs $typeid): self
    {
        $this->typeid = $typeid;

        return $this;
    }

   

   

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getExp(): ?Experience
    {
        return $this->exp;
    }

    public function setExp(?Experience $exp): self
    {
        $this->exp = $exp;

        return $this;
    }

   

   

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getResp(): ?string
    {
        return $this->resp;
    }

    public function setResp(string $resp): self
    {
        $this->resp = $resp;

        return $this;
    }

    public function getReq(): ?string
    {
        return $this->req;
    }

    public function setReq(string $req): self
    {
        $this->req = $req;

        return $this;
    }

  

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

   

    /**
     * @return Collection<int, Skills>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skills $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    public function removeSkill(Skills $skill): self
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    /**
     * @return Collection<int, Applications>
     */
    public function getAppdate(): Collection
    {
        return $this->appdate;
    }

    public function addAppdate(Applications $appdate): self
    {
        if (!$this->appdate->contains($appdate)) {
            $this->appdate[] = $appdate;
            $appdate->setJob($this);
        }

        return $this;
    }

    public function removeAppdate(Applications $appdate): self
    {
        if ($this->appdate->removeElement($appdate)) {
            // set the owning side to null (unless already changed)
            if ($appdate->getJob() === $this) {
                $appdate->setJob(null);
            }
        }

        return $this;
    }

   
 /**
     * @return Collection<int, Applications>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Applications $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setCandidate($this);
        }

        return $this;
    }

    public function removeApplication(Applications $application): self
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getCandidate() === $this) {
                $application->setCandidate(null);
            }
        }

        return $this;
    }

    
   


 


   public function __toString() 
         
         
             {
           return $this->title ;
         
             }



   

   public function getImage(): ?string
   {
       return $this->image;
   }

   public function setImage(string $image): self
   {
       $this->image = $image;

       return $this;
   }

   public function getCover(): ?string
   {
       return $this->cover;
   }

   public function setCover(string $cover): self
   {
       $this->cover = $cover;

       return $this;
   }

   public function getExpiredAt(): ?\DateTimeInterface
   {
       return $this->ExpiredAt;
   }

   public function setExpiredAt(\DateTimeInterface $ExpiredAt): self
   {
       $this->ExpiredAt = $ExpiredAt;

       return $this;
   }

  

  

 

  


   

   

  

   


  

  

   

  

  




}
