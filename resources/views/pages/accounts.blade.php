@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Accounts')

@section('content')

        {{-- Add Accounts --}}
        <div class="addAccount d-flex align-items-center justify-content-end mb-2">
            <button type="button" class="btn btn-success saveButton" data-bs-toggle="modal" data-bs-target="#addAccountModal" style="font-size:0.8rem;">
                <i class="fa-solid fa-plus" style="margin-right: 5px;"></i> 
                <small>Add Account</small>
            </button>
        </div>

       <!-- Table -->
<div class="accounts-container table-responsive border rounded p-3">
    <table class="table table-hover align-middle">
        <thead class="text-white">
            <tr>
                <th class="px-3 py-2">Name</th>
                <th class="px-3 py-2">Email</th>
                <th class="px-3 py-2">Role</th>
                <th class="px-3 py-2">Action</th>
            </tr>
        </thead>
        <tbody class="bg-light">
            <tr>
                <td class="px-3 py-2">John Doe</td>
                <td class="px-3 py-2">john.doe@example.com</td>
                <td class="px-3 py-2"><span class="badge bg-success">Admin</span></td>
                <td class="px-3 py-2">
                    <div class="d-flex gap-2">
                        <!-- Edit -->
                        <div class="editButton d-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-primary"
                                style="font-size:0.6rem; width:100px; height:25px; border-radius:3px">
                                <i class="fa-regular fa-pen-to-square" style="margin-right: 5px;"></i>Edit
                            </button>
                        </div>

                        <!-- Delete -->
                        <div class="deleteButton d-flex align-items-center justify-content-center">
                            <button type="button" class="btn btn-danger"
                                style="font-size:0.6rem; width:100px; height:25px; border-radius:3px">
                                <i class="fa-solid fa-trash" style="margin-right: 5px;"></i>Delete
                            </button>
                        </div>      
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>




        <!-- Add Account Modal -->
        <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="{{ route('register') }}">
                    <div class="modal-header text-black">
                        <h5 class="modal-title" id="addAccountModalLabel">Add New Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name" :value="__('Name')"  class="form-label">Username</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" :value="__('Email')" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select" id="role" name="role">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="password" :value="__('Password')" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="password_confirmation" :value="__('Confirm Password')" class="form-label">Confirm Password</label>
                                        <input type="confirmPassword" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Save Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

@endsection