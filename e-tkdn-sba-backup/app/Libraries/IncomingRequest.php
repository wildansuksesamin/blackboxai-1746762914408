<?php

namespace App\Libraries;

use CodeIgniter\HTTP\IncomingRequest as BaseIncomingRequest;

class IncomingRequest extends BaseIncomingRequest
{
    protected function setLocale()
    {
        // Skip locale detection and just use default
        return $this;
    }

    public function detectLocale()
    {
        // Skip locale detection and just use default
        return $this;
    }
}
