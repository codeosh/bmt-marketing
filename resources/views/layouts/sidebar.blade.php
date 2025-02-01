@extends('admin.admin-dashboard')

@section('sidebar')
<div class="sidebar shadow">
            <div class="text">
                <h1>BMT Marketing</h1>
                <p>Systematic Buddy 2.0</p>
            </div>

            <a href="{{ route('bulletin')}}">
                <div class="bulletin input-group mb-0 mt-5 d-flex align-items-center justify-content-center border rounded">
                    <i class="fa-solid fa-list-ul me-2 icon" style="font-size: 14px;"></i>
                    <span class="navbar-text" style="font-size: 12px;">Bulletin & To Do</span>
                </div>
            </a>
   
            <a href="{{ route('postTemplate') }}">
                <div class="Post-template input-group mt-1 d-flex align-items-center justify-content-center border rounded">
                    <i class="fa-solid fa-signs-post me-2 icon" style="font-size: 14px;"></i>
                    <span class="navbar-text" style="font-size: 12px;">Post Templates</span>
                </div>
            </a>
       
            <a href="{{route('replyTemplate')}}">
                <div class="Reply-template input-group mt-1 d-flex align-items-center justify-content-center border rounded">
                    <i class="fa-solid fa-reply me-2 icon" style="font-size: 14px;"></i>
                    <span class="navbar-text" style="font-size: 12px;">Reply Templates</span>
                </div>
            </a>
            <hr>
            <a href="{{route('priceList')}}">
                <div class="Price-list input-group mt-3 d-flex align-items-center justify-content-center border rounded">
                    <i class="fa-solid fa-money-check-dollar me-2 icon" style="font-size: 14px;"></i>
                    <span class="navbar-text" style="font-size: 12px;">Price List</span>
                </div>
            </a>

            <a href="{{route('quotation')}}">
                <div class="Quotation input-group mt-1 d-flex align-items-center justify-content-center border rounded">
                    <i class="fa-solid fa-quote-left me-2 icon" style="font-size: 14px;"></i>
                    <span class="navbar-text" style="font-size: 12px;">Quotation</span>
                </div>
            </a>
            
        </div>
@endsection