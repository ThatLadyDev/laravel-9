<?php

namespace App\Repositories;

use JsonException;
use Illuminate\Support\Facades\Redis;
use App\Utilities\Contracts\RedisHelperInterface;

class RedisRepository implements RedisHelperInterface
{
    /**
     * @inheritDoc
     * @throws JsonException
     */
    public function storeRecentMessage(mixed $id, string $messageSubject, string $toEmailAddress): void
    {
        $key = "_email:$toEmailAddress";

        $messageData = json_encode([
            'id' => $id,
            'subject' => $messageSubject,
        ], JSON_THROW_ON_ERROR);

        Redis::lpush($key, $messageData);
    }
}
