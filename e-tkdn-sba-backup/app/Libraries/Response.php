<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Response as BaseResponse;

class Response extends BaseResponse
{
    protected function sendHeaders()
    {
        if (! headers_sent()) {
            foreach ($this->headers() as $header) {
                header($header->toString(), true, $this->statusCode);
            }

            if (! is_null($this->cookieStore)) {
                $this->cookieStore->dispatch();
            }
        }

        return $this;
    }
}
