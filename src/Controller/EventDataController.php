<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use App\Repository\EventRepository;

class EventDataController extends AbstractController
{
/*     private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    } */

    /**
    * @Route("/events",name="get_all_events")
    */
    public function listEvents(LoggerInterface $logger, EventRepository $eventRepository)
    {
        $events = $eventRepository -> findAll();
        $eventsAsArray = [];
        foreach($events as $event) {
            $eventsAsArray[] = [
                'id' => $event -> getId(),
                'title' => $event -> getTitle(),
                'type' => $event -> getType(),
                'beginDate' => $event -> getBeginDate(),
                'endDate' => $event -> getEndDate(),
                'department' => $event -> getDepartment(),
                'vocalia' => $event -> getVocalia(),
                'modality' => $event -> getModality(),
                'description' => $event -> getDescription(),
                'dificulty' => $event -> getDificulty(),
                'url' => $event -> getUrl(),
                'image' => $event -> getImage(),
                'outstanding' => $event -> getOutsatnding()
            ];
        };
        $logger->info('List action called');
        $response = new JsonResponse();
        $response->setData([
            'success' => true,
            'data' => $eventsAsArray
        ]);
        return $response;
    }

    /**
    * @Route("event/addEvent",name="post_event")
    */

    public function createEvent(EntityManagerInterface $em) {
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
        $response = new JsonResponse();
        $response->setData([
            'success'=>true,
            'data'=>[
                [
                    'title' => $event -> getTitle(),
                    'type' => $event -> getType(),
                    'beginDate' => $event -> getBeginDate(),
                    'endDate' => $event -> getEndDate(),
                    'department' => $event -> getDepartment(),
                    'vocalia' => $event -> getVocalia(),
                    'modality' => $event -> getModality(),
                    'description' => $event -> getDescription(),
                    'dificulty' => $event -> getDificulty(),
                    'url' => $event -> getUrl(),
                    'image' => $event -> getImage(),
                    'outsatnding' => $event -> getOutsatnding()
                ]
            ]
        ]);
        return $response;
    }
}