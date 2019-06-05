<?php

namespace Recruiter\Geezer\Command;

interface LeadershipEventsHandler
{
    /**
     * This method is called every time leadership status changes from lost to acquired.
     */
    public function leadershipAcquired(): void;

    /**
     * This method is called every time leadership status changes from acquired to lost.
     */
    public function leadershipLost(): void;
}
