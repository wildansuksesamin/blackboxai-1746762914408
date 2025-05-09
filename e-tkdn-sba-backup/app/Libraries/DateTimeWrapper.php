<?php

namespace App\Libraries;

use DateTime;
use DateTimeZone;

class DateTimeWrapper
{
    protected $datetime;

    public function __construct($time = 'now', $timezone = null)
    {
        $timezone = $timezone ? new DateTimeZone($timezone) : new DateTimeZone(date_default_timezone_get());
        $this->datetime = new DateTime($time, $timezone);
    }

    public static function now($timezone = null)
    {
        return new self('now', $timezone);
    }

    public function format($format = 'Y-m-d H:i:s')
    {
        return $this->datetime->format($format);
    }

    public function __toString()
    {
        return $this->format();
    }

    public function modify($modify)
    {
        $this->datetime->modify($modify);
        return $this;
    }

    public function setTimezone($timezone)
    {
        if (is_string($timezone)) {
            $timezone = new DateTimeZone($timezone);
        }
        $this->datetime->setTimezone($timezone);
        return $this;
    }

    public function getTimezone()
    {
        return $this->datetime->getTimezone();
    }

    public function getTimestamp()
    {
        return $this->datetime->getTimestamp();
    }
}
