<?php

namespace App\Http\Controllers;

use App\Models\PostTemplate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.postTemplate');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'selectBulletin' => 'required|string|max:255',
            'itemName' => 'required|string|max:255',
            'itemDescription' => 'required|string',
        ]);
        try {
            DB::beginTransaction();

            PostTemplate::create([
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
}
