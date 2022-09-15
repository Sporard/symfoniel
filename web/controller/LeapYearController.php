<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LeapYearController
{
    public function index(int $year)
    {
        if ($this->is_leap_year($year)) {
            return new Response('Yes it is');
        }

        return new Response('No it\'s not', 400);
    }

    protected function is_leap_year(int $year = null)
    {
        if (is_null($year)) {
            $year = date('Y');
        }

        return $year % 400 === 0 || ($year % 4 === 0 && !($year % 100 === 0));
   }
}
