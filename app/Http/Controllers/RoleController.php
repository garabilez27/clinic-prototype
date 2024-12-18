<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\RoleMenus;
use Exception;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\RoleSubMenus;
use App\Models\SubMenus;

class RoleController extends Controller
{
    private $root = 'sttng';
    private $default_route = 'rl.index';

    public function index(Request $request)
    {
        // validattion for search engine
        $inputs = $request->validate([
            'search' => 'nullable|string',
        ]);

        if(empty($inputs['search']) && isset($request['search']))
        {
            return redirect()->route($this->default_route);
        }

        // get list
        $search = isset($inputs['search']) ? $inputs['search'] : '';
        $roles = Roles::where('rl_deleted', 0);
        if(!empty($inputs['search']))
        {
            $roles = Roles::where('rl_deleted', 0)->whereRaw('rl_detail like ?', '%'.$search.'%');
        }

        // Generate data
        $data = [
            'paginate' => $roles->paginate(),
            'start' => isset($request['page']) ? (($request['page'] * $roles->paginate()->total()) != 0 ? $request['page'] * $roles->paginate()->total() : 1) : 1,
            'count' => $roles->paginate()->total(),
            'max' => $roles->count(),
            'roles' => $roles->get(),
        ];

        return $this->render('index', $data, $search);
    }

    public function view(string $id)
    {
        try
        {
            $role_menus = [];
            $menus = Menus::where('mn_deleted', 0)->orderBy('mn_sequence', 'asc')->get();
            $r_menus = RoleMenus::whereRaw('md5(rl_id) = ?', $id)->get();
            foreach($r_menus as $menu)
            {
                $role_menus[] = md5($menu->mn_id);
                $r_sub_menus = RoleSubMenus::where('rlmn_id', $menu->rlmn_id)->get();
                foreach($r_sub_menus as $sub)
                {
                    $role_menus[] = md5($sub->sbmn_id);

                    // actions
                    if($sub->rsm_create)
                    {
                        $role_menus[] = md5($sub->sbmn_id).'-create';
                    }
                    if($sub->rsm_update)
                    {
                        $role_menus[] = md5($sub->sbmn_id).'-update';
                    }
                    if($sub->rsm_destroy)
                    {
                        $role_menus[] = md5($sub->sbmn_id).'-delete';
                    }
                    if($sub->rsm_view)
                    {
                        $role_menus[] = md5($sub->sbmn_id).'-view';
                    }
                }
                // actions
                if($menu->rlmn_create)
                {
                    $role_menus[] = md5($menu->mn_id).'-create';
                }
                if($menu->rlmn_update)
                {
                    $role_menus[] = md5($menu->mn_id).'-update';
                }
                if($menu->rlmn_destroy)
                {
                    $role_menus[] = md5($menu->mn_id).'-delete';
                }
                if($menu->rlmn_view)
                {
                    $role_menus[] = md5($menu->mn_id).'-view';
                }
            }

            $data = [
                'menus' => $menus,
                'role_menus' => $role_menus,
                'id' => $id,
            ];

            return $this->render('view', $data);
        }
        catch(Exception $e)
        {
            return redirect()->route($this->default_route)->with('message', $this->dangerMessage());
        }
    }

