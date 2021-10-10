<?php

namespace App\Form\Model;

use App\Entity\Event;

class EventDto {
    public $title;
    public $type;
    public $beginDate;
    public $endDate;
    public $department;
    public $vocalia;
    public $modality;
    public $description;
    public $dificulty;
    public $url;
    public $image;
    public $outsatnding;

    public function __construct()
    {
        $this->modality = [];
    }

    public static function createFromEvent(Event $event): self
    {
        $dto = new self();
        $dto->title = $event->getTitle();
        return $dto;
    }
}