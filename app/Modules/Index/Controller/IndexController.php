<?php

namespace App\Modules\Index\Controller;

use Minor\Controller\Controller;
use Minor\View\View;

class IndexController extends Controller
{
    public function index()
    {
        return View::render('Index:Index:index.php', ['name' => 'Minor']);
    }
}
