<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class APIResponse
{
    /**
     * Handle an incoming request.
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $original = [];

        if ($response instanceof Response) {
            $original = $response->getOriginalContent();
        }

        if ($response instanceof JsonResponse) {
            $original = json_decode($response->content(), true);
        }

        $statusCode = $response->getStatusCode();

        $message = $original['message'] ?? Arr::get(Response::$statusTexts, $statusCode, '');
        $payload = $original['payload'] ?? [];

        $content = [
            'code' => $statusCode,
            'success' => $response->isSuccessful(),
            'message' => $message,
        ];

        if (isset($payload)) {
            $content['payload'] = $payload;
        }

        if (isset($original['payload']['meta'])) {
            $content['meta'] = Arr::get($original, 'payload.meta', $original);
            unset($content['payload']['meta']);
        }

        if (isset($original['errors'])) {
            $content['errors'] = Arr::get($original, 'errors', $original);
            unset($content['data']['errors']);
        }

        if ($response instanceof Response) {
            $response->setContent($content);
        }

        if ($response instanceof JsonResponse) {
            $response->setData($content);
        }

        return $response;
    }
}
