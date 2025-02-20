@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Quotation')

@section('content')
<div class="d-flex h-100 w-100 gap-2 p-1">

    <div class="d-flex flex-column gap-2">
        {{-- Side List --}}
        <div class="border w-100 rounded-bottom p-3 d-flex flex-column gap-3" style="height:80vh;">
            <div class="h-100 overflow-auto custom-scrollbar">
                <table class="table table-sm table-hover text-center" id="quotationTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Nos.</th>
                            <th scope="col">Customer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quotation as $quotations)
                            <tr class="quote-row" data-id="{{ $quotations->id }}">
                                <td>{{ $quotations->nos }}</td>
                                <td class="text-start">{{ $quotations->customer_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

        </div>
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $quotation->links('pagination::bootstrap-5') }}
                </div>
    </div>
               
        {{-- Buttons --}}
        <div class="d-flex justify-content-evenly">

            {{-- Add New --}}
            <button type="submit" id="new-Quote" form="customerForm" class="btn btn-success addButton" style="font-size:0.6rem; width:80px; border-radius:3px;">
                    <i class="fa-solid fa-floppy-disk" id="addIcon"></i>
                    <span id="buttonText-Quote">{{ __('Add new') }}</span>
                    <span id="buttonSpinner-Quote" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>


            {{-- Save--}}
            <button type="submit" id="saveBtn-customers" form="customerForm" class="btn btn-info saveButton" style="font-size:0.6rem; width:80px; border-radius:3px;">
                    <i class="fa-solid fa-floppy-disk" id="saveIcon"></i>
                    <span id="buttonText-customer">{{ __('Save') }}</span>
                    <span id="buttonSpinner-customer" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>


             {{-- Delete --}}
             <button type="button" class="btn btn-danger saveButton" data-bs-toggle="modal"
             style="font-size:0.6rem; width:80px; border-radius:3px;">
             <i class="fa-solid fa-trash"></i> Delete
            </button>
       
        </div>
       
    </div>
    
    <div class="h-100 w-100 d-flex flex-column gap-2">
            {{-- Content --}}
            <div class=" w-100 border rounded p-3 overflow-auto custom-scrollbar" style="height:80vh;">

                <div class="text-center">
                    <h4 class=" fw-bolder">PRICE&nbsp;&nbsp; QUOTATION</h4>
                </div>

                {{-- Customer Details Container--}}
                <div class="d-flex justify-content-between">

                    <div class="customerDetails d-flex flex-column gap-2"style="font-size:0.8rem;flex-basis:70%;">
                        <form class="customerForm">
                            @csrf
                        {{-- Customer Name --}}
                        <div class="customerName d-flex w-100 align-items-center">
                            <label for="customerName"class="me-2">Customer&nbsp; :</label>
                            <input type="text" id="customerName" class="flex-grow-1" style="border: none; outline: none;">
                        </div>

                        {{-- Customer Address --}}
                        <div class="customerAddress d-flex w-100 align-items-center">
                            <label for="customerAddress" class="me-2">Address&nbsp; &nbsp; &nbsp;:</label>
                            <input type="text" id="customerAddress" class="flex-grow-1" style="border: none; outline: none;">
                        </div>

                        {{-- Customer Contact Number --}}
                        <div class="customerContact w-100 d-flex w-100 align-items-center">
                            <label for="customerContact" class="me-2">Contact&nbsp; &nbsp; &nbsp;:</label>
                            <input type="text" id="customerContact" class="flex-grow-1" style="border: none; outline: none;">
                        </div>
                        {{-- ATN --}}
                        <div class="customerATN d-flex w-100 align-items-center">
                            <label for="customerATN" class="me-2">ATN &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</label>
                            <input type="text" id="customerATN" class="flex-grow-1" style="border: none; outline: none;">
                        </div>

                    </div>

                    {{-- No. & Date Container --}}
                    <div class="d-flex flex-column gap-2" style="font-size:0.8rem;flex-basis:30%;">
                        {{-- No. --}}
                        <div class="customerQNumber">
                            <label for="customerQNumber" class="me-2">Q No&nbsp; &nbsp; &nbsp;:</label>
                            <input type="text" id="customerQNumber" value="{{ $newQuotationNo}}" style="border: none; outline: none; width:130px; font-size:1.5rem; font-weight:bold;" readonly>
                        </div>

                        {{-- Date Issued--}}
                        <div class="customerDateIssued">
                            <label for="customerDateIssued" class="me-2">Date&nbsp; &nbsp; &nbsp;:</label>
                            <input type="text" id="customerDateIssued" value="{{ now()->toDateString() }}" style="border: none; outline: none; width:130px;" readonly>
                        </div>

                        {{-- Terms --}}
                        <div class="customerTerms">
                            <label for="customerTerms" class="me-2">Terms&nbsp; &nbsp;:</label>
                            <input type="text" id="customerTerms" style="border: none; outline: none; width:130px;">
                        </div>
                    </div>

                </div>

                {{-- Quote --}}
                <div class="mt-3">
                    <p class="fst-italic" style="font-size:0.8rem;">" We are happy to quote you the following items you requested below..."</p>
                </div>

                
                {{-- Table --}}
                <div class="border w-100 mt-2">
                    <table class="table table-sm text-center" id="items-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Quantity</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Item Name & Description</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Line Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Row Template -->
                            {{-- row 0 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" class="w-100 quantity" name="items[0][quantity]" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[0][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[0][item_name]" class="w-100 text-start item-name" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[0][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[0][line_amount]" class="w-100 line-amount" disabled>
                                </td>
                                
                            </tr>
                            
                            {{-- row 1 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[1][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[1][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[1][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[1][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[1][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 2 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[2][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[2][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[2][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[2][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[2][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 3 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[3][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[3][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[3][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[3][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[3][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 4 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[4][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[4][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[4][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[4][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[4][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 5 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[5][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[5][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[5][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[5][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[5][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 6 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[6][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[6][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[6][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[6][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[6][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 7 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[7][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[7][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[7][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[7][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[7][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 8 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[8][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[8][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[8][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[8][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[8][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 9 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[9][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[9][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[9][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[9][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[9][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 10 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[10][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[10][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[10][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[10][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[10][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 11 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[11][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[11][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[11][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[11][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[11][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 12 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[12][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[12][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[12][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[12][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[12][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 13 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[13][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[13][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[13][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[13][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[13][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 14 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[14][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[14][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[14][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[14][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[14][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 15 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[15][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[15][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[15][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[15][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[15][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 16 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[16][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[16][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>
                                
                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[16][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[16][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[16][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            {{-- row 17 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[17][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[17][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[17][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[17][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[17][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>
                            {{-- row 18 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[18][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[18][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[18][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[18][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[18][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>
                            {{-- row 19 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[19][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100" name="items[19][unit]">
                                        <option value="" selected></option>
                                        <option value="PCS">PCS</option>
                                        <option value="SET">SET</option>
                                        <option value="BOX">BOX</option>
                                        <option value="CTN">CTN</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[19][item_name]" class="w-100 text-start item-name">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[19][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[19][line_amount]" class="w-100 line-amount" disabled>
                                </td>

                            </tr>

                            <!-- Total Row -->
                            <tr class="bg-black" style="border: 1px solid black">
                                <td colspan="3" class="p-0 m-0">
                                    <span></span>
                                </td>
                                
                                <td class="text-end p-1 bg-secondary text-white fw-bold" style=" border-right:1px solid black;">
                                    <label class="me-4  self-align-center" style="margin-top: 0.2rem">Total:</label>
                                </td>
                                <td class="p-1 bg-secondary">
                                    <div class="w-100 h-100 bg-secondary">
                                        <input id="totalAmount" class="w-100 text-white fw-bold border-0 bg-transparent p-0 text-center" type="text" value="####" disabled>
                                    </div>
                                </td>
                                
                            </tr>  
                            </form>
                                                        
                        </tbody>
                    </table>

                </div>

                <div class="footer d-flex gap-2 w-100">
                        {{-- Terms & Condition Container --}}
                        <div class="mt-5 mb-5 h-100 w-50">
                            <div class="header bg-secondary d-flex align-items-center justify-content-evenly" style="height:30px;">
                                <small class="text-white">Terms & Condition</small>
                                <small class="text-white">Remarks & Special Notes</small>
                            </div>  

                            <div class="h-100 w-100 d-flex" style="border:1px solid black;">
                                
                                <div class="w-50 p-2" style="border-right:1px solid black;">
                                    <div class="row">
                                        <div class="col">
                                            <span class="fw-bolder"  style="font-size:0.8rem;">Condition:</span>
                                            <span  style="font-size:0.8rem;">All Brand New 1 Year on</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <span class="fw-bolder"  style="font-size:0.8rem;">Warranty:</span>
                                            <span  style="font-size:0.8rem;">All</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <span class="fw-bolder"  style="font-size:0.8rem;">VAT (12%):</span>
                                            <span  style="font-size:0.8rem;">Major Parts</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <span class="fw-bolder"  style="font-size:0.8rem;">Availability:</span>
                                            <span  style="font-size:0.8rem;">Excluded</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <span class="fw-bolder"  style="font-size:0.8rem;">RD:</span>
                                            <span  style="font-size:0.8rem;">Onstock</span>
                                        </div>
                                    </div>

                                </div>

                                {{-- Remarks & Special Notes --}}
                                <div class="border w-50 p-2">
                                    <div class="row">
                                        <div class="col">
                                            <span class="fw-bolder"  style="font-size:0.8rem;">Price Effectivity:</span>
                                            <span  style="font-size:0.8rem;">1 Week</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 w-50 d-flex flex-column align-items-center justify-content-center" style="height:190px">
                            <div class="fw-bold" style="font-size: 0.8rem; margin-right:8rem;">
                                <p>Quote & Prepared by:</p>
                            </div>
                            <div class="d-flex flex-column text-center">
                                <p class="m-0 p-0 fw-bold" style="font-size: 1.2rem">Mr. Sales Executive</p>
                                <p class="m-0 p-0" style="font-size: 0.8rem">Tech/Sales Representative</p>
                                <p class="m-0 p-0" style="font-size: 0.7rem;">09225282333</p>
                                <p class="m-0 p-0" style="font-size: 0.7rem">0988626001</p>
                            </div>
                            
                        </div>
                </div>  
            </div>    

            <div class="d-flex align-self-end gap-2">
                {{-- Print --}}
                <button type="button" class="btn btn-success addButton" data-bs-toggle="modal"
                    style="font-size:0.6rem; width:80px; border-radius:3px;">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </button>
                {{-- Edit --}}
                <button type="button" class="btn btn-secondary addButton" data-bs-toggle="modal"
                    style="font-size:0.6rem; width:80px; border-radius:3px;">
                    <i class="fa-solid fa-print"></i> Print
                </button>

            </div>
          

    </div>
    
</div>
<script src="{{ asset('js/quotation.js') }}"></script>

@endsection