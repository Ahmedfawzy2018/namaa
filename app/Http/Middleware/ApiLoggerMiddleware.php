<?php

namespace App\Http\Middleware;

use Closure;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiLoggerMiddleware
{
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Request $request, Closure $next)
    {
        // Generate a correlation ID for the request
        $correlationId = uniqid();

        // Log the request
        $this->logger->info('Incoming API request', [
            'correlation_id' => $correlationId,
            'method' => $request->getMethod(),
            'url' => $request->fullUrl(),
            'headers' => $request->header(),
            'payload' => $request->all(),
        ]);

        // Handle the request and get the response
        $response = $next($request);

        // Log the response
        $this->logger->info('Outgoing API response', [
            'correlation_id' => $correlationId,
            'status' => $response->status(),
            'headers' => $response->headers->all(),
            'payload' => $response->original,
        ]);

        // Return the response
        return $response;
    }
}
