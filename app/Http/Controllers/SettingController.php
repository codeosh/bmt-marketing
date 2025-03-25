<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\Insight;
use App\Models\PostTemplate;
use App\Models\Pricelist;
use App\Models\QuotationCustomer;
use App\Models\QuotationItem;
use App\Models\ReplyTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        return view('pages.settings');
    }

    public function reset(Request $request)
    {
        $resetOptions = $request->input('reset', []);

        try {
            foreach ($resetOptions as $option) {
                switch ($option) {
                    case 'bulletin':
                        Bulletin::query()->delete();
                        break;
                    case 'post_template':
                        PostTemplate::query()->delete();
                        break;
                    case 'reply_template':
                        ReplyTemplate::query()->delete();
                        break;
                    case 'pricelist':
                        Pricelist::query()->delete();
                        break;
                    case 'quotation':
                        DB::table('qoutotaion_terms_condtion_remarks')->delete();
                        QuotationItem::query()->delete();
                        QuotationCustomer::query()->delete();
                        break;
                    case 'insights':
                        Insight::query()->delete();
                        break;
                    case 'accounts':
                        // Delete all users with role 'user'
                        User::where('role', 'user')->delete();
                        // Delete all admins except the default one (e.g., email = "admin@email.com")
                        User::where('role', 'admin')
                            ->where('email', '!=', 'admin@email.com')
                            ->delete();
                        break;
                }
            }

            // If everything succeeds, flash a success message
            return redirect()->route('settings.page')->with('success', 'Selected data has been reset successfully!');
        } catch (\Exception $e) {
            // If something fails, flash an error message
            return redirect()->route('settings.page')->with('error', 'Failed to reset data: ' . $e->getMessage());
        }
    }
}
