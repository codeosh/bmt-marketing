@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Quotation')

@section('content')
<div class="d-flex h-100 w-100 gap-2 p-1 overflow-hidden">

    <div class="d-flex flex-column gap-2">
        {{-- Side List --}}
        <div class="border w-100 h-100 rounded-bottom">
            <table class="table table-sm text-center">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nos.</th>
                        <th scope="col">Customer</th>
                    </tr>

                </thead>
            </table>
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-1">

            {{-- Add New --}}
            <button type="button" class="btn btn-success addButton" data-bs-toggle="modal"
                style="font-size:0.6rem; width:80px; border-radius:3px;">
                <i class="fa-solid fa-plus"></i> Add New
            </button>


            {{-- Save--}}
            <button type="button" class="btn btn-info saveButton" data-bs-toggle="modal"
               style="font-size:0.6rem; width:80px; border-radius:3px;">
               <i class="fa-solid fa-floppy-disk"></i> Save
           </button>

             {{-- Delete --}}
             <button type="button" class="btn btn-danger saveButton" data-bs-toggle="modal"
             style="font-size:0.6rem; width:80px; border-radius:3px;">
             <i class="fa-solid fa-trash"></i> Delete
            </button>

        </div>
       
    </div>
    
    {{-- Content --}}
    <div class=" w-100 border rounded p-3 overflow-auto custom-scrollbar " style="height:80vh;">

        <div class="text-center">
            <h4 class=" fw-bolder">PRICE&nbsp;&nbsp; QUOTATION</h4>
        </div>

        {{-- Customer Details Container--}}
        <div class="d-flex justify-content-between">

            <div class="customerDetails d-flex flex-column gap-2"style="font-size:0.8rem;flex-basis:70%;">
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
                    <label for="customerATN" class="me-2">ATN &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:</label>
                    <input type="text" id="customerATN" class="flex-grow-1" style="border: none; outline: none;">
                </div>

            </div>

            {{-- No. & Date Container --}}
            <div class="d-flex flex-column gap-2" style="font-size:0.8rem;flex-basis:30%;">
                {{-- No. --}}
                <div class="customerQNumber">
                    <label for="customerQNumber">Q No&nbsp; &nbsp; &nbsp;:</label>
                    <input type="text" id="customerQNumber" placeholder="10093" style="border: none; outline: none; width:130px; font-size:1.5rem; font-weight:bold;">
                </div>

                {{-- Date Issued--}}
                <div class="customerDateIssued">
                    <label for="customerDateIssued" >Date&nbsp; &nbsp; &nbsp;:</label>
                    <input type="text" id="customerDateIssued" placeholder="01 - 30 - 2025" style="border: none; outline: none; width:130px;">
                </div>

                {{-- Terms --}}
                <div class="customerTerms">
                    <label for="customerTerms">Terms&nbsp; &nbsp;:</label>
                    <input type="text" id="customerTerms" style="border: none; outline: none; width:130px;">
                </div>
            </div>

        </div>

        {{-- Quote --}}
        <div class="mt-3">
            <p class="fst-italic" style="font-size:0.8rem;">" We are happy to quote you the following items you requested below..."</p>
        </div>

        
        {{-- Table --}}
        <div class="border w-100 rounded-bottom mt-2">
            <table class="table table-sm text-center">
                <thead class="table-light" >
                    <tr>
                        <th scope="col">Quantity</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Item Name & Description</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Line Amount</th>
                    </tr>
                    <tbody>
                        <td style="width:30px; border-right:1px solid black;border-left:1px solid black;">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <label></label>
                        </td>
                        <td style="width:100px; border-right:1px solid black;">
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            
                            <select class="w-100">
                                <option value="" disabled selected></option>
                                <option value="PCS">PCS</option>
                                <option value="BOX">BOX</option>
                            </select>
                            <label></label>
                        </td>
                        <td style="border-right:1px solid black;" >
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <label></label>
                        </td>
                        <td style="width:100px; border-right:1px solid black;">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input class="bg-secondary text-white " type="text" class="w-100" value="Total:" disabled>
                        </td>
                        <td style="width:100px; border-right:1px solid black;">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input type="text" class="w-100">
                            <input class="bg-secondary text-white" type="text" class="w-100" value="" disabled>
                        </td>
                    </tbody>
                </thead>
            </table>
        </div>

        {{-- Terms & Condition Container --}}
        <div class="mt-5 mb-5" style=" height:150px; width:500px;">
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
    </div>
    
    
</div>
@endsection