<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\User;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index()
    {
        // Fetch users with 'user' role for dropdown
        $users = User::where('role', 'user')->get();

        // Fetch rankings with user data, ordered by sales amount
        $rankings = Ranking::with('user')
            ->join('users', 'rankings.user_id', '=', 'users.id')
            ->orderBy('sales_amount', 'desc')
            ->select('rankings.*')
            ->get();

        return view('pages.ranking', compact('users', 'rankings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'sales_amount' => 'required|numeric|min:0',
        ]);

        // Update existing record or create new one
        Ranking::updateOrCreate(
            ['user_id' => $request->user_id], // Match on user_id
            ['sales_amount' => $request->sales_amount] // Update or set this value
        );

        return redirect()->back()->with('success', 'Sales amount updated successfully!');
    }
}
