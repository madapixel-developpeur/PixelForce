<?php

namespace App\Schedule;

use App\Services\RemunerationServiceSecu;
use DateTime;
use App\Services\RemunerationService;
use Zenstruck\ScheduleBundle\Schedule;
use Zenstruck\ScheduleBundle\Schedule\ScheduleBuilder;

class AppScheduleBuilder implements ScheduleBuilder
{

    public function __construct(
        private RemunerationService $remunerationService,
        private RemunerationServiceSecu $remunerationServiceSecu
    ) {
    }

    public function buildSchedule(Schedule $schedule): void
    {
        $schedule
            ->timezone($_ENV['APP_TIMEZONE'])
            ->environments('prod', 'dev');

        $schedule->addCallback(function () {
            $dateOfThePreviousMonthToCheck = (new DateTime())->modify('-1 hour');
            $this->remunerationService->checkUserRemuneration($dateOfThePreviousMonthToCheck);
            $this->remunerationServiceSecu->checkUserRemuneration($dateOfThePreviousMonthToCheck);
        })
            ->description('Rémuneration')
            ->monthly();
    }
}