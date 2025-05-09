<?php

namespace App\Libraries;

use CodeIgniter\Debug\ExceptionHandlerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class SimpleExceptionHandler implements ExceptionHandlerInterface
{
    protected $request;
    protected $response;

    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    public function handle(Throwable $exception, RequestInterface $request, ResponseInterface $response, int $statusCode, int $exitCode): void
    {
        // Set status code
        http_response_code($statusCode);

        // Set headers
        header('Content-Type: application/json');
        
        // Set date header using SimpleDateTime
        $date = SimpleDateTime::now()->format('D, d M Y H:i:s') . ' GMT';
        header('Date: ' . $date);

        // Output error response
        echo json_encode([
            'error' => $exception->getMessage(),
            'code'  => $statusCode,
            'file'  => $exception->getFile(),
            'line'  => $exception->getLine(),
        ]);

        exit($exitCode);
    }

    public function initialize()
    {
        // Nothing to initialize
    }

    public function respond(Throwable $exception, int $statusCode, int $exitCode = 0)
    {
        $this->handle($exception, $this->request, $this->response, $statusCode, $exitCode);
    }
}
