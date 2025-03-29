<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProspectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (auth::check() && auth::user()->role === 'admin') {
            $companies = Company::paginate(10);

            return view('pages.prospects', compact('companies'));
        } else {
            return view('user-pages.prospects');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

        return redirect()->route('admin-prospects.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $company->update($request->all());

        return redirect()->route('admin-prospects.index')
            ->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
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
}
