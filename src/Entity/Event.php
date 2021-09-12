<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $beginDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $department;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $vocalia;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $dificulty;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $outstanding;

    /**
     * @ORM\ManyToMany(targetEntity=Modality::class, inversedBy="events")
     */
    private $modality;

    public function __construct()
    {
        $this->modality = new ArrayCollection();
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBeginDate(): ?\DateTimeInterface
    {
        return $this->beginDate;
    }

    public function setBeginDate(\DateTimeInterface $beginDate): self
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getVocalia(): ?string
    {
        return $this->vocalia;
    }

    public function setVocalia(string $vocalia): self
    {
        $this->vocalia = $vocalia;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDificulty(): ?int
    {
        return $this->dificulty;
    }

    public function setDificulty(int $dificulty): self
    {
        $this->dificulty = $dificulty;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
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

    public function getOutsatnding(): ?int
    {
        return $this->outstanding;
    }

    public function setOutsatnding(int $outsatnding): self
    {
        $this->outstanding = $outsatnding;

        return $this;
    }

    /**
     * @return Collection|Modality[]
     */
    public function getModality(): Collection
    {
        return $this->modality;
    }

    public function addModality(Modality $modality): self
    {
        if (!$this->modality->contains($modality)) {
            $this->modality[] = $modality;
        }

        return $this;
    }

    public function removeModality(Modality $modality): self
    {
        $this->modality->removeElement($modality);

        return $this;
    }
}
