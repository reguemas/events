<?php

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EventRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Event;

class EventsController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="event/events")
     * @Rest\View(serializerGroups={"event"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(
        EventRepository $eventRepository
    ) {
        return $eventRepository->findAll();
    }

    /**
     * @Rest\Post(path="event/addEvent")
     * @Rest\View(serializerGroups={"event"}, serializerEnableMaxDepthChecks=true)
     */
    public function postActions(
        EntityManagerInterface $em
    ) {
        $event = new Event();
        $event->setTitle('Diada de Germanor');
        $event->setType(1);
        $event->setBeginDate(new \DateTime('@'.strtotime('2021-09-15 08:00:00')));
        $event->setEndDate(new \DateTime('@'.strtotime('2021-09-15 08:00:00')));
        $event->setDepartment('CET');
        $event->setVocalia('CET');
        $event->setModality('Trobada');
        $event->setDescription('Els que estimem la nostra entitat, ens trobarem a Sant Llorenç del Munt, amb les persones amb qui compartim la passió per la muntanya.');
        $event->setDificulty(0);
        $event->setUrl('http:\/\/ce-terrassa.cat\/diada-de-germanor-del-centre-excursionista-de-terrassa-2019\/');
        $event->setImage('http:\/\/ce-terrassa.cat\/wp-content\/uploads\/2019\/08\/Diada-150x150.jpg');
        $event->setOutsatnding(1);
        $em->persist($event);
        $em->flush();
        return $event;
    }
}