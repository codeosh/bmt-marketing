@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Bulletin & To Do')
@section('content')
<div class="h-100 w-100 d-flex justify-content-between">
    <div class="h-100" style="width:300px;">
        {{-- Bulletin List --}}
        <div class="card w-100 h-50 mb-1">
            <small class="card-header text-muted" style="font-size:0.7rem;">Bulletin</small>
            <div class="card-body p-0 pt-2 overflow-auto custom-scrollbar">

            </div>
        </div>

        {{-- Other List --}}
        <div class="card w-100 h-50 ">
            <small class="card-header text-muted" style="font-size:0.7rem;">Template</small>
            <div class="card-body p-0 pt-2 overflow-auto custom-scrollbar">

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
    </div>

        {{-- Content --}}
        <div class="w-100 overflow-auto rounded"
            style="height:78.8vh; max-height:78.8vh; font-size:0.8rem; padding: 5px 10px; text-align:justify;">
        </div>

    </div>
</div>

@endsection