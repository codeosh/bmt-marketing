<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        //
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
                'content' => $content->content // Assuming 'description' holds the content
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
        //
    }
}
