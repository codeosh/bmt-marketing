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

        if (auth::check() && auth::user()->role === 'admin') {
            $quotation = QuotationCustomer::latest()->paginate(100);
            return view('pages.quotation', compact('quotation'));
        } else {
            return view('user-pages.quotation');
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
        $request->validate([
            'customer_name' => 'required|string',
            'address' => 'required|string',
            'contact' => 'required|string|max:20',
            'nos' => 'required|string|unique:tbl_customers,nos',
            'quantity.*' => 'required|integer',
            'unit.*' => 'required|string',
            'item_name.*' => 'required|string',
            'unit_price.*' => 'required|numeric',
            'line_amount.*' => 'required|numeric',
            'terms' => 'required|string',
            'quotation_no' => 'required|integer|unique:tbl_items,quotation_no',
        ]);

        DB::transaction(function () use ($request) {
            // 🔹 1️⃣ Save Customer First
            $customer = QuotationCustomer::create([
                'nos' => $request->nos,
                'customer_name' => $request->customer_name,
                'address' => $request->address,
                'contact' => $request->contact,
            ]);

            // 🔹 2️⃣ Save Items (Loop Through Items)
            foreach ($request->quantity as $index => $qty) {
                QuotationItem::create([
                    'customer_id' => $customer->id,
                    'quantity' => $qty,
                    'unit' => $request->unit[$index],
                    'item_name' => $request->item_name[$index],
                    'unit_price' => $request->unit_price[$index],
                    'line_amount' => $request->line_amount[$index],
                    'attn' => $request->attn ?? null,
                    'date' => now(),
                    'terms' => $request->terms,
                    'quotation_no' => $request->quotation_no,
                ]);
            }
        });

        return response()->json(['success' => 'Customer and items saved successfully']);
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
