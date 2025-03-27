<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Password;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CompaniesImport;
use Illuminate\Support\Facades\DB; // Import DB facade

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(10);
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {

        $request->merge([
            'contacted' => $request->has('contacted') ? 1 : 0,
            'to_recontact' => $request->has('to_recontact') ? 1 : 0,
            'to_email' => $request->has('to_email') ? 1 : 0,
            'to_propose' => $request->has('to_propose') ? 1 : 0,
            'visited' => $request->has('visited') ? 1 : 0,
            'ec_ordered1' => $request->has('ec_ordered1') ? 1 : 0,
            'problematic' => $request->has('problematic') ? 1 : 0,
            'acct_active' => $request->has('acct_active') ? 1 : 0,
        ]);

        Company::create($request->all());

        return redirect()->route('companies.index')
                         ->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $company->update($request->all());

        return redirect()->route('companies.index')
                         ->with('success', 'Company updated successfully');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')
                         ->with('success', 'Company deleted successfully');
    }

    public function deleteSelected(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected_ids'));

        if (empty($selectedIds)) {
            return redirect()->route('companies.index')
                             ->with('error', 'No companies selected for deletion.');
        }

        Company::whereIn('id', $selectedIds)->delete();

        return redirect()->route('companies.index')
                         ->with('success', 'Selected companies deleted successfully.');
    }

    

    public function browseExcel()
    {
        return view('companies.browse-excel');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new CompaniesImport, $request->file('file'));

        return redirect()->route('companies.index')
                         ->with('success', 'Companies imported successfully.');
    }

    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $storedPassword = Password::first()->password;

        if ($request->password === $storedPassword) {
            $request->session()->put('password_verified', true);
            return response()->json(['success' => true, 'redirect_url' => route('companies.settings')]);
        } else {
            return response()->json(['success' => false, 'message' => 'Incorrect Password!'], 401);
        }
    }

    public function reset()
    {
        try {
            DB::table('companies')->delete();
            return response()->json(['success' => true, 'message' => 'All data has been reset successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while resetting the data.']);
        }
    }

    public function settings(Request $request)
    {
        if (!$request->session()->has('password_verified')) {
            return redirect()->route('companies.index')->with('error', 'You must enter the correct password to access the settings page.');
        }

        return view('companies.settings');
    }
}