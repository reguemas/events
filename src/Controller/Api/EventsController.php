<?php

namespace App\Controller\Api;

use App\Repository\EventRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="event/events")
     * @Rest\View(serializerGroups={"event"}, serializerEnableMaxDepthChecks=true)
     */
    public function getActions(
        EventRepository $eventRepository
    ) {
        return $eventRepository->findAll();
    }
}