<?php

namespace App\Models; // Defines the namespace of this model

// Import necessary Laravel classes
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Define the QuotationCustomer model
class QuotationCustomer extends Model
{
    use HasFactory; // Enables Laravel's factory feature for database seeding

    // Define the table name explicitly
    protected $table = 'tbl_customers';

    // Specifies which columns are mass-assignable (prevents mass-assignment vulnerabilities)
    protected $fillable = ['customer_name', 'address', 'contact'];

    /**
     * Define a one-to-many relationship.
     * A customer can have multiple quotation items.
     *
     * this is just anotation it wont affect the code. it just tell the IDE WHAT KIND OF RELATIONSHIP IS BEING RETURN
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(QuotationItem::class, 'customer_id'); // A customer can have many quotation items
    }
}
