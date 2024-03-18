<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CustomValidationException extends Exception
{
    protected $messages;

    public function __construct(array $messages, $code = 422, \Throwable $previous = null)
    {
        $this->messages = new MessageBag($messages);
        parent::__construct('Validation failed', $code, $previous);
    }

    function flattenMessages(array $messages, $keyPrefix = ''): array
    {
        $flattened = [];
        foreach ($messages as $key => $value) {
            $newKey = $keyPrefix ? "$keyPrefix.$key" : $key;
            if (is_array($value)) {
                $flattened = array_merge($flattened, $this->flattenMessages($value, $newKey));
            } else {
                array_push($flattened, $value);
            }
        }
        return $flattened;
    }

    public function render($request): JsonResponse
    {

        return new JsonResponse([
            'code' => $this->code,
            'errors' => $this->flattenMessages($this->messages->toArray()),
            'message' => $this->getMessage(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
