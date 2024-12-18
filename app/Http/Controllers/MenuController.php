<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Menus;

class MenuController extends Controller
{
    private $root = 'sttng';
    private $default_route = 'mn.index';

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
        $menus = Menus::where('mn_deleted', 0);
        if(!empty($inputs['search']))
        {
            $menus = Menus::where('mn_deleted', 0)->whereRaw('mn_detail like ?', '%'.$search.'%');
        }

        // Generate data
        $data = [
            'paginate' => $menus->paginate(),
            'start' => isset($request['page']) ? (($request['page'] * $menus->paginate()->total()) != 0 ? $request['page'] * $menus->paginate()->total() : 1) : 1,
            'count' => $menus->paginate()->total(),
            'max' => $menus->count(),
            'menus' => $menus->get(),
        ];

        return $this->render('index', $data, $search);
    }

    public function create(Request $request)
    {
        $inputs = $request->validate([
            'prefix' => 'required|string',
            'detail' => 'required|string',
            'icon' => 'required|string',
            'reference' => 'required|unique:tbl_menus,mn_reference',
            'branched' => 'required|numeric',
            'sequence' => 'numeric|nullable',
            'action' => 'numeric|required',
        ]);

        try
        {
            // 3 = Generate menu id
            $id = $this->generateID(3);

            $menu = new Menus();
            $menu->mn_id = $id;
            $menu->mn_prefix = $inputs['prefix'];
            $menu->mn_detail = $inputs['detail'];
            $menu->mn_icon = $inputs['icon'];
            $menu->mn_reference = $inputs['reference'];
            $menu->mn_branched = $inputs['branched'];
            $menu->mn_sequence = $inputs['sequence'];
            $menu->mn_has_actions = $inputs['action'];
            $menu->save();

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
            'prefix' => 'required|string',
            'detail' => 'required|string',
            'icon' => 'required|string',
            'reference' => 'required',
            'branched' => 'required|numeric',
            'sequence' => 'numeric|nullable',
            'id' =>'string|required',
            'action' => 'numeric|required'
        ]);

        try
        {
            // Check reference if duplicate
            $menu_count = Menus::whereRaw('md5(mn_id) <> ?', $inputs['id'])->where('mn_reference', $inputs['reference'])->count();
            if($menu_count > 0)
            {
                return redirect()->back()->withErrors(['reference' => 'The reference has already been taken.']);
            }

            // Validate menu
            $menu = Menus::whereRaw('md5(mn_id) = ?', $inputs['id'])->where('mn_deleted', 0)->first();
            if(!$menu)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            // Save record
            $menu->mn_prefix = $inputs['prefix'];
            $menu->mn_detail = $inputs['detail'];
            $menu->mn_icon = $inputs['icon'];
            $menu->mn_reference = $inputs['reference'];
            $menu->mn_branched = $inputs['branched'];
            $menu->mn_sequence = $inputs['sequence'];
            $menu->mn_has_actions = $inputs['action'];
            $menu->save();

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
            $menu = Menus::where('mn_deleted', 0)->whereRaw('md5(mn_id) = ?', $inputs['delete'])->first();
            if(!$menu)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            $menu->mn_deleted = 1;
            $menu->save();

            return redirect()->route($this->default_route)->with('message', $this->successMessage('Record has been deleted.'));
        }
        catch(Exception $e)
        {
            return redirect()->route($this->default_route)->with('message', $this->dangerMessage());
        }
    }

    public function render(string $page, mixed $records = [], string $search = '')
    {
        try
        {
            $data = [
                's_menu' => $this->root,
                's_submenu' => $this->getSubMenu($this->root, $page, 'mn'),
                'records' => $records,
                'search' => $search,
            ];

            return view('pages.menus.'.$page, $data);
        }
        catch(Exception $e)
        {
            return redirect()->route('dashboard')->with('message', $this->dangerMessage());
        }
    }
}
