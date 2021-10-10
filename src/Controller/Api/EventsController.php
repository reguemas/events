<?php

namespace App\Controller\Api;

use App\Entity\Event;
use App\Form\Model\EventDto;
use App\Form\Type\EventFormType;
use App\Repository\EventRepository;
use App\Service\FileUploader;
use App\Service\EventFormProcessor;
use App\Service\EventManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

class EventsController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="event/events")
     * @Rest\View(serializerGroups={"event"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(
        EventManager $eventManager
    ) {
        return $eventManager->getRepository()->findAll();
    }

    /**
     * @Rest\Post(path="event/addEvent")
     * @Rest\View(serializerGroups={"event"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction(
        EntityManagerInterface $em,
        Request $request,
        FileUploader $fileUploader
    ) {
        $eventDto = new EventDto();
        $form = $this->createForm(EventFormType::class, $eventDto);
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $event = new Event();
            $event->setTitle($eventDto->title);
            $event->setType($eventDto->type);
            $event->setBeginDate($eventDto->beginDate);
            $event->setEndDate($eventDto->endDate);
            $event->setDepartment($eventDto->department);
            $event->setVocalia($eventDto->vocalia);
            $event->setDescription($eventDto->description);
            $event->setDificulty($eventDto->dificulty);
            $event->setUrl($eventDto->url);
            if ($eventDto -> image) {
                $filename = $fileUploader->base64FileUploader($eventDto -> image);
                $event->setImage($filename);
            }
            $event->setOutsatnding($eventDto->outsatnding);
            $em->persist($event);
            $em->flush();
            return $event;
        }
        return $form;
    }

    /**
     * @Rest\Post(path="event/editEvent/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"event"}, serializerEnableMaxDepthChecks=true)
     */
    public function editAction(
        int $id,
        EventFormProcessor $eventFormProcessor,
        EventManager $eventManager,
        Request $request
    ) {
        $event = $eventManager->find($id);
        if (!$event) {
            return View::create('Book not found', Response::HTTP_BAD_REQUEST);
        }
        [$event, $error] = ($eventFormProcessor)($event, $request);
        $statusCode = $event ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
        $data = $event ?? $error;
        return View::create($data, $statusCode);
    }

    /**
     * @Rest\Delete(path="event/deleteEvent/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"event"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteAction(
        int $id,
        EventManager $eventManager
    ) {
        $event = $eventManager->find($id);
        if (!$event) {
            return View::create('Event not found', Response::HTTP_NOT_FOUND);
        }
        $eventManager->delete($event);
        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}