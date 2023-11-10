<?php

namespace App\Jobs;

use JsonException;
use Illuminate\Bus\Queueable;
use App\Mail\EmailMessageObject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Repositories\RedisRepository;
use App\Repositories\ElasticsearchRepository;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Utilities\Contracts\RedisHelperInterface;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Collection $emails */
    private Collection $emails;

    public function __construct(Collection $emails)
    {
        $this->emails = $emails;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws JsonException
     */
    public function handle(): void
    {
        foreach ($this->emails as $email){
            $this->sendEmailToUser($email);
            $this->storeEmailInformation($email);
        }
    }

    /**
     * @param array $email
     * @return void
     */
    private function sendEmailToUser(array $email): void
    {
        Log::info($email['email']);
        Mail::send(new EmailMessageObject(
            email: $email['email'],
            subject: $email['subject'],
            body: $email['body']
        ));
    }

    /**
     * @param array $email
     * @return void
     * @throws JsonException
     */
    private function storeEmailInformation(array $email): void
    {
        $index = (new ElasticsearchRepository())->storeEmail($email['body'], $email['subject'], $email['email']);
        $this->cacheStoredInformation($index, $email['subject'], $email['email']);
    }

    /**
     * @param array $index
     * @param string $subject
     * @param string $email
     * @return void
     * @throws JsonException
     */
    private function cacheStoredInformation(array $index, string $subject, string $email): void
    {
        (new RedisRepository())->storeRecentMessage($index, $subject, $email);
    }
}
