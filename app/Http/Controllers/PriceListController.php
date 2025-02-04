<?php

namespace App\Http\Controllers;

use App\Models\Pricelist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PriceListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Fetch pname where kind is 'template'
        $pnamesTemplate = \App\Models\Pricelist::where('kind', 'template')->pluck('pname', 'id');

        // Fetch pname where kind is 'bulletin'
        $pnamesBulletin = \App\Models\Pricelist::where('kind', 'bulletin')->pluck('pname', 'id');

        return view('pages.priceList', compact('pnamesTemplate', 'pnamesBulletin'));
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
        $validatedData = $request->validate([
            'selectBulletin' => 'nullable|string|max:255',
            'itemName' => 'nullable|string|max:255',
            'itemDescription' => 'nullable|string|max:255',
        ]);
        try {
            DB::beginTransaction();

            Pricelist::create([
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the content based on the id
        $content = \App\Models\Pricelist::where('id', $id)->first();

        if ($content) {
            return response()->json([
                'content' => $content->content,
                'pname' => $content->pname
            ]);
        } else {
            return response()->json([
                'content' => 'Content not found.'
            ], 404);
        }
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find and delete the record
        $pricelist = Pricelist::findOrFail($id);
        $pricelist->delete();

        // Return a JSON response for AJAX
        return response()->json(['success' => true, 'message' => 'Successfully deleted.']);
    }
}
