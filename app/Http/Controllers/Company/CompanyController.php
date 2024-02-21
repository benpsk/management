<?php

namespace App\Http\Controllers\Company;

use App\Events\CompanyCreated;
use App\Exports\CompanyExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestCompany;
use App\Jobs\ProcessCompany;
use App\Models\Company\Company;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
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
        $companies = Company::where('status', 1)->orderBy('created_at', 'desc')->paginate(10);
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestCompany $request)
    {
        $input = $request->validated();

        $company = new Company();
        $company->name = $input['name'];
        $company->email = $input['email'];
        $company->address = $input['address'];
        $company->save();

        ProcessCompany::dispatch($company);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::where('id', $id)->first();
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::where('id', $id)->first();

        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestCompany $request, $id)
    {
        $input = $request->validated();
        $company = Company::where('id', $id)->first();

        $company->name = $input['name'];
        $company->email = $input['email'];
        $company->address = $input['address'];

        $dirty = $company->getDirty();

        if (count($dirty) > 0) {
            $company->save();
        }
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::where('id', $id)->first();
        $company->status = 0;
        $company->save();
    }

    public function searchData(Request $request)
    {
        $search = trim($request->search);

        $companies = Company::where('status', 1)
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('company.index', compact('companies'));
    }


    public function download(Request $request)
    {
        $search = $request->search;

        return (new CompanyExport($search))->download('company-data.xlsx');
    }
}
