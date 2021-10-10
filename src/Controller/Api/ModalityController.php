<?php

namespace App\Controller\Api;

use App\Service\ModalityManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class ModalityController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/modality")
     * @Rest\View(serializerGroups={"modality"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(
        ModalityManager $modalityManager
    ) {
        return $modalityManager->getRepository()->findAll();
    }
}