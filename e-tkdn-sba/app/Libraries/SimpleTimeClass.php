<?php

namespace App\Libraries;

use CodeIgniter\I18n\SimpleTimeTrait;
use DateTime;

class SimpleTimeClass extends DateTime
{
    use SimpleTimeTrait;

    public static function instance($time = null, $timezone = null, string $locale = null)
    {
        return new static($time, $timezone);
    }

    public static function createFromDate($year = null, $month = null, $day = null)
    {
        $year = $year ?? date('Y');
        $month = $month ?? date('m');
        $day = $day ?? date('d');

        return self::instance("$year-$month-$day");
    }

    public static function createFromTime($hour = null, $minutes = null, $seconds = null)
    {
        $hour = $hour ?? date('H');
        $minutes = $minutes ?? date('i');
        $seconds = $seconds ?? date('s');

        return self::instance(date("Y-m-d $hour:$minutes:$seconds"));
    }

    public static function create($year = null, $month = null, $day = null, $hour = null, $minutes = null, $seconds = null)
    {
        $year = $year ?? date('Y');
        $month = $month ?? date('m');
        $day = $day ?? date('d');
        $hour = $hour ?? date('H');
        $minutes = $minutes ?? date('i');
        $seconds = $seconds ?? date('s');

        return self::instance("$year-$month-$day $hour:$minutes:$seconds");
    }

    public function modify($modify)
    {
        $this->datetime->modify($modify);
        return $this;
    }

    public function add($interval)
    {
        $this->datetime->add($interval);
        return $this;
    }

    public function sub($interval)
    {
        $this->datetime->sub($interval);
        return $this;
    }
}
