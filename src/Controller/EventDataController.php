<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EventDataController extends AbstractController
{
/*     private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    } */

    /**
    * @Route("/api/event",name="post_event")
    */
    public function addEvent(Request $request, LoggerInterface $logger)
    {
        $title = $request->get('title','Cresta de Peguera');
        $type = $request->get('type','Esportiva');
        $logger->info('List action called');
        $response = new JsonResponse();
        $response->setData([
            'success'=>true,
            'data'=>[
                [
                    'title'=>'Diada de Germanor',
                    'type'=>'Social'
                ],
                [
                    'title'=>'Casal d\'Estiu',
                    'type'=>'Social'
                ],
                [
                    'title'=>$title,
                    'type'=>$type
                ]
            ]
        ]);
        return $response;
    }
}