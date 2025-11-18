<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpcomingStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_name',
        'incoming_quantity',
        'expected_arrival',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 🔹 Helper function para madaling i-convert to Product
    public function toProduct()
    {
        return [
            'title' => $this->product_name,
            'description' => 'Auto-moved from Upcoming Stock',
            'category_id' => $this->category_id,
            'price' => 0, // default muna, pwede mong palitan kung gusto mong may presyo agad
            'stock' => $this->incoming_quantity,
            'image' => $this->image,
        ];
    }
}
