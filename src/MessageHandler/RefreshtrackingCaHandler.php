<?php

namespace App\MessageHandler;

use App\Message\YourMessage;
use App\Message\RefreshCaTracking;
use App\Services\Stat\StatAdminService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RefreshtrackingCaHandler
{
    public function __construct(
        private StatAdminService $statAdminService,
    ) {
    }
    public function __invoke(RefreshCaTracking $message)
    {
        $this->statAdminService->refreshCaTrackingTable();
    }
}
