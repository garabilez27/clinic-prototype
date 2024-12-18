<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Patients;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    private $root = 'ptt';
    private $default_route = 'ptt.index';

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
        $patients = Patients::where('ptt_deleted', 0);
        if(!empty($inputs['search']))
        {
            $patients = Patients::where('ptt_deleted', 0)->whereRaw('ptt_lname like ?', '%'.$search.'%');
        }

        // Generate data
        $data = [
            'paginate' => $patients->paginate(),
            'start' => isset($request['page']) ? (($request['page'] * $patients->paginate()->total()) != 0 ? $request['page'] * $patients->paginate()->total() : 1) : 1,
            'count' => $patients->paginate()->total(),
            'max' => $patients->count(),
            'patients' => $patients->get(),
        ];

        return $this->render('index', $data, $search);
    }

    public function create(Request $request)
    {
        $inputs = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email|unique:tbl_patients,ptt_email',
            'phone' => 'numeric|nullable',
        ]);

        try
        {
            // 3 = Generate menu id
            $id = $this->generateID(5);

            $patient = new Patients();
            $patient->ptt_id = $id;
            $patient->ptt_fname = $inputs['fname'];
            $patient->ptt_lname = $inputs['lname'];
            $patient->ptt_email = $inputs['email'];
            $patient->ptt_phone = $inputs['phone'];
            $patient->ptt_password = Hash::make('12345678');
            $patient->save();

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
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'numeric|nullable',
            'id' => 'required|string',
        ]);

        try
        {
            // Validate email
            $patient = Patients::whereRaw('md5(ptt_id) = ?', $inputs['id'])->where('ptt_deleted', 0)->first();
            if(!$patient)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            // Save
            $patient->ptt_fname = $inputs['fname'];
            $patient->ptt_lname = $inputs['fname'];
            $patient->ptt_email = $inputs['email'];
            $patient->ptt_phone = $inputs['phone'];
            $patient->save();

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
            $patients = Patients::where('ptt_deleted', 0)->whereRaw('md5(ptt_id) = ?', $inputs['delete'])->first();
            if(!$patients)
            {
                return redirect()->route($this->default_route)->with('message', $this->warningMessage());
            }

            $patients->ptt_deleted = 1;
            $patients->save();

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
                's_submenu' => $this->getSubMenu($this->root, $page),
                'records' => $records,
                'search' => $search,
            ];

            return view('pages.patients.'.$page, $data);
        }
        catch(Exception $e)
        {
            return redirect()->route('dashboard')->with('message', $this->dangerMessage());
        }
    }
}
