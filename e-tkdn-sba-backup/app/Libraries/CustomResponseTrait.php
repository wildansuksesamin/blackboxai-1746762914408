<?php

namespace CodeIgniter\HTTP;

use App\Libraries\SimpleDateTime;

trait CustomResponseTrait
{
    protected $statusCode = 200;
    protected $protocolVersion;
    protected $reason = '';
    protected $body;
    protected $cookieStore;

    public function setStatusCode(int $code, string $reason = '')
    {
        $this->statusCode = $code;
        if (!empty($reason)) {
            $this->reason = $reason;
        }

        return $this;
    }

    public function setJSON($body, bool $unencoded = false)
    {
        $this->setHeader('Content-Type', 'application/json');

        if ($unencoded === true) {
            $this->setBody($body);
        } else {
            $this->setBody(json_encode($body));
        }

        return $this;
    }

    public function setBody($data)
    {
        $this->body = $data;
        return $this;
    }

    protected function sendHeaders()
    {
        if (!headers_sent()) {
            // Set the date header using SimpleDateTime
            $date = SimpleDateTime::now()->format('D, d M Y H:i:s') . ' GMT';
            $this->setHeader('Date', $date);

            foreach ($this->headers() as $header) {
                header($header->toString(), true, $this->statusCode);
            }

            if (!is_null($this->cookieStore)) {
                $this->cookieStore->dispatch();
            }
        }

        return $this;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendBody();

        return $this;
    }

    protected function sendBody()
    {
        echo $this->body;
        return $this;
    }
}
