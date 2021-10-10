<?php

namespace App\Service;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;

class EventManager
{
    private $em;
    private $eventReposirtory;

    public function __construct(EntityManagerInterface $em, EventRepository $eventRepository)
    {
        $this->em = $em;
        $this->eventRepository = $eventRepository;
    }

    public function find(int $id): ?Event
    {
        return $this->eventRepository->find($id);
    }

    public function getRepository(): EventRepository
    {
        return $this->eventRepository;
    }

    public function create(): Event
    {
        $event = new Event();
        return $event;
    }

    public function save(Event $event): Event
    {
        $this->em->persist($event);
        $this->em->flush();
        return $event;
    }

    public function reload(Event $event): Event
    {
        $this->em->refresh($event);
        return $event;
    }

    public function delete(Event $event)
    {
        $this->em->remove($event);
        $this->em->flush();
    }
}