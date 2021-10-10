<?php

namespace App\Service;

use App\Entity\Modality;
use App\Repository\ModalityRepository;
use Doctrine\ORM\EntityManagerInterface;

class ModalityManager
{
    private $em;
    private $modalityRepository;

    public function __construct(EntityManagerInterface $em, ModalityRepository $modalityRepository)
    {
        $this->em = $em;
        $this->modalityRepository = $modalityRepository;
    }

    public function find(int $id): ?Modality
    {
        return $this->modalityRepository->find($id);
    }

    public function getRepository(): ModalityRepository
    {
        return $this->modalityRepository;
    }

    public function create(): Modality
    {
        $modality = new Modality();
        return $modality;
    }

    public function persist(Modality $modality)
    {
        $this->em->persist($modality);
        return $modality;
    }

    public function save(Modality $modality): Modality
    {
        $this->em->persist($modality);
        $this->em->flush();
        return $modality;
    }

    public function reload(Modality $modality): Modality
    {
        $this->em->refresh($modality);
        return $modality;
    }
}