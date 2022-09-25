<?php

namespace Calendar\Controller;

use Calendar\Model\LeapYear;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class LeapYearController
{
    public function index( Request $request, int $year)
    {
        if (LeapYear::is_leap_year($year)) {
            return new Response('Yes it is');
        }

        return new Response('No it\'s not', 400);
    }

}
