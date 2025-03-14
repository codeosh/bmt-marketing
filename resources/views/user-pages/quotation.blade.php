@extends('user.user-dashboard')

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
                        <tr class="d-none" id="alertForNoRecordsWhenSearch">
                            <td colspan="2" class="text-center text-danger">No records found</td>
                        </tr>

                        @if ($quotation->isEmpty()) 
                            <tr>
                                <td colspan="2" class="text-center text-danger">No records found</td>
                            </tr>
                        @else
                            @foreach ($quotation as $quotations)                    
                                <tr class="quote-row cursor-pointer" data-id="{{ $quotations->id }}">
                                    <td>{{ $quotations->nos }}</td>
                                    <td class="text-start">{{ $quotations->customer_name }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

        </div>
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $quotation->links('pagination::bootstrap-5') }}
                </div>
    </div>

        {{-- Buttons --}}
        <div class="d-flex justify-content-evenly gap-2">

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
             <button type="button" class="btn btn-danger" id="deleteBtn" data-bs-toggle="modal"
             style="font-size:0.6rem; width:80px; border-radius:3px;">
             <i class="fa-solid fa-trash"></i> Delete
            </button>
       
        </div>
       
    </div>
    
    <div class="h-100 w-100 d-flex flex-column gap-2 ">
            {{-- Content --}}
            <div class="border rounded p-3 overflow-auto custom-scrollbar" style="height: 80vh; max-width:1000px;" id="customerDetailsContainer">

                <div id="detailsForPrint">
                
                {{-- Header Image --}}
                <img src="{{ asset($quotationHeaderAndFooter->header_image) }}" 
                    alt="Header Image" 
                    id="head"
                    class="w-100 img-head" 
                    style="margin-bottom:45px;cursor: pointer;max-height: 127.28px;" 
                    data-bs-toggle="modal" 
                    data-bs-target="#imageModal"
                    data-id="{{ $quotationHeaderAndFooter->id }}" 
                    data-type="header"> 

                <div id="deatailsForHeaderAndFooter">

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
                            <input type="text" id="customerAddress" class="flex-grow-1" style="border: none; outline: none;font-weight: normal;">
                        </div>

                        {{-- Customer Contact Number --}}
                        <div class="customerContact w-100 d-flex w-100 align-items-center">
                            <label for="customerContact" class="me-2">Contact&nbsp; &nbsp; &nbsp;:</label>
                            <input type="text" id="customerContact" class="flex-grow-1" style="border: none; outline: none;font-weight: normal;">
                        </div>
                        {{-- ATTN --}}
                        <div class="customerATN d-flex w-100 align-items-center">
                            <label for="customerATN" class="me-2">ATTN &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :</label>
                            <input type="text" id="customerATN" class="flex-grow-1" style="border: none; outline: none;font-weight: normal;">
                        </div>

                    </div>

                    {{-- No. & Date Container --}}
                    <div class="d-flex flex-column gap-2" style="font-size:0.8rem;flex-basis:30%;">
                        {{-- No. --}}
                        <div class="customerQNumber">
                            <label for="customerQNumber" class="me-2">Q No&nbsp; &nbsp; &nbsp;:</label>
                            <input type="text" id="customerQNumber" value="{{ $newQuotationNo }}" style="border: none; outline: none; width:130px; font-size:1.5rem; font-weight:bold;" readonly>
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
                        <thead class="table-light" >
                            <tr>
                                <th scope="col" style="background-color: rgb(246, 223, 181)!important; border:none">Quantity</th>
                                <th scope="col" style="background-color: rgb(246, 223, 181)!important; border:none">Unit</th>
                                <th scope="col" class="text-start ps-2" style="background-color: rgb(246, 223, 181)!important; border:none">Item Name & Description</th>
                                <th scope="col" style="background-color: rgb(246, 223, 181)!important; border:none">Unit Price</th>
                                <th scope="col" class="text-end" style="background-color: rgb(246, 223, 181)!important; border:none">Line Amount</th>
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
                                    <select class="w-100 unit-select" name="items[0][unit]">
                                        <option value="" selected></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->units }}">{{ $unit->units }}</option>
                                        @endforeach
                                        <option value="add">+ Add New</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[0][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[0][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[0][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>
                                
                            </tr>
                            
                            {{-- row 1 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[1][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100 unit-select" name="items[1][unit]">
                                        <option value="" selected></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->units }}">{{ $unit->units }}</option>
                                        @endforeach
                                        <option value="add">+ Add New</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black; ">
                                    <input type="text" name="items[1][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[1][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[1][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr>

                            {{-- row 2 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[2][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100 unit-select" name="items[2][unit]">
                                        <option value="" selected></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->units }}">{{ $unit->units }}</option>
                                        @endforeach
                                        <option value="add">+ Add New</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[2][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[2][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[2][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr>

                            {{-- row 3 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[3][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100 unit-select" name="items[3][unit]">
                                        <option value="" selected></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->units }}">{{ $unit->units }}</option>
                                        @endforeach
                                        <option value="add">+ Add New</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[3][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[3][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[3][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr>

                            {{-- row 4 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[4][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100 unit-select" name="items[4][unit]">
                                        <option value="" selected></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->units }}">{{ $unit->units }}</option>
                                        @endforeach
                                        <option value="add">+ Add New</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[4][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[4][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[4][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr>

                            {{-- row 5 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[5][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100 unit-select" name="items[5][unit]">
                                        <option value="" selected></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->units }}">{{ $unit->units }}</option>
                                        @endforeach
                                        <option value="add">+ Add New</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[5][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[5][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[5][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr>

                            {{-- row 6 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[6][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100 unit-select" name="items[6][unit]">
                                        <option value="" selected></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->units }}">{{ $unit->units }}</option>
                                        @endforeach
                                        <option value="add">+ Add New</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[6][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[6][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[6][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr>

                            {{-- row 7 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[7][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100 unit-select" name="items[7][unit]">
                                        <option value="" selected></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->units }}">{{ $unit->units }}</option>
                                        @endforeach
                                        <option value="add" id="option">+ Add New</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[7][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[7][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[7][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr>

                            {{-- row 8 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[8][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100 unit-select" name="items[8][unit]">
                                        <option value="" selected></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->units }}">{{ $unit->units }}</option>
                                        @endforeach
                                        <option value="add">+ Add New</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[8][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[8][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[8][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr>

                            {{-- row 9 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[9][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100 unit-select" name="items[9][unit]">
                                        <option value="" selected></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->units }}">{{ $unit->units }}</option>
                                        @endforeach
                                        <option value="add">+ Add New</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[9][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[9][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[9][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr>

                            {{-- row 10 --}}
                            <tr>
                                <td style="width:30px; border-right:1px solid black; border-left:1px solid black; border-bottom:1px solid black;">
                                    <input type="number" name="items[10][quantity]" class="w-100 quantity" oninput="calculateLineAmount(this)">
                                </td>
                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <select class="w-100 unit-select" name="items[10][unit]">
                                        <option value="" selected></option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->units }}">{{ $unit->units }}</option>
                                        @endforeach
                                        <option value="add">+ Add New</option>
                                    </select>
                                </td>

                                <td style="border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[10][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[10][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[10][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr>

                            {{-- row 11 --}}
                            {{-- <tr>
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
                                    <input type="text" name="items[11][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[11][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[11][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr> --}}

                            {{-- row 12 --}}
                            {{-- <tr>
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
                                    <input type="text" name="items[12][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[12][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[12][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr> --}}

                            {{-- row 13 --}}
                            {{-- <tr>
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
                                    <input type="text" name="items[13][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[13][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[13][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr> --}}

                            {{-- row 14 --}}
                            {{-- <tr>
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
                                    <input type="text" name="items[14][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[14][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[14][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr> --}}

                            {{-- row 15 --}}
                            {{-- <tr>
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
                                    <input type="text" name="items[15][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[15][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[15][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr> --}}

                            {{-- row 16 --}}
                            {{-- <tr>
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
                                    <input type="text" name="items[16][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[16][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[16][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr> --}}

                            {{-- row 17 --}}
                            {{-- <tr>
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
                                    <input type="text" name="items[17][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[17][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[17][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr> --}}
                            {{-- row 18 --}}
                            {{-- <tr>
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
                                    <input type="text" name="items[18][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[18][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[18][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr> --}}
                            {{-- row 19 --}}
                            {{-- <tr>
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
                                    <input type="text" name="items[19][item_name]" class="w-100 text-start item-name ps-1" style="text-transform: uppercase;">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[19][unit_price]" class="w-100 unit-price" oninput="calculateLineAmount(this)">
                                </td>

                                <td style="width:100px; border-right:1px solid black; border-bottom:1px solid black;">
                                    <input type="text" name="items[19][line_amount]" class="w-100 line-amount text-end" disabled>
                                </td>

                            </tr> --}}

                            <!-- Total Row -->
                            <tr class="bg-black" style="border: 1px solid black">
                                <td colspan="3" class="p-0 m-0">
                                    <span></span>
                                </td>
                                
                                <td class="text-end p-1 bg-secondary text-white fw-bold" style=" border-right:1px solid black;">
                                    <label class="me-2" style="margin-top: 0.2rem">Total:</label>
                                </td>
                                <td class="p-1 bg-secondary">
                                    <div class="w-100 h-100 bg-secondary">
                                        <input id="totalAmount" class="w-100 text-white fw-bold border-0 bg-transparent p-0 text-end" type="text" value="####" disabled>
                                    </div>
                                </td>
                                
                            </tr>  
                            </form>
                                                        
                        </tbody>
                    </table>

                </div>

                <div class="footer d-flex gap-2 w-100 ">
                        {{-- Terms & Condition Container --}}
                        <div class="mt-5 mb-5 w-75 h-100">
                            <div class="header bg-secondary d-flex align-items-center justify-content-evenly" style="height:30px;">
                                <small class="text-white">Terms & Condition</small>
                                <small class="text-white">Remarks & Special Notes</small>
                            </div>  

                            <div class="h-100 w-100 d-flex" style="border:1px solid black;">
                                
                                <div class="p-2 w-75 d-flex flex-column gap-1" style="border-right:1px solid black;">
                                    <div class="row">
                                        <div class="col d-flex align-items-center">
                                            <span class="fw-bolder me-2" style="font-size:0.8rem;">Condition:</span>
                                            <input type="text" id="Condition" class="form-control p-0 w-100" style="font-size:0.8rem; width: auto; border:none; max-width:100%;" value="All Brand New 1 Year on">
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col  d-flex align-items-center">
                                            <span class="fw-bolder me-2"  style="font-size:0.8rem;">Warranty:</span>
                                            <input type="text" id="Warranty" class="form-control p-0 w-100" style="font-size:0.8rem; width: auto; border:none; max-width:100%;" value="All">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col  d-flex align-items-center">
                                            <span class="fw-bolder me-2"  style="font-size:0.8rem; white-space: nowrap;">VAT (12%):</span>
                                            <input type="text" id="VAT" class="form-control p-0 w-100" style="font-size:0.8rem; width: auto; border:none; max-width:100%;" value="Major Parts">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col d-flex align-items-center">
                                            <span class="fw-bolder me-2" style="font-size:0.8rem;">Availability:</span>
                                            <input type="text" id="Availability" class="form-control p-0 w-100" style="font-size:0.8rem; width: auto; border:none; max-width:100%;" value="Excluded">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col d-flex align-items-center">
                                            <span class="fw-bolder me-2"  style="font-size:0.8rem;">RD:</span>
                                            <input type="text" id="RD" class="form-control p-0 w-100" style="font-size:0.8rem; width: auto; border:none; max-width:100%;" value="Onstock">

                                        </div>
                                    </div>

                                </div>

                                {{-- Remarks & Special Notes --}}
                                <div class="border w-50 p-2">
                                    <div class="row">
                                        <div class="col">
                                            <span class="fw-bolder me-2" style="font-size:0.8rem;white-space: nowrap;">Price Effectivity:</span>
                                            <input type="text" id="PriceEffectivity" class="form-control p-0 w-100" style="font-size:0.8rem; width: auto; border:none;" value="1 Week">
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
                                <p class="m-0 p-0 fw-bold" style="font-size: 1.2rem">{{auth()->user()->name}}</p>
                                <p class="m-0 p-0" style="font-size: 0.8rem">Tech/Sales Representative</p>
                                <p class="m-0 p-0" style="font-size: 0.7rem;">{{auth()->user()->email}}</p>
                                <p class="m-0 p-0" style="font-size: 0.7rem">{{auth()->user()->phoneNumber}}</p>
                            </div>
                            
                        </div>
                </div>  
                </div>
                {{-- Footer Image --}}
                <img src="{{ asset($quotationHeaderAndFooter->footer_image) }}" 
                    alt="Footer Image" 
                    id="foot"
                    class="w-100 img-head" 
                    style="cursor: pointer;max-height: 137.45px;" 
                    data-bs-toggle="modal" 
                    data-bs-target="#imageModal"
                    data-id="{{ $quotationHeaderAndFooter->id }}" 
                    data-type="footer">
                
                </div>
            </div>    

            <div class="d-flex align-self-end gap-2">

                {{-- Edit --}}
                <button type="button" class="btn btn-info d-none" style="font-size:0.6rem; width:80px; border-radius:3px;" data-is="123" id="updateBtn-customers">
                    <i class="fa-solid fa-floppy-disk" id="saveupdateIcon"></i>
                    <span id="updatebuttonText-customer">{{ __('Edit') }}</span>
                    <span id="updatebuttonSpinner-customer" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>

                {{-- copy --}}
                <button type="button" class="btn btn-info d-none" style="font-size:0.6rem; width:80px; border-radius:3px;" data-copyID="123" id="CopyBtn-customers">
                    <i class="fa-solid fa-floppy-disk" id="saveCopyIcon"></i>
                    <span id="CopybuttonText-customer">{{ __('Copy') }}</span>
                    <span id="CopybuttonSpinner-customer" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>

                 {{-- Png --}}
                 <button type="button" id="convertCustomerDetailsBtnToPNG" class="btn bg-success text-white addButton" data-bs-toggle="modal"
                    style="font-size:0.6rem; width:80px; border-radius:3px;">
                    <i class="fa-solid fa-file-image"></i> Png
                 </button>

                 {{-- Print --}}
                <button type="button" class="btn btn-secondary"
                    style="font-size:0.6rem; width:80px; border-radius:3px;" id="printButton">
                    <i class="fa-solid fa-print" id="printQuotaionIcon"></i>
                    <span id="buttonText-Quotation">{{ __('Print') }}</span>
                    <span id="buttonSpinner-Quotation" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>

               
            </div>
          

    </div>
    

    {{-- modal for png preview--}}
    <!-- Bootstrap Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="previewImage" src="" class="img-fluid" alt="Preview">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button id="downloadImage" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk" id="saveQuotaionIconpng"></i>
                <span id="buttonText-Quotationpng">{{ __('Download Image') }}</span>
                <span id="buttonSpinner-Quotationpng" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Image Edit Bootstrap Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <!-- Image Preview -->
                <img id="modalHeaderImage" class="img-fluid" alt="Selected Image">
                
                <div id="deatils"></div>

                <img id="modalFooterImage" class="img-fluid" alt="Selected Image">

                <!-- File Input -->
                <input type="file" id="fileInput" class="form-control mt-3" accept="image/*">
                
                <!-- Hidden Fields -->
                <input type="hidden" id="quotationId" value="{{ $quotationHeaderAndFooter->id }}">
                <input type="hidden" id="imageType">

                <!-- Save Button -->
                <button id="saveImageBtn" class="btn btn-primary" style="margin-top: 20px">
                        <i class="fa-solid fa-floppy-disk" id="saveQuotaionIconEditHeadAndFooter"></i>
                        <span id="buttonText-QuotationEditHeadAndFooter">{{ __('Change Image') }}</span>
                        <span id="buttonSpinner-QuotationEditHeadAndFooter" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
</div>

 <!-- add unit Modal Structure -->
<!-- Add Unit Modal -->
<div class="modal fade" id="unitModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <small class="text-muted">Add Unit</small>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="unitModalForm">
                    @csrf
                    <div class="mb-3">
                        <label for="unitName" class="form-label" style="font-size:0.7rem;">Unit Name</label>
                        <input type="text" class="form-control" id="unitName" name="unitName"
                            placeholder="Enter unit name" style="height:30px;" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="saveUnitBtn" class="btn btn-primary" form="unitModalForm">
                    <span id="buttonText">Save</span>
                    <span id="buttonSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>
        </div>
    </div>
</div>

</div>
<script src="{{ asset('js/quotation.js') }}"></script>


@endsection