<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\Insight;
use App\Models\PostTemplate;
use App\Models\Pricelist;
use App\Models\QuotationCustomer;
use App\Models\QuotationItem;
use App\Models\ReplyTemplate;
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

        foreach ($resetOptions as $option) {
            switch ($option) {
                case 'bulletin':
                    Bulletin::query()->delete(); // Deletes all rows, respects constraints
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
                    // Delete child records first due to foreign key constraints
                    DB::table('qoutotaion_terms_condtion_remarks')->delete(); // Clear related table
                    QuotationItem::query()->delete(); // Then clear items
                    QuotationCustomer::query()->delete(); // Finally clear customers
                    break;
                case 'insights':
                    Insight::query()->delete();
                    break;
            }
        }

        return redirect()->route('settings.page')->with('success', 'Selected data has been reset successfully!');
    }
}
