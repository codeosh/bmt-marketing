<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\ReplyTemplate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReplyTemplateController extends Controller
{
    public function index()
    {
        return view('pages.replyTemplate');
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

            ReplyTemplate::create([
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

    public function getReplyTemplate()
    {
        return response()->json(ReplyTemplate::all());
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'pname' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $bulletin = ReplyTemplate::findOrFail($id);
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

    public function destroy($id)
    {
        $bulletin = ReplyTemplate::findOrFail($id);
        $bulletin->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully!']);
    }
}
