<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Response;
use DateTime;
use DateTimeZone;

class CustomResponse extends Response
{
    protected function sendHeaders()
    {
        if (!headers_sent()) {
            foreach ($this->headers() as $header) {
                if (strpos($header->getValue(), 'Last-Modified') === false) {
                    header($header->toString(), true, $this->statusCode);
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
