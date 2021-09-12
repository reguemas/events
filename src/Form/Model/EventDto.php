<?php

namespace App\Form\Model;

class EventDto {
    public $title;
    public $type;
    public $beginDate;
    public $endDate;
    public $department;
    public $vocalia;
    public $description;
    public $dificulty;
    public $url;
    public $image;
    public $outsatnding;
    public $modality;

    public function __construct()
    {
        $this->modality = [];
    }
}