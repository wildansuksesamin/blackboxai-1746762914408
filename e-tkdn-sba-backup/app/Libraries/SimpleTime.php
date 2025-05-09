<?php

namespace App\Libraries;

use DateTime;
use DateTimeZone;
use CodeIgniter\I18n\Time;

class SimpleTime extends Time
{
    public function __construct(string $time = null, $timezone = null, $locale = null)
    {
        $timezone = $timezone ?: date_default_timezone_get();
        $this->timezone = new DateTimeZone($timezone);
        
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

    protected function setTimezone($timezone)
    {
        if (is_string($timezone)) {
            $timezone = new DateTimeZone($timezone);
        }
        return parent::setTimezone($timezone);
    }

    public function toDateTimeString()
    {
        return $this->format('Y-m-d H:i:s');
    }

    public function getYear()
    {
        return $this->format('Y');
    }

    public function getMonth()
    {
        return $this->format('m');
    }

    public function getDay()
    {
        return $this->format('d');
    }

    public function getHour()
    {
        return $this->format('H');
    }

    public function getMinute()
    {
        return $this->format('i');
    }

    public function getSecond()
    {
        return $this->format('s');
    }
}
