<?php

namespace App\Http\Requests\Email;

use Illuminate\Foundation\Http\FormRequest;

class SendRequest extends FormRequest
{
    /** @var array $emails */
    private array $emails;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user' => 'required|uuid|exists:users,uuid',
            'emails' => 'required|array',
            'emails.*' => 'required|array',
            'emails.*.email' => 'required|email',
            'emails.*.subject' => 'required|string',
            'emails.*.body' => 'required|string',
        ];
    }

    public function validationData(): array
    {
        return array_merge(parent::validationData(), ['user' => $this->route('user')]); // TODO: Change the autogenerated stub
    }

    protected function passedValidation(): void
    {
        $this->emails = $this->input('emails');
    }

    /**
     * @return array
     */
    public function getEmails(): array
    {
        return $this->emails;
    }
}