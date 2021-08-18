<?php

namespace App\Serializer;

use App\Entity\Event;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EventNormalizer implements ContextAwareNormalizerInterface
{

    private $normalizer;
    private $urlHelper;

    public function __construct(
        ObjectNormalizer $normalizer,
        UrlHelper $urlHelper
    ) {
        $this -> normalizer = $normalizer;
        $this -> urlHelper = $urlHelper;
    }

    public function normalize($event, $format = null, array $context = [])
    {
        $data = $this->normalizer -> normalize($event, $format, $context);

        if(!empty($event -> getImage())) {
            $data['image'] = $this -> urlHelper -> getAbsoluteUrl('/storage/default/' . $event -> getImage());
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Event;
    }
}