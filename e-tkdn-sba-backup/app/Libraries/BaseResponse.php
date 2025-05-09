<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\Message;
use DateTime;
use DateTimeZone;

class BaseResponse extends Message
{
    protected $statusCode = 200;
    protected $cookieStore;

    public function setStatusCode(int $code, string $reason = '')
    {
        $this->statusCode = $code;
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setHeader(string $name, $value)
    {
        $this->headers[$name] = [$value];
        return $this;
    }

    public function removeHeader(string $name)
    {
        unset($this->headers[$name]);
        return $this;
    }

    public function setBody($data)
    {
        $this->body = $data;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function appendBody($data)
    {
        $this->body .= $data;
        return $this;
    }

    protected function sendHeaders()
    {
        if (!headers_sent()) {
            foreach ($this->headers as $name => $values) {
                foreach ($values as $value) {
                    header($name . ': ' . $value, true, $this->statusCode);
                }
            }

            if (!is_null($this->cookieStore)) {
                $this->cookieStore->dispatch();
            }
        }

        return $this;
    }

    protected function setDate()
    {
        $timezone = new DateTimeZone('UTC');
        $datetime = new DateTime('now', $timezone);
        $date = $datetime->format('D, d M Y H:i:s') . ' GMT';
        $this->setHeader('Date', $date);

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

    public function setLastModified($date)
    {
        if ($date instanceof DateTime) {
            $date = $date->format('D, d M Y H:i:s') . ' GMT';
        } elseif (is_string($date)) {
            $date = date('D, d M Y H:i:s', strtotime($date)) . ' GMT';
        }

        $this->setHeader('Last-Modified', $date);

        return $this;
    }
}
