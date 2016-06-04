<?php

namespace App\Listener;

use App\Event\DemoEvent;
use Minor\Event\Listener;

class DemoListener extends Listener
{
    public function handle(DemoEvent $event)
    {
        echo '[DemoListener] handle the event:[' . $event->getName() .'] success!<br/><br/>';
    }
}
