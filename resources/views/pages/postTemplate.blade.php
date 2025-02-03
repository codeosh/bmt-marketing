@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Post Templates')

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
    <div class="w-100 overflow-auto rounded" 
    style="height:78.8vh; max-height:78.8vh; font-size:0.8rem; padding: 5px 10px; text-align:justify;">
    </div>

 </div>
</div>
</div>
@endsection