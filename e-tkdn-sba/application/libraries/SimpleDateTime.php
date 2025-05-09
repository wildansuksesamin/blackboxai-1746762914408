<?php

namespace App\Libraries;

use DateTime;
use DateTimeZone;

class SimpleDateTime extends DateTime
{
    protected $timezone;

    public function __construct(string $time = null, $timezone = null)
    {
        $this->timezone = $timezone ? new DateTimeZone($timezone) : new DateTimeZone(date_default_timezone_get());
        
        if (is_null($time)) {
            $time = 'now';
        }
        
        parent::__construct($time, $this->timezone);
    }

    public static function now($timezone = null)
    {
        return new static(null, $timezone);
    }

    public static function parse(string $datetime, $timezone = null)
    {
        return new static($datetime, $timezone);
    }

    public function toDateTimeString()
    {
        return $this->format('Y-m-d H:i:s');
    }

    public function __toString()
    {
        return $this->toDateTimeString();
    }

    public function humanize()
    {
        $now = new DateTime('now', $this->timezone);
        $diff = $this->diff($now);
        
        if ($diff->y > 0) return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        if ($diff->m > 0) return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        if ($diff->d > 0) return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        if ($diff->h > 0) return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        if ($diff->i > 0) return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        
        return 'Just now';
    }

    public function setTimezone($timezone)
    {
        if (is_string($timezone)) {
            $timezone = new DateTimeZone($timezone);
        }
        $this->timezone = $timezone;
        parent::setTimezone($timezone);
        return $this;
    }

    public function getTimezone()
    {
        return $this->timezone;
    }
}
