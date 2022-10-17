<?php

namespace Calendar\Controller;

use Calendar\Model\LeapYear;
use Symfony\Component\HttpFoundation\Request;

class LeapYearController
{
    public function index(Request $request, int $year)
    {
        if (LeapYear::is_leap_year($year)) {
            return 'Yes it is';
        }

        return 'No it\'s not';
    }

}
