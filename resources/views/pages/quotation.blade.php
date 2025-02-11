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
                        <th scope="col">No.</th>
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
    <div class="h-100 w-100 border rounded p-3 overflow-auto custom-scrollbar">

        <div class="text-center">
            <h4 class=" fw-bolder">PRICE&nbsp;&nbsp; QUOTATION</h4>
        </div>

        {{-- Customer Details Container--}}
        <div class="d-flex justify-content-between fw-bolder">

            <div class="d-flex flex-column gap-2 "style="font-size:0.8rem;">
                {{-- Customer Name --}}
                <div class="customerName">
                    <label for="customerName">Customer&nbsp; :</label>
                    <input type="text" id="customerName" style="border: none; outline: none;">
                </div>

                {{-- Customer Address --}}
                <div class="customerAddress">
                    <label for="customerAddress" >Address&nbsp; &nbsp; &nbsp;:</label>
                    <input type="text" id="customerAddress"style="border: none; outline: none;">
                </div>

                {{-- Customer Contact Number --}}
                <div class="customerContact">
                    <label for="customerContact" >Contact&nbsp; &nbsp; &nbsp;:</label>
                    <input type="text" id="customerContact" style="border: none; outline: none;">
                </div>

            </div>

            {{-- No. & Date Container --}}
            <div class="d-flex flex-column gap-2" style="font-size:0.8rem;">
                {{-- No. --}}
                <div class="customerQNumber">
                    <label for="customerQNumber">Q No&nbsp; &nbsp; &nbsp;:</label>
                    <input type="text" id="customerQNumber" placeholder="10093" style="border: none; outline: none; width:130px;">
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
        <div class="border w-100 h-100 rounded-bottom mt-2">
            <table class="table table-sm text-center">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Quantity</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Item Name & Description</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Line Amount</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div>

        </div>
        
        <div>

        </div>

    </div>
    
</div>
@endsection