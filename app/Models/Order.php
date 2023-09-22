<?php

namespace App\Models;

use App\Enum\Order\State;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
      'amount',
      'status',
    ];

    protected $casts = [
      'status' => State::class,
    ];

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class)
            ->withPivot('count');
    }
}
