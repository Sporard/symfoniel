<?php


class LeapYear {


    public static function is_leap_year(int $year = null)
    {
        if (is_null($year)) {
            $year = date('Y');
        }

        return $year % 400 === 0 || ($year % 4 === 0 && !($year % 100 === 0));
    }
}