<?php

namespace App\Models; // Defines the namespace of this model

// Import necessary Laravel classes
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Define the QuotationItem model
class QuotationItem extends Model
{
    use HasFactory; // Enables Laravel's factory feature for database seeding

    // Define the table name explicitly
    protected $table = 'tbl_items';

    // Specifies which columns are mass-assignable (prevents mass-assignment vulnerabilities)
    protected $fillable = ['customer_id', 'quantity', 'unit', 'item_name', 'line_amount', 'attn', 'date', 'terms', 'quotation_no'];

    /**
     * Define a many-to-one relationship.
     * Each quotation item belongs to one customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(QuotationCustomer::class, 'customer_id'); // Each item belongs to one customer // Each item belongs to one customer
    }
}
