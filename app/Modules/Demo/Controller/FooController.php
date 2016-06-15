<?php

namespace App\Modules\Demo\Controller;

use App\Event\DemoEvent;
use App\Lib\LogHandler;
use Minor\Controller\Controller;
use Minor\Event\EventManager;
use Minor\Proxy\Proxy;
use Minor\View\View;


class FooController extends Controller
{
    public function bar($productName)
    {
        $event = new DemoEvent('DemoEvent');
        EventManager::fire($event);

        $container = $this->app->getServiceContainer();
        $shop = $container->get('shop');

        $log = new LogHandler();
        $shopProxy = Proxy::newProxyInstance($shop, $log);
        $shopProxy->buy($productName);

        $this->minorResponse->setContent(View::render('Demo:Foo:bar.php', ['controllerName' => 'FooController', 'actionName' => 'bar']));

        return $this->minorResponse;
    }
}