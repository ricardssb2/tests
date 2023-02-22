<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('admin.company.company', compact('companies'));
    }

    public function create(Request $request)
    {
        Company::create([
            'name' => $request->name,
            'owner' => $request->owner,
            'phone_number' => $request->phone_number
        ]);
        return redirect('/companies');
    }

    public function store(Request $request)
{
    $company = new Company();
    $company->name = $request->input('name');
    $company->owner = $request->input('owner');
    $company->phone_number = $request->input('phone_number');
    $company->save();

    return redirect()->route('company.index');
}

public function destroy($id)
{
    $company = Company::findOrFail($id);
    $company->delete();

    return redirect()->route('company.index')->with('success', 'Company deleted successfully');
}
}