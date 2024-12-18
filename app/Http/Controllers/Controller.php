<?php

namespace App\Http\Controllers;

use App\Models\Values;

abstract class Controller
{
    protected function generateID(int $id)
    {
        $rec = Values::find($id);
        $pref = $rec->val_prefix;
        $val = $rec->val_value + 1;
        $m = date('m');
        $y = date('Y');
        $new_id = $pref.$val.$m.$y;

        $rec->val_value = $val;
        $rec->save();

        return $new_id;
    }

    protected function successMessage(string $message = 'Record has been added successfully.')
    {
        return [
            'content' => $message,
            'status' => 'Success',
        ];
    }

    protected function warningMessage(string $message = 'Something went wrong. Please try again.')
    {
        return [
            'content' => $message,
            'status' => 'Warning',
        ];
    }

    protected function infoMessage(string $message = 'Record has been added successfully.')
    {
        return [
            'content' => $message,
            'status' => 'Info',
        ];
    }

    protected function dangerMessage(string $message = 'Unexpected error occured. Please contact the Developers regarding this matter.')
    {
        return [
            'content' => $message,
            'status' => 'Danger',
        ];
    }

    protected function getSubMenu(string $root, string $page, string $prefix = '')
    {
        $user = session()->get('user');

        // Existing in sidebar
        if(isset($user->menus[$root]['sub'][$prefix.'.'.$page]))
        {
            return $prefix.'.'.$page;
        }

        // Menu have no branch
        if((!$user->menus[$root]['branched'] && !isset($user->menus[$root]['subs'])) || empty($prefix))
        {
            return '';
        }

        return $prefix.'.index';
    }

    protected function inPageAction(string $page)
    {
        $actions = [
            'add',
            'edit',
            'view'
        ];

        return in_array($page, $actions);
    }
}
