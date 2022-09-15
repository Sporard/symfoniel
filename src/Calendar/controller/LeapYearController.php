<?php

namespace Calendar\Controller;

require_once __DIR__ . '/../vendor/autoload.php';

use LeapYear;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LeapYearController
{
    public function index(int $year)
    {
        if (LeapYear::is_leap_year($year)) {
            return new Response('Yes it is');
        }

        return new Response('No it\'s not', 400);
    }

}
