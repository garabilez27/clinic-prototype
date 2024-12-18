<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $root = 'sttng';
    private $default_route = 'settings';

    public function index()
    {
        return $this->render('display');
    }

    public function render(string $page, array $records = [], string $search = '')
    {
        try
        {
            $data = [
                's_menu' => $this->root,
                's_submenu' => $this->getSubMenu($this->root, $page),
                'records' => $records,
                'search' => $search,
            ];
            return view('pages.'.$page, $data);
        }
        catch(Exception $e)
        {
            return redirect()->route('dashboard')->with('message', $this->dangerMessage());
        }
    }
}
