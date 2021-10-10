<?php

namespace App\Service;

use App\Entity\Event;
use App\Service\FileUploader;
use Symfony\Component\Form\FormFactoryInterface;
use App\Form\Model\EventDto;
use App\Form\Model\ModalityDto;
use App\Form\Type\EventFormType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

class EventFormProcessor
{

    private $eventManager;
    private $modalityManager;
    private $fileUploader;
    private $formFactory;

    public function __construct(
        EventManager $eventManager,
        ModalityManager $modalityManager,
        FileUploader $fileUploader,
        FormfactoryInterface $formFactory
    )
    {
        $this->eventManager = $eventManager;
        $this->modalityManager = $modalityManager;
        $this->fileUploader = $fileUploader;
        $this->formFactory = $formFactory;
    }

    public function __invoke(Event $event, Request $request): array
    {
        $eventDto = EventDto::createFromEvent($event);

        $originalModalities = new ArrayCollection();
        foreach ($event->getModality() as $modality) {
            $modalityDto = ModalityDto::createFromModality($modality);
            $eventDto->modalities[] = $modalityDto;
            $originalModalities->add($modalityDto);
        }
        $form = $this->formFactory->create(EventFormType::class, $eventDto);
        $form->handleRequest($request);
        if (!$form->isSubmitted()){
            return [null, 'Form is not submitted'];
        }
        if ($form->isValid()) {
            //Remove Modalities
            foreach ($originalModalities as $originalModalityDto) {
                if (!in_array($originalModalityDto, $eventDto->modalities)) {
                    $modality = $this->modalityManager->find($originalModalityDto->id);
                    $event->removeModality($modality);
                }
            }

            // Add Modalities
            foreach ($eventDto->modalities as $newModalityDto){
                if (!$originalModalities->contains($newModalityDto)) {
                    $modality = $this->modalityManager->find($newModalityDto->id ?? 0);
                    if (!$modality) {
                        $modality = $this->modalityManager->create();
                        $modality->setName($newModalityDto->name);
                        $this->modalityManager->persist($modality);
                    }
                    $event->addModality($modality);
                }
            }
            $event->setTitle($eventDto->title);
            if ($eventDto->image) {
                $filename = $this->fileUploader->base64FileUploader($eventDto->image);
                $event->setImage($filename);
            }
            $this->eventManager->save($event);
            $this->eventManager->reload($event);
            return [$event, null];
        }
        return [null, $form];
    }

}