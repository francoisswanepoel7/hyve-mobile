<?php


namespace hyvemobile\utils;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidDateException;

class Timezone
{
    public static string $format_local_input = 'd-M-Y H:m:s';
    public static string $format_local_output = 'Y-m-d H:i:s';
    public static function getLocalDateTime(string $date, string $time) {
        $datetime = $date.' '.$time;
        try {
            return Carbon::parse($datetime)->format(self::$format_local_output);
        } catch (InvalidDateException $exp) {
            echo $exp->getMessage();
        }
    }

    public static function getCountryRegion(string $tz) {
        return explode("/", $tz);
    }

    public static function getUTCDateTime(string $datetime, string $tz) {
        try {
            return Carbon::parse($datetime)->setTimezone($tz)->format(self::$format_local_output);
        } catch (\Carbon\Exceptions\InvalidDateException $exp) {
            echo $exp->getMessage();
        }
    }

}
