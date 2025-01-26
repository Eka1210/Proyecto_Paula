<?php

namespace Model;

use Model\Report;

class ReportProxy implements ReportInterface
{
    private Report $report;

    public function __construct()
    {
        $this->report = new Report();
    }


    function getReport($startDate, $endDate)
    {
        if ($this->report == null) {
            $this->report = new Report();
        }
        return $this->report->getReport($startDate, $endDate);
    }
}
