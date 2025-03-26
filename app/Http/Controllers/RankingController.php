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

        // Fetch all users with 'user' role, left join rankings, ordered by sales amount
        $rankings = User::where('role', 'user')
            ->leftJoin('rankings', 'users.id', '=', 'rankings.user_id')
            ->orderBy('rankings.sales_amount', 'desc')
            ->orderBy('users.name') // Secondary sort by name for users with no sales
            ->select('users.id', 'users.name', 'rankings.sales_amount')
            ->get()
            ->map(function ($user) {
                // Ensure sales_amount is 0 if null
                $user->sales_amount = $user->sales_amount ?? 0;
                return $user;
            });

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
