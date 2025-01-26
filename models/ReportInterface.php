<?php

namespace Model;

interface ReportInterface
{
    public function getReport($startDate, $endDate);
}
