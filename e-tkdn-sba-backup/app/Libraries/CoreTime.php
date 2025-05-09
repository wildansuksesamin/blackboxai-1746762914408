<?php

namespace CodeIgniter\I18n;

use DateTime;
use DateTimeZone;
use Exception;

class Time extends DateTime
{
    protected $timezone;
    protected $locale;

    public function __construct(string $time = null, $timezone = null, string $locale = null)
    {
        $this->timezone = $timezone ? new DateTimeZone($timezone) : new DateTimeZone(date_default_timezone_get());
        $this->locale = 'en';
        
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

    public function getYear()
    {
        return (int)$this->format('Y');
    }

    public function getMonth()
    {
        return (int)$this->format('m');
    }

    public function getDay()
    {
        return (int)$this->format('d');
    }

    public function getHour()
    {
        return (int)$this->format('H');
    }

    public function getMinute()
    {
        return (int)$this->format('i');
    }

    public function getSecond()
    {
        return (int)$this->format('s');
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

    public function setTimestamp($timestamp)
    {
        parent::setTimestamp($timestamp);
        return $this;
    }

    public function getTimestamp()
    {
        return parent::getTimestamp();
    }

    public function toLocalizedString($format = 'yyyy-MM-dd HH:mm:ss')
    {
        return $this->format('Y-m-d H:i:s');
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
}
