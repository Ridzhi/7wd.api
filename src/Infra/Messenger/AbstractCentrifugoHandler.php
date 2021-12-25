<?php

namespace App\Infra\Messenger;

use App\Infra\Centrifugo\Channel;
use phpcent\Client;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

abstract class AbstractCentrifugoHandler
{
    public function __construct(
        private NormalizerInterface $normalizer,
        private Client              $centrifugo,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    protected function publish(Channel $channel, object $message): void
    {
        $this->centrifugo->publish(
            $channel->value,
            $this->normalizer->normalize(
                $message,
                context: [AbstractObjectNormalizer::SKIP_NULL_VALUES => true],
            )
        );
    }
}
