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

        if (auth::check() && auth::user()->role === 'admin') {

            return view('pages.quotation', compact('quotation'));
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
