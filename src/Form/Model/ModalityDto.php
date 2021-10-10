<?php

namespace App\Form\Model;

use App\Entity\Modality;

class ModalityDto {
    public $id;
    public $name;

    public static function createFromModality(Modality $modality): self
    {
        $dto = new self();
        $dto -> id = $modality->getId();
        $dto -> name = $modality->getName();
        return $dto;
    }
}