@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Quotation')

@section('content')
<div class="d-flex h-100 w-100 gap-2 p-1">

    <div class="d-flex flex-column gap-3 position-relative">
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

        <div class="d-flex gap-1 position-absolute">

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
    <div class="h-100 w-100 border rounded" >

    </div>
    
</div>
@endsection