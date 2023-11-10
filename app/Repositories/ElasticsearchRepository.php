<?php

namespace App\Repositories;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use App\Utilities\Contracts\ElasticsearchHelperInterface;

class ElasticsearchRepository implements ElasticsearchHelperInterface
{
    /** @var Client $client */
    private Client $client;

    /** @var array $mailData */
    private array $mailData;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->setHosts([env('ELASTICSEARCH_HOST')])->build();
    }

    /**
     * @inheritDoc
     */
    public function storeEmail(string $messageBody, string $messageSubject, string $toEmailAddress): array|callable
    {
        $this->setEmailData(body: $messageBody, subject: $messageSubject, to: $toEmailAddress);
        return $this->client->index($this->setIndexParams());
    }

    /**
     * @param string $body
     * @param string $subject
     * @param string $to
     * @return void
     */
    private function setEmailData(string $body, string $subject, string $to): void
    {
        $this->mailData = [
            'subject' => $subject,
            'body' => $body,
            'to' => $to,
        ];
    }

    /**
     * @return array
     */
    private function setIndexParams(): array
    {
         return [
            'index' => 'emails',
            'type' => 'email',
            'body' => $this->mailData,
        ];
    }
}
