@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Guides')

@section('content')
    <div class="h-100 w-100 d-flex align-items-center justify-content-center p-2"  
        style="background: url({{ asset('pictures/background.png') }}) no-repeat center center; 
            background-size: 100% 100%">
        <div class="d-flex align-items-center justify-content-center h-100 w-100"
            style="background: url({{ asset('pictures/Bizmatech-logo-removebg-preview.png') }}) no-repeat center center; 
                background-size: contain; 
                opacity: 0.8;">
        </div>
    </div>
@endsection