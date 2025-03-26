<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        Ranking::create([
            'user_id' => $request->user_id,
            'sales_amount' => $request->sales_amount,
        ]);

        return redirect()->back()->with('success', 'Sales amount updated successfully!');
    }

    public function add(Request $request)
    {
        try {
            Log::info('Add route hit', $request->all());

            $request->validate([
                'user_id' => 'required|exists:users,id',
                'add_amount' => 'required|numeric|min:0',
            ]);

            // Find or create the ranking for this user
            $ranking = Ranking::firstOrCreate(
                ['user_id' => $request->user_id],
                ['sales_amount' => 0]
            );

            $newSalesAmount = $ranking->sales_amount + $request->add_amount;

            Log::info('Add calculation', [
                'ranking_id' => $ranking->id,
                'user_id' => $request->user_id,
                'current_sales_amount' => $ranking->sales_amount,
                'add_amount' => $request->add_amount,
                'new_sales_amount' => $newSalesAmount
            ]);

            $ranking->sales_amount = $newSalesAmount;
            $ranking->save();

            Log::info('Sales updated', ['ranking_id' => $ranking->id, 'new_sales_amount' => $ranking->sales_amount]);

            return response()->json([
                'success' => true,
                'message' => 'Sales amount added successfully',
                'new_sales_amount' => $ranking->sales_amount
            ]);
        } catch (\Exception $e) {
            Log::error('Error in add method', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function minus(Request $request)
    {
        try {
            Log::info('Minus route hit', $request->all());

            $request->validate([
                'user_id' => 'required|exists:users,id',
                'minus_amount' => 'required|numeric|min:0',
            ]);

            // Find or create the ranking for this user
            $ranking = Ranking::firstOrCreate(
                ['user_id' => $request->user_id],
                ['sales_amount' => 0] // Default to 0 if no ranking exists
            );

            $newSalesAmount = $ranking->sales_amount - $request->minus_amount;

            Log::info('Minus calculation', [
                'ranking_id' => $ranking->id,
                'user_id' => $request->user_id,
                'current_sales_amount' => $ranking->sales_amount,
                'minus_amount' => $request->minus_amount,
                'new_sales_amount' => $newSalesAmount
            ]);

            if ($newSalesAmount < 0) {
                Log::warning('Sales would go below 0', ['new_sales_amount' => $newSalesAmount]);
                return response()->json(['success' => false, 'error' => 'Cannot reduce sales below 0'], 422);
            }

            $ranking->sales_amount = $newSalesAmount;
            $ranking->save();

            Log::info('Sales updated', ['ranking_id' => $ranking->id, 'new_sales_amount' => $ranking->sales_amount]);

            return response()->json([
                'success' => true,
                'message' => 'Sales amount updated successfully',
                'new_sales_amount' => $ranking->sales_amount
            ]);
        } catch (\Exception $e) {
            Log::error('Error in minus method', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}
