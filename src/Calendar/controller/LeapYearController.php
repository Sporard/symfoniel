<?php

namespace Calendar\Controller;

use Calendar\Model\LeapYear;
use Simplex\BaseController;
use Symfony\Component\HttpFoundation\Request;

class LeapYearController extends BaseController
{
    public function index(Request $request, int $year)
    {
        if (LeapYear::is_leap_year($year)) {
            return $this->render('leap_year.html.twig', ['status' => true]);
        }

        return $this->render('leap_year.html.twig', ['status' => false]);

    }

}
