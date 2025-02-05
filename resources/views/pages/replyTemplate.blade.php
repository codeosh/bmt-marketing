@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Reply Template')

@section('content')
<div class="h-100 w-100 d-flex justify-content-between">
    <div class="h-100" style="width:550px;">
        {{-- Bulletin List --}}
        <div class="card w-100 h-50 mb-1 shadow-sm" style="height: 300px;">
            <small class="card-header text-muted text-center" style="font-size: 0.8rem;">Bulletin</small>
            <div class="card-body p-2 overflow-auto custom-scrollbar" style="height: 300px;">
                <div id="bulletinList" class="d-grid gap-1"></div>
            </div>
        </div>

        {{-- Template List --}}
        <div class="card w-100 h-50 shadow-sm" style="height: 300px;">
            <small class="card-header text-muted text-center" style="font-size: 0.8rem;">Template</small>
            <div class="card-body p-2 overflow-auto custom-scrollbar" style="height:50px;">
                <div id="templateList" class="d-grid gap-1"></div>
            </div>
        </div>
    </div>


    {{-- List Content --}}
    <div class="h-100 w-100 border rounded" style="margin-left:1rem; ">
        <div class="header  w-100 rounded p-1 d-flex align-items-center justify-content-between gap-2"
            style="height:2rem; background-color:grey;">
            <div class="d-flex align-items-center justify-content-between">
                <small style="font-size: 0.8rem; color:white; margin:10px">Context</small>
                <div style="border-left: 1px solid white; height: 1.2rem; margin-right: 8px;"></div>
                <span class="display-item-name" style="font-size:0.9rem; color:white; font-weight:bold;"></span>
            </div>

            <div class="d-flex gap-2">
                {{-- Copy --}}
                <div class="deleteButton d-flex align-items-center justify-content-center">
                    <button type="button" class="btn btn-dark"
                        style="font-size:0.6rem; width:100px; height:25px; border-radius:3px">
                        <i class="fa-solid fa-copy" style="margin-right: 5px;"></i>Copy
                    </button>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="w-100 rounded content-display"
            style="height:78.8vh; max-height:78.8vh; font-size:0.8rem; padding: 5px 10px;">
        </div>
    </div>
</div>

{{-- bulletin Script JS --}}
<script src="{{ asset('js/replyTemplates.js') }}"></script>>
@endsection