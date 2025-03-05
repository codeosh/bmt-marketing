@extends('user.user-dashboard')

@section('title', 'BMTMarketing - Reply Template')

@section('content')
<div class="d-flex gap-1 h-100">

    <div class="d-flex gap-1 flex-column h-100 w-45">
        {{-- Bulletin List --}}
        <div class="card h-50 shadow-sm" style="width:60vh;">
            <small class="card-header text-muted text-center" style="font-size: 0.8rem;">Bulletin</small>
            <div class="card-body p-2 overflow-auto custom-scrollbar" style="height: 300px;">
                <div id="bulletinList" class="d-grid gap-1"></div>
            </div>
        </div>

        {{-- Template List --}}
        <div class="card h-50 shadow-sm" style="width:60vh;">
            <small class="card-header text-muted text-center" style="font-size: 0.8rem;">Template</small>
            <div class="card-body p-2 overflow-auto custom-scrollbar" style="height:50px;">
                <div id="templateList" class="d-grid gap-1"></div>
            </div>
        </div>
    </div>


    {{-- List Content --}}
    <div class="h-100 w-100 rounded border">
        <div class="header d-flex rounded p-1 gap-2" style="height:37px; background-color:grey;">

            <div class="d-flex align-items-center w-100">
                <small style="font-size: 0.8rem; color:white; margin:10px">Context</small>
                <div  style="border-left: 1px solid white; height: 1.2rem; margin-right: 8px;"></div>

                {{-- Title --}}
                <span class="display-item-name text-truncate d-inline-block" 
                style="font-size: 0.9rem; width:85vh; color: white; font-weight: bold; white-space: nowrap; overflow: hidden;">
                </span>
            </div>

                {{-- Copy --}}
                <div class="copyContents d-flex align-items-center justify-content-center">
                        <button type="button" id="CopysaveBtn-replyTemplate" class="btn btn-dark" style="font-size:0.6rem; width:100px; height:29px; border-radius:3px">
                        <i class="fa-solid fa-copy" style="margin-right: 5px;"></i><span id="CopybuttonText-replyTemplate">Copy</span>
                        <span id="CopybuttonSpinner-replyTemplate" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>            
                    </button>
                </div>
        </div>

        {{-- Content --}}
        <div class="w-100 overflow-auto rounded content-display"
            style="height:78.8vh; max-height:78.8vh; font-size:0.8rem; padding: 5px 10px;">
            <div class="d-flex justify-content-center align-items-center h-100">
                <p id="item-" style="color: red;">Please select an item to see the content.</p>
            </div>
        </div>
    </div>
</div>

{{-- bulletin Script JS --}}
<script src="{{ asset('js/replyTemplates.js') }}"></script>
@endsection