<?php

namespace App\Http\Controllers;

use App\Models\QuotationCustomer;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $quotation = QuotationCustomer::latest()->paginate(100);

        // Get the latest quotation number from the database
        $latestQuotation = QuotationItem::latest('quotation_no')->first();

        // If there's no quotation yet, start from 10001
        $newQuotationNo = $latestQuotation ? $latestQuotation->quotation_no + 1 : 10001;

        if (auth::check() && auth::user()->role === 'admin') {

            return view('pages.quotation', compact('quotation', 'newQuotationNo'));
        } else {
            return view('user-pages.quotation', compact('quotation'));
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
        DB::beginTransaction();

        try {
            // Validate required fields
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'address' => 'nullable|string|max:255',
                'contact' => 'nullable|string|max:20',
                'attn' => 'nullable|string|max:255',
                'terms' => 'nullable|string|max:255',
                'items' => 'required|array',  // Ensure 'items' is an array
            ]);

            // Insert Customer
            $customer = QuotationCustomer::create([
                'nos' => $request->nos ?? null,
                'customer_name' => $request->customer_name,
                'address' => $request->address,
                'contact' => $request->contact,
            ]);

            // Prepare Items (From the 'items' array in the request)
            $items = [];
            foreach ($request->items as $item) {
                $items[] = [
                    'customer_id' => $customer->id,  // Attach the correct customer_id here
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'],
                    'item_name' => $item['item_name'],
                    'unit_price' => $item['unit_price'],
                    'line_amount' => $item['line_amount'],
                    'attn' => $request->attn ?? null,
                    'date' => now(),
                    'terms' => $request->terms ?? '',
                    'quotation_no' => $request->nos ?? null,
                ];
            }

            // Insert all the items at once
            QuotationItem::insert($items);

            DB::commit();

            return response()->json(['success' => 'Quotation saved successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // i-Retrieve niya ag quotation customer record based on the provided ID.
        // The `first()` method is used to get a single record instead of a collection.
        $quotationCustomer = QuotationCustomer::where('id', $id)->first();

        // Retrieve all quotation items linked to this customer using the `customer_id`.
        // The `get()` method retrieves all matching records as a collection.
        $quotationItems = QuotationItem::where('customer_id', $id)->get();

        // If ag customer record is not found, return a JSON response with an error message
        // and an HTTP 404 (Not Found) status code.
        if (!$quotationCustomer) {
            return response()->json(['error' => 'Quotation not found'], 404);
        }

        // ahu ge extract ang first item from the retrieved collection, if available.
        // This is useful if some fields (e.g., attn, date, terms) are common among all items
        // and can be taken from the first entry.
        $firstItem = $quotationItems->first();

        // Return a structured JSON response containing customer details and associated items.
        return response()->json([
            // Customer details, with 'N/A' as a fallback if a field is null.
            'customerContact' => $quotationCustomer->contact ?? 'N/A', // Customer's contact number
            'quotationNo' => $quotationCustomer->nos ?? 'N/A', // Quotation number
            'address' => $quotationCustomer->address ?? 'N/A', // Customer's address
            'customerName' => $quotationCustomer->customer_name ?? 'N/A', // Customer's name

            // Retrieve specific fields from the first item in the collection.
            // If no items exist, these values default to 'N/A' to prevent errors.
            'attn' => $firstItem->attn ?? 'N/A', // Attention (recipient) for the quotation
            'date' => $firstItem->date ?? 'N/A', // Date of the quotation
            'terms' => $firstItem->terms ?? 'N/A', // Payment terms

            // Include the full list of quotation items associated with the customer.
            // This allows the frontend to display all items linked to this quotation.
            'items' => $quotationItems
        ]);
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
        try {
            // Find the quotation customer
            $quotationCustomerDelete = QuotationCustomer::findOrFail($id);

            // Delete all associated items related to this quotation
            QuotationItem::where('customer_id', $id)->delete(); // Ensure quotation_id is the foreign key

            // Delete the quotation customer
            $quotationCustomerDelete->delete();

            return response()->json(['success' => true, 'message' => 'Quotation and items deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete.', 'error' => $e->getMessage()], 500);
        }
    }
}
