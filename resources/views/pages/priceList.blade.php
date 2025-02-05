@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Price List')

@section('content')
<div class="h-100 w-100 d-flex justify-content-between">
    <div class="h-100" style="width:550px;">
        {{-- Bulletin List --}}
        <div class="card w-100 h-50 mb-1 shadow-sm" style="height: 300px;">
            <small class="card-header text-muted text-center" style="font-size:0.8rem;">Bulletin</small>
            <div class="card-body p-2 overflow-auto custom-scrollbar">
                <ol style="font-size:0.8rem; cursor:pointer;">
                    @if($pnamesBulletin->isEmpty())
                    <p>Bulletin is Empty.</p>
                    @else
                    @foreach ($pnamesBulletin as $id => $pname)
                    <div class="d-flex align-items-center justify-content-between mb-2" style="margin-right: 10px">
                        <li class="bulletinList" data-id="{{ $id }}" data-type="bulletin">{{$pname}}</li>
                        <div class="d-flex gap-1">
                            {{-- Delete --}}
                            <div class="deleteButton">
                                <button type="button"
                                    class="btn btn-danger d-flex align-items-center justify-content-center delete-priceList"
                                    data-id="{{$id}}" data-pname="{{$pname}}"
                                    style="font-size:0.5rem; height:20px; border-radius:3px">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            {{-- Edit --}}
                            <div class="editButton ">
                                <button type="button"
                                    class="btn btn-primary d-flex align-items-center justify-content-center"
                                    style="font-size:0.5rem; height:20px; border-radius:3px">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </ol>
            </div>
        </div>

        {{-- Template --}}
        <div class="card w-100 h-50 shadow-sm" style="height: 300px;">
            <small class="card-header text-muted text-center" style="font-size:0.8rem;">Template</small>
            <div class="card-body p-2 overflow-auto custom-scrollbar">
                <ol style="font-size:0.8rem; cursor:pointer;">
                    @if($pnamesTemplate->isEmpty())
                    <p>No products found.</p>
                    @else
                    @foreach ($pnamesTemplate as $id => $pname)
                    <div class="d-flex align-items-center justify-content-between mb-2 " style="margin-right: 10px">
                        <li class="bulletinList" data-id="{{ $id }}" data-type="template">{{ $pname }} </li>
                        <div class="d-flex gap-1">
                            {{-- Delete --}}
                            <div class="deleteButton">
                                <button
                                    class="btn btn-danger d-flex align-items-center justify-content-center delete-priceList"
                                    data-id="{{$id}}" data-pname="{{$pname}}"
                                    style="font-size:0.5rem; height:20px; border-radius:3px">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                            {{-- Edit --}}
                            <div class="editButton ">
                                <button type="button"
                                    class="btn btn-primary d-flex align-items-center justify-content-center"
                                    style="font-size:0.5rem; height:20px; border-radius:3px">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    @endif
                </ol>
            </div>
        </div>
    </div>


    {{-- List Content --}}
    <div class="h-100 w-100 border rounded" style="margin-left:1rem;">
        <div class="header w-100 rounded p-1 d-flex align-items-center justify-content-between gap-2"
            style="height:2rem; background-color:grey;">
            <div class="d-flex align-items-center justify-content-between">
                <small style="font-size: 0.8rem; color:white; margin:10px">Context</small>
                <div style="border-left: 1px solid white; height: 1.2rem; margin-right: 8px;"></div>
                <span id="contentName" style="font-size:0.9rem; color:white; font-weight:bold;"></span>
            </div>

            <div class="d-flex gap-2">
                {{-- Copy --}}
                {{-- <button type="submit" id="copyButton" form="pricelistForm"
                    class="d-flex align-items-center justify-content-center">
                    <span id="buttonText">{{ __('Save') }}</span>
                    <span id="buttonSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                        aria-hidden="true"></span>
            </div>
            </button> --}}
            <div class="copyButton" d-flex align-items-center justify-content-center">

                <button type="button" id="copyBtn" class="btn btn-dark"
                    style="font-size:0.6rem; width:100px; height:25px; border-radius:3px">
                    <i class="fa-solid fa-trash" style="margin-right: 5px;"></i>Copy
                </button>
            </div>
        </div>
    </div>


    {{-- Content --}}
    <div id="contentDisplay" class="w-100 overflow-auto rounded"
        style="height:78.8vh; max-height:78.8vh; font-size:0.8rem; padding: 5px 10px; text-align:justify;">
        <div class="w-100 overflow-auto rounded d-flex justify-content-center align-items-center"
            style="height:78.8vh; max-height:78.8vh; font-size:0.8rem; padding: 5px 10px; text-align:justify;">
            <p id="item-" style="color: red;">Please select an item to see the content.</p>
        </div>
    </div>
</div>

{{-- JS Compiled --}}
<script src="{{asset('js/priceList.js')}}"></script>
@endsection