    public function createMenus(Request $request)
    {
        $inputs = $request->validate([
            'menus' => 'array',
            'menus.*' => 'string',
            'subs' => 'array',
            'subs.*' => 'string',
            'actions' => 'array',
            'actions.*' => 'string',
            'id' => 'string|required'
        ]);

        // Get all checked actions, no keys values only
        $actions = isset($inputs['actions']) ? array_values($inputs['actions']) : [];

        try
        {
            // Validate role
            $role = Roles::whereRaw('md5(rl_id) = ?', $inputs['id'])->where('rl_deleted', 0)->first();
            if(!$role)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            // Delete existing menus and sub menus
            $e_menus = RoleMenus::where('rl_id', $role->rl_id)->get();
            foreach($e_menus as $menu)
            {
                // Delete role sub menus
                RoleSubMenus::where('rlmn_id', $menu->rlmn_id)->delete();
                RoleMenus::find($menu->rlmn_id)->delete();
            }

            foreach($inputs['menus'] as $menu)
            {
                // Validate menu
                $val_menu = Menus::whereRaw('md5(mn_id) = ?', $menu)->where('mn_deleted',0)->first();
                if($val_menu)
                {
                    $create = in_array($menu.'-create', $actions);
                    $update = in_array($menu.'-update', $actions);
                    $delete = in_array($menu.'-delete', $actions);
                    $view = in_array($menu.'-view', $actions);

                    $role_menu = new RoleMenus();
                    $role_menu->rl_id = $role->rl_id;
                    $role_menu->mn_id = $val_menu->mn_id;
                    $role_menu->rlmn_create = $create;
                    $role_menu->rlmn_update = $update;
                    $role_menu->rlmn_destroy = $delete;
                    $role_menu->rlmn_view = $view;
                    $role_menu->save();

                    if(isset($inputs['subs']))
                    {
                        foreach($inputs['subs'] as $sub)
                        {
                            $arr = explode('-', $sub);
                            if(count($arr) == 2 && $menu == $arr[1])
                            {
                                // Validate sub menu
                                $val_sub_menu = SubMenus::whereRaw('md5(sbmn_id) = ?', $arr[0])->where('sbmn_deleted', 0)->first();
                                if($val_sub_menu)
                                {
                                    $create = in_array($arr[0].'-create', $actions);
                                    $update = in_array($arr[0].'-update', $actions);
                                    $delete = in_array($arr[0].'-delete', $actions);
                                    $view = in_array($arr[0].'-view', $actions);

                                    $role_sub_menu = new RoleSubMenus();
                                    $role_sub_menu->rlmn_id = $role_menu->rlmn_id;
                                    $role_sub_menu->sbmn_id = $val_sub_menu->sbmn_id;
                                    $role_sub_menu->rsm_create = $create;
                                    $role_sub_menu->rsm_update = $update;
                                    $role_sub_menu->rsm_destroy = $delete;
                                    $role_sub_menu->rsm_view = $view;
                                    $role_sub_menu->save();
                                }
                            }
                        }
                    }
                }
            }

            return redirect()->route($this->default_route)->with('message', $this->successMessage('Role menus has been updated. Please end your session to see the changes.'));
        }
        catch(Exception $e)
        {
            return redirect()->route($this->default_route)->with('message', $this->dangerMessage());
        }
    }

    public function create(Request $request)
    {
        $inputs = $request->validate([
            'detail' => 'required|string|unique:tbl_roles,rl_detail',
            'level' => 'numeric|nullable',
        ]);

        try
        {
            // 3 = Generate menu id
            $id = $this->generateID(1);

            $role = new Roles();
            $role->rl_id = $id;
            $role->rl_detail = $inputs['detail'];
            $role->rl_level = $inputs['level'];
            $role->save();

            return redirect()->route($this->default_route)->with('message', $this->successMessage());
        }
        catch(Exception $e)
        {
            return redirect()->route($this->default_route)->with('message', $this->dangerMessage());
        }
    }

    public function update(Request $request)
    {
        $inputs = $request->validate([
            'detail' => 'required|string',
            'level' => 'numeric|nullable',
            'id' => 'required|string',
        ]);

        try
        {
            // Validate role
            $role = Roles::whereRaw('md5(rl_id) = ?', $inputs['id'])->where('rl_deleted', 0)->first();
            if(!$role)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            // Save
            $role->rl_detail = $inputs['detail'];
            $role->rl_level = $inputs['level'];
            $role->save();

            return redirect()->route($this->default_route)->with('message', $this->successMessage('Record has been updated.'));
        }
        catch(Exception $e)
        {
            return redirect()->route($this->default_route)->with('message', $this->dangerMessage());
        }
    }

    public function destroy(Request $request)
    {
        $inputs = $request->validate([
            'delete' => 'required',
        ]);

        try
        {
            $role = Roles::where('rl_deleted', 0)->whereRaw('md5(rl_id) = ?', $inputs['delete'])->first();
            if(!$role)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            $role->rl_deleted = 1;
            $role->save();

            return redirect()->route($this->default_route)->with('message', $this->successMessage('Record has been deleted.'));
        }
        catch(Exception $e)
        {
            return redirect()->route($this->default_route)->with('message', $this->dangerMessage());
        }
    }

    public function render(string $page, array $records = [], string $search = '')
    {
        try
        {
            $data = [
                's_menu' => $this->root,
                's_submenu' => $this->getSubMenu($this->root, $page, 'rl'),
                'records' => $records,
                'search' => $search,
            ];

            return view('pages.roles.'.$page, $data);
        }
        catch(Exception $e)
        {
            return redirect()->route('dashboard')->with('message', $this->dangerMessage());
        }
    }
}
