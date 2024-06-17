<?php


namespace App\Schedule;

use App\Services\NewsLettersService;
use Zenstruck\ScheduleBundle\Schedule;
use Zenstruck\ScheduleBundle\Schedule\ScheduleBuilder;

class AppScheduleBuilder implements ScheduleBuilder
{

    public function __construct(
        private NewsLettersService $newsLettersService,
    )
    {
      
    }

    public function buildSchedule(Schedule $schedule): void
    {
        $schedule
            ->timezone('UTC')
            ->environments('prod', 'dev');
        ;

        $schedule->addCallback(function() {
            $this->newsLettersService->sendNewsLetters();
        })
        ->description('Send newsLetters')
        ->cron('*/25 * * * *');

      
    }
}
