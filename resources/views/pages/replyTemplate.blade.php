@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Reply Template')
@section('content')
<div class="h-100 w-100 d-flex justify-content-between">
    <div class="h-100" style="width:300px;">
        {{-- Bulletin List --}}
       <div class="card w-100 h-50 mb-1">
          <small class="card-header text-muted" style="font-size:0.7rem;">Bulletin</small>
          <div class="card-body p-0 pt-2 overflow-auto custom-scrollbar">
              <ol style="font-size:0.8rem; cursor:pointer;">
                <li class="bulletinList"><a href="">Computer Set - 1</a></li>
                <li class="bulletinList"><a href="">Computer Set - 2</a></li>
                <li class="bulletinList"><a href="">Computer Set - 3</a></li>
                <li class="bulletinList"><a href="">Computer Set - 4</a></li>
                <li class="bulletinList"><a href="">Computer Set - 5</a></li>
              </ol>
          </div>
      </div>

      {{-- Other List --}}
     <div class="card w-100 h-50 ">
          <small class="card-header text-muted" style="font-size:0.7rem;">Templates</small>
          <div class="card-body p-0 pt-2 overflow-auto custom-scrollbar">
              <ol style="font-size:0.8rem; cursor:pointer;">
                <li class="bulletinList"><a href="">Computer Set - 6</a></li>
                <li class="bulletinList"><a href="">Computer Set - 7</a></li>
                <li class="bulletinList"><a href="">Computer Set - 8</a></li>
                <li class="bulletinList"><a href="">Computer Set - 9</a></li>
                <li class="bulletinList"><a href="">Computer Set - 10</a></li>
              </ol>
          </div>
      </div> 
  </div>   


  {{-- List Content --}}
  <div class="h-100 w-100 border rounded" style="margin-left:1rem;;">
    <div class="header w-100 rounded p-1 d-flex align-items-center gap-2" 
    style="height:2rem; background-color:grey;">
        <small style="font-size: 0.8rem; color:white; margin-left:10px;">Context</small>
        <div style="border-left: 1px solid white; height: 1.2rem; margin-right: 8px;"></div>
        <span style="font-size:0.9rem; color:white; font-weight:bold;">Bulletin</span>
    </div>

    {{-- Content --}}
    <div class="w-100 overflow-auto rounded" 
    style="height:78.8vh; max-height:78.8vh; font-size:0.8rem; padding: 5px 10px; text-align:justify;">
    </div>

 </div>
</div>

@endsection