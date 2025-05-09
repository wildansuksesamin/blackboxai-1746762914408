<?php

namespace App\Libraries;

use CodeIgniter\Debug\ExceptionHandlerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class CustomExceptionHandler implements ExceptionHandlerInterface
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
        $response->setStatusCode($statusCode);

        if (strpos($request->getHeaderLine('accept'), 'text/html') === false) {
            $response->setJSON([
                'error' => $exception->getMessage(),
                'code'  => $statusCode,
            ]);
        } else {
            $view = $this->collectVars($exception, $statusCode);
            $response->setBody(view('errors/html/error_exception', $view));
        }

        $response->send();
        exit($exitCode);
    }

    protected function collectVars(Throwable $exception, int $statusCode): array
    {
        $data = [
            'title'   => get_class($exception),
            'type'    => get_class($exception),
            'code'    => $statusCode,
            'message' => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
            'trace'   => $exception->getTrace(),
        ];

        return $data;
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
