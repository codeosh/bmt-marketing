@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Price List')

@section('content')

<div class="h-100 w-100 d-flex justify-content-between">
    <div class="h-100" style="width:300px;">
        {{-- Bulletin List --}}
       <div class="card w-100 h-50 mb-1">
          <small class="card-header text-muted" style="font-size:0.7rem;">Bulletin</small>
          <div class="card-body p-0 pt-2 overflow-auto custom-scrollbar">
              <ol style="font-size:0.8rem; cursor:pointer;">
                @if($pnamesBulletin->isEmpty())
                    <p>Bulletin is Empty.</p>
                @else
                    @foreach ($pnamesBulletin as $id => $pname)
                        <li class="bulletinList" data-id="{{ $id }}" data-type="bulletin">{{$pname}}</li>
                    @endforeach
                @endif
              </ol>
          </div>
      </div>

      {{-- Template --}}
     <div class="card w-100 h-50 mb-2">
          <small class="card-header text-muted" style="font-size:0.7rem;">Template</small>
          <div class="card-body p-0 pt-2 overflow-auto custom-scrollbar">
             
                    <ol style="font-size:0.8rem; cursor:pointer;">
                        @if($pnamesTemplate->isEmpty())
                            <p>No products found.</p>
                        @else
                            @foreach ($pnamesTemplate as $id => $pname)
                                <li class="bulletinList" data-id="{{ $id }}" data-type="Template">{{ $pname }}</li>
                            @endforeach
                        @endif
                    </ol>
               
          </div>
      </div> 
  </div>   


  {{-- List Content --}}
  <div class="h-100 w-100 border rounded" style="margin-left:1rem;;">
    <div class="header w-100 rounded p-1 d-flex align-items-center justify-content-between gap-2" 
    style="height:2rem; background-color:grey;">
        <div class="d-flex align-items-center justify-content-between">
            <small style="font-size: 0.8rem; color:white; margin:10px">Context</small>
            <div style="border-left: 1px solid white; height: 1.2rem; margin-right: 8px;"></div>
            <span style="font-size:0.9rem; color:white; font-weight:bold;">Bulletin</span>
        </div>

        <div class="d-flex gap-2">
                {{-- Edit --}}
                <div class="editButton d-flex align-items-center justify-content-center">
                    <button type="button" class="btn btn-primary"
                         style="font-size:0.6rem; width:100px; height:25px; border-radius:3px">
                         <i class="fa-regular fa-pen-to-square" style="margin-right: 5px;"></i>Edit
                    </button>
                 </div>

                {{-- Delete --}}
                <div class="deleteButton d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-danger"
                            style="font-size:0.6rem; width:100px; height:25px; border-radius:3px">
                            <i class="fa-solid fa-trash" style="margin-right: 5px;"></i>Delete
                        </button>
                </div>      
        </div>
    </div>

    {{-- Content --}}
    <div id="contentDisplay" class="w-100 overflow-auto rounded" 
        style="height:78.8vh; max-height:78.8vh; font-size:0.8rem; padding: 5px 10px; text-align:justify;">
        <p>Please select an item to see the content.</p>
    </div>


 </div>
</div>


@endsection

{{-- @push('scripts')
    <script src="{{ asset('js/priceList-content')}}"></script> {{-- script to handle the click events for each list item. When the user clicks on a list item, an AJAX request will be sent to the controller to fetch the content and display it inside the #contentDisplay div. --}}
{{--@endpush --}}