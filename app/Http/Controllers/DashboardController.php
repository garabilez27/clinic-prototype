<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $root = 'dshbrd';
    private $default_route = 'dashboard';

    public function index()
    {
        return $this->render('dashboard');
    }

    public function render(string $page, array $records = [], string $search = '')
    {
        $data = [
            's_menu' => $this->root,
            's_submenu' => $this->getSubMenu($this->root, $page),
            'records' => $records,
            'search' => $search,
        ];

        return view('pages.'.$page, $data);
    }
}
