<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BulletinController extends Controller
{
    public function index()
    {
        return view('pages.bulletin');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'selectBulletin' => 'nullable|string|max:255',
            'itemName' => 'nullable|string|max:255',
            'itemDescription' => 'nullable|string|max:255',
        ]);
        try {
            DB::beginTransaction();

            Bulletin::create([
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
