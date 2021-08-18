<?php

namespace App\Controller\Api;

use App\Entity\Event;
use App\Form\Model\EventDto;
use App\Form\Type\EventFormType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use League\Flysystem\FilesystemOperator;

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
        EntityManagerInterface $em,
        Request $request,
        FilesystemOperator $defaultStorage
    ) {
        $eventDto = new EventDto();
        $form = $this->createForm(EventFormType::class, $eventDto);
        $form -> handleRequest($request);
        if ($form -> isSubmitted() && $form -> isValid()){
            $extension = explode('/', mime_content_type($eventDto -> image))[1];
            $data = explode(',', $eventDto -> image);          
            $filename = sprintf('%s.%s', uniqid('event_', true), $extension);
            $defaultStorage -> write($filename, base64_decode($data[1]));
            $event = new Event();
            $event -> setTitle($eventDto -> title);
            $event -> setType($eventDto -> type);
            $event -> setBeginDate($eventDto -> beginDate);
            $event -> setEndDate($eventDto -> endDate);
            $event -> setDepartment($eventDto -> department);
            $event -> setVocalia($eventDto -> vocalia);
            $event -> setModality($eventDto -> modality);
            $event -> setDescription($eventDto -> description);
            $event -> setDificulty($eventDto -> dificulty);
            $event -> setUrl($eventDto -> url);
            $event -> setImage($filename);
            $event -> setOutsatnding($eventDto -> outsatnding);
            $em->persist($event);
            $em->flush();
            return $event;
        }
        return $form;
    }
}