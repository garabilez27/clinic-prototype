<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\SubMenus;
use App\Models\Menus;

class SubMenuController extends Controller
{
    private $root = 'sttng';
    private $default_route = 'sbmn.index';

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

        // get sub menu list
        $search = isset($inputs['search']) ? $inputs['search'] : '';
        $sub_menus = SubMenus::where('sbmn_deleted', 0)->where('sbmn_active', 1);
        if(!empty($inputs['search']))
        {
            $sub_menus = SubMenus::where('sbmn_deleted', 0)->whereRaw('sbmn_detail like ?', '%'.$search.'%');
        }

        // Get menu list
        $menus = Menus::where('mn_deleted', 0)->get();

        // Generate data
        $data = [
            'paginate' => $sub_menus->paginate(),
            'start' => isset($request['page']) ? (($request['page'] * $sub_menus->paginate()->total()) != 0 ? $request['page'] * $sub_menus->paginate()->total() : 1) : 1,
            'count' => $sub_menus->paginate()->total(),
            'max' => $sub_menus->count(),
            'sub_menus' => $sub_menus->get(),
            'menus' => $menus,
        ];

        return $this->render('index', $data, $search);
    }

    public function create(Request $request)
    {
        $inputs = $request->validate([
            'for' => 'required|string',
            'class' => 'string|nullable',
            'detail' => 'required|string',
            'icon' => 'string|nullable',
            'reference' => 'required|unique:tbl_sub_menus,sbmn_reference',
            'sequence' => 'numeric|nullable',
        ]);

        try
        {
            // Validate selected menu
            $menu = Menus::whereRaw('md5(mn_id) = ?', $inputs['for'])->where('mn_deleted', 0)->first();
            if(!$menu)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            // 4 = Generate sub menu id
            $id = $this->generateID(4);

            $sub = new SubMenus();
            $sub->sbmn_id = $id;
            $sub->sbmn_class = $inputs['class'];
            $sub->sbmn_detail = $inputs['detail'];
            $sub->sbmn_icon = $inputs['icon'];
            $sub->sbmn_reference = $inputs['reference'];
            $sub->sbmn_sequence = $inputs['sequence'];
            $sub->mn_id = $menu->mn_id;
            $sub->save();

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
            'for' => 'required|string',
            'class' => 'string|nullable',
            'detail' => 'required|string',
            'icon' => 'string|nullable',
            'reference' => 'required',
            'sequence' => 'numeric|nullable',
            'id' => 'required|string',
        ]);

        try
        {
            // Check reference if duplicate
            $menu_count = SubMenus::whereRaw('md5(sbmn_id) <> ?', $inputs['id'])->where('sbmn_reference', $inputs['reference'])->count();
            if($menu_count > 0)
            {
                return redirect()->back()->withErrors(['reference' => 'The reference has already been taken.']);
            }

            // Validate selected menu
            $menu = Menus::whereRaw('md5(mn_id) = ?', $inputs['for'])->where('mn_deleted', 0)->first();
            if(!$menu)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            // Validate sub menu
            $sub = SubMenus::whereRaw('md5(sbmn_id) = ?', $inputs['id'])->where('sbmn_deleted', 0)->first();
            if(!$sub)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            // Save record
            $sub->sbmn_class = $inputs['class'];
            $sub->sbmn_detail = $inputs['detail'];
            $sub->sbmn_icon = $inputs['icon'];
            $sub->sbmn_reference = $inputs['reference'];
            $sub->sbmn_sequence = $inputs['sequence'];
            $sub->mn_id = $menu->mn_id;
            $sub->save();

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
            $menu = SubMenus::where('sbmn_deleted', 0)->whereRaw('md5(sbmn_id) = ?', $inputs['delete'])->first();
            if(!$menu)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            $menu->sbmn_deleted = 1;
            $menu->save();

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
                's_submenu' => $this->getSubMenu($this->root, $page, 'sbmn'),
                'records' => $records,
                'search' => $search,
            ];

            return view('pages.subs.'.$page, $data);
        }
        catch(Exception $e)
        {
            return redirect()->route('dashboard')->with('message', $this->dangerMessage());
        }
    }
}
