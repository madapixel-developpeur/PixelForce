<?php

namespace App\Schedule;

use App\Services\RemunerationServiceSecu;
use DateTime;
use App\Services\RemunerationService;
use App\Services\Stat\StatAdminService;
use Zenstruck\ScheduleBundle\Schedule;
use Zenstruck\ScheduleBundle\Schedule\ScheduleBuilder;

class AppScheduleBuilder implements ScheduleBuilder
{

    public function __construct(
        private RemunerationService $remunerationService,
        private RemunerationServiceSecu $remunerationServiceSecu,
        private StatAdminService $statAdminService,
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
            $this->remunerationServiceSecu->checkUserRemuneration($dateOfThePreviousMonthToCheck, $_ENV['SECTEUR_SECURITE_ID']);
        })
        ->description('Rémuneration')
        ->monthly();

        $schedule->addCallback(function () {
            $this->statAdminService->refreshCaTrackingTable();
        })
        ->description('refresh agent global CA ')
        ->cron('0 2,8,14,20 * * *');
    }
}