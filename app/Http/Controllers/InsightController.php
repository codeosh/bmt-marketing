<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Insight;
use Illuminate\Support\Facades\DB;
use Exception;

class InsightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        if (auth::check() && auth::user()->role === 'admin') {
            return view('pages.insight');
        } else {
            return view('user-pages.insight');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'selectBulletin' => 'required|string|max:255',
            'itemName' => 'required|string|max:255',
            'itemDescription' => 'required|string',
        ]);
        try {
            DB::beginTransaction();

            Insight::create([
                'kind' => $validatedData['selectBulletin'],
                'pname' => $validatedData['itemName'],
                'content' => $validatedData['itemDescription'],
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Added Successfully!']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding.',
                'error_details' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ], 500);
        }
    }

    public function getAdminInsight()
    {
        return response()->json(Insight::all());
    }
    public function getUserInsight()
    {

        $insight = Insight::all();
        return response()->json($insight);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validatedData = $request->validate([
            'pname' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $bulletin = Insight::findOrFail($id);
            $bulletin->update([
                'pname' => $validatedData['pname'],
                'content' => $validatedData['content'],
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Updated successfully!']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating.',
                'error_details' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $bulletin = Insight::findOrFail($id);
        $bulletin->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully!']);
    }
}
