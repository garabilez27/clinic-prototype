<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Values;

class ValueController extends Controller
{
    private $root = 'sttng';
    private $default_route = 'val.index';

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
        $values = Values::whereRaw('val_for like ?', '%'.$search.'%');

        // Generate data
        $data = [
            'paginate' => $values->paginate(),
            'start' => isset($request['page']) ? (($request['page'] * $values->paginate()->total()) != 0 ? $request['page'] * $values->paginate()->total() : 1) : 1,
            'count' => $values->paginate()->total(),
            'max' => $values->count(),
            'values' => $values->get(),
        ];

        return $this->render('index', $data, $search);
    }

    public function create(Request $request)
    {
        $inputs = $request->validate([
            'prefix' => 'required|string|unique:tbl_values,val_prefix',
            'description' => 'required|string',
        ]);

        try
        {
            $value = new Values();
            $value->val_prefix = $inputs['prefix'];
            $value->val_for = $inputs['description'];
            $value->save();

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
            'description' => 'required|string',
            'id' => 'required|string',
        ]);

        try
        {
            // Validate value
            $value = Values::whereRaw('md5(val_id) = ?', $inputs['id'])->first();
            if(!$value)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            // Save
            $value->val_prefix = $inputs['prefix'];
            $value->val_for = $inputs['description'];
            $value->save();

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
            $value = Values::whereRaw('md5(val_id) = ?', $inputs['delete'])->first();
            if(!$value)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            $value->delete();

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
                's_submenu' => $this->getSubMenu($this->root, $page, 'val'),
                'records' => $records,
                'search' => $search,
            ];

            return view('pages.values.'.$page, $data);
        }
        catch(Exception $e)
        {
            return redirect()->route('dashboard')->with('message', $this->dangerMessage());
        }
    }
}
