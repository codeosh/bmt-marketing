<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $accounts = User::latest()->paginate(10);
        return view('pages.accounts', compact('accounts'));
    }

    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent updates to deactivated users
        if ($user->status === 'deactivated') {
            return response()->json(['error' => 'This account has been permanently deactivated and cannot be modified.'], 403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phoneNumber' => 'nullable|string|max:15',
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,frozen,deactivated',
        ]);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phoneNumber' => $validatedData['phoneNumber'],
            'role' => $validatedData['role'],
            'status' => $validatedData['status'],
        ]);

        return response()->json(['success' => true, 'user' => $user]);
    }
    public function destroy($id)
    {
        $deleteAcc = User::findOrFail($id);
        $deleteAcc->delete();

        return response()->json(['success' => true]);
    }
}
