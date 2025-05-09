<?php

namespace CodeIgniter\I18n;

use CodeIgniter\I18n\Exceptions\I18nException;
use DateTime;
use DateTimeZone;
use Exception;
use IntlDateFormatter;

trait TimeTrait
{
    /**
     * @var DateTime
     */
    protected $datetime;

    /**
     * @var DateTimeZone
     */
    protected $timezone;

    /**
     * @var string
     */
    protected $locale;

    public function __construct(string $time = null, $timezone = null, string $locale = null)
    {
        $this->locale = 'en';
        $this->timezone = $timezone ? new DateTimeZone($timezone) : new DateTimeZone(date_default_timezone_get());
        
        if (is_null($time)) {
            $time = 'now';
        }
        
        $this->datetime = new DateTime($time, $this->timezone);
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

    public function format($format = 'Y-m-d H:i:s')
    {
        return $this->datetime->format($format);
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

    public function getDayOfWeek()
    {
        return (int)$this->format('w');
    }

    public function getDayOfYear()
    {
        return (int)$this->format('z');
    }

    public function getWeekOfMonth()
    {
        return (int)$this->format('W');
    }

    public function getWeekOfYear()
    {
        return (int)$this->format('W');
    }

    public function getTimestamp()
    {
        return $this->datetime->getTimestamp();
    }

    public function getTimezone()
    {
        return $this->timezone;
    }

    public function setTimezone($timezone)
    {
        if (is_string($timezone)) {
            $timezone = new DateTimeZone($timezone);
        }
        $this->timezone = $timezone;
        $this->datetime->setTimezone($timezone);
        return $this;
    }

    public function setTimestamp($timestamp)
    {
        $this->datetime->setTimestamp($timestamp);
        return $this;
    }

    public function __toString()
    {
        return $this->toDateTimeString();
    }
}
