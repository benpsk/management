<?php

namespace App\Http\Controllers\Employee;

use App\Exports\EmployeeExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestEmployee;
use App\Models\Company\Company;
use App\Models\Employee\Employee;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:gate')->except(['index', 'show', 'searchData']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::query()->where('status', 1)->orderBy('created_at', 'desc')->paginate(10);

        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $companies = Company::where('status', 1)->orderBy('created_at', 'desc')->get();

        return view('employee.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestEmployee $request)
    {
        $input = $request->validated();

        $emp = new Employee();
        $emp->first_name = $input['first_name'];
        $emp->last_name = $input['last_name'];
        $emp->company_id = $request->company_id;
        $emp->department = $input['department'];
        $emp->email = $input['email'];
        $emp->phone = $input['phone'];
        $emp->staff_id = $input['staff_id'];
        $emp->address = $input['address'];
        $emp->save();

        return redirect()->route('employee.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::where('id', $id)->first();
        return view('employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::where('id', $id)->first();

        $companies = Company::where('status', 1)->orderBy('created_at', 'desc')->get();

        return view('employee.edit', compact('employee', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestEmployee $request, $id)
    {

        $input = $request->validated();

        $emp = Employee::where('id', $id)->first();


        $emp->first_name = $input['first_name'];
        $emp->last_name = $input['last_name'];
        $emp->company_id = $request->company_id;
        $emp->department = $input['department'];
        $emp->email = $input['email'];
        $emp->phone = $input['phone'];
        $emp->staff_id = $input['staff_id'];
        $emp->address = $input['address'];


        $dirty = $emp->getDirty();

        if (count($dirty) > 0) {
            $emp->save();
        }
        return redirect()->route('employee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emp = Employee::where('id', $id)->first();

        $emp->status = 0;
        $emp->save();
        return redirect()->route('employee.index');
    }

    public function searchData(Request $request)
    {
        $search = trim($request->search);
        $employees = Employee::join('companies', 'employees.company_id', '=', 'companies.id')
            ->select('employees.*', 'companies.name')
            ->where('employees.status', 1)
            ->where('employees.first_name', 'like', '%' . $search . '%')
            ->orWhere('employees.last_name', 'like', '%' . $search . '%')
            ->orWhereRaw("concat(first_name, ' ', last_name) like '%$search%' ")
            ->orWhere('employees.department', 'like', '%' . $search . '%')
            ->orWhere('employees.staff_id', 'like', '%' . $search . '%')
            ->orWhere('companies.name', 'like', '%' . $search . '%')
            ->orderBy('employees.created_at', 'desc')
            ->paginate(10);

        return view('employee.index', compact('employees', 'search'));
    }

    public function download(Request $request)
    {
        $search = $request->search;
        $filename = 'company_export_' . Str::uuid() . '.xlsx';
        Excel::store(new EmployeeExport($search), "public/export/$filename");
        return response()->json(['file' => asset("export/$filename")]);
    }
}
