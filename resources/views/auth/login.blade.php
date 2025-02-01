{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />


    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BMTMarketing - login</title>
    <link rel="icon" href="{{asset('pictures/Bizmatech-logo-removebg-preview.png')}}">
    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


    {{-- Style Css --}}
    <link rel="stylesheet" href="{{asset('style.css')}}">

    
    
    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="main-div vh-100 vw-100 d-flex align-items-center justify-content-center " style="background-color:#F5F7FF;">
        
        <div class="d-flex shadow-lg flex-wrap w-100 h-auto overflow-hidden" style="max-width: 900px;">
            {{-- image --}}
            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center flex-column p-4 bg-white">
                <div class="picture-div mb-4 d-flex justify-content-center align-items-center" style="height:350px; width:350px;"class="picture-div mb-4 d-flex justify-content-center align-items-center" style="max-width: 100%; height: auto;">
                    <img src="{{asset('pictures/Bizmatech-logo-removebg-preview.png')}}" alt="Bizmatech Logo" class="img-fluid" style="max-height: 350px;">
                </div>
            </div>

            {{-- Login Form --}}
            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center flex-column p-5" style="background-color:#F5F5F5;">
                <form method="POST" action="{{ route('login') }}" class="d-flex align-items-center justify-content-center flex-column w-100">
                    @csrf
                    <div class="mb-4 w-100">
                        <h1 class="fw-bold text-primary">Welcome!</h1>
                        <small class="text-muted" style="font-size:0.6rem;">Explore top-quality Vendo Computers for all your needs.</small>
                    </div>
                    <div class="col w-100 mb-2">
                        <label for="email" :value="__('Email')" class="mb-2">Email</label>
                        <input id="email" class="form-control"  aria-label="Username" required aria-describedby="basic-addon1" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" >
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="col  w-100 mb-3">
                        <label for="password" :value="__('Password')" class="mb-2" for="password">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <div class="w-100 d-flex align-items-center justify-content-end mt-2">
                            <div class="form-check ml-3">
                                <input class="form-check-input" id="showPassword" type="checkbox" value="" aria-label="Checkbox for following text input" id="showPassword">
                                <label class="form-check-label" for="showPassword">Show Password</label>
                            </div>
                            
                        </div>
                    </div>
                    
                    <button id="loginButton" type="submit" class="btn btn-primary w-50">
                        <span id="buttonText">{{ __('Log in') }}</span>
                        <span id="buttonSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>

                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/showpassword.js') }}">

    </script>
</body>
</html> 