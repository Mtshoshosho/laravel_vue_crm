<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Item;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }

    // public function scopeSearchPurchases($query, $input = null)
    // { // scopeSearchPurchasesメソッドは、検索条件として入力された文字列をもとに、顧客情報のカナ名または電話番号が一致するデータを検索して返します。
    //     if (!empty($input)) {
    //         if (Purchase::whereHas('customer', function ($query) use ($input) {
    //             $query->where('kana', 'like', $input . '%')
    //                 ->orWhere('tel', 'like', $input . '%');
    //         })->exists()) {
    //             return $query->whereHas('customer', function ($query) use ($input) {
    //                 $query->where('kana', 'like', $input . '%')
    //                     ->orWhere('tel', 'like', $input . '%');
    //             });
    //         }
    //     }
    // }
}
