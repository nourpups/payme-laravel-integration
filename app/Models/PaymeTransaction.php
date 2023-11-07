<?php

namespace App\Models;

use App\Enum\Payme\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymeTransaction extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'transaction',
        'order_id',
        'code',
        'state',
        'amount',
        'reason',
        'pay_time',
        'create_time',
        'perform_time',
        'cancel_time',
    ];
    const TIMEOUT = 43_200_000;

    protected $casts = [
        'state' => State::class,
        'transaction' => 'string',
        'create_time' => 'integer',
        'perform_time' => 'integer',
        'cancel_time' => 'integer',
        'reason' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool {
        $expireTime = self::TIMEOUT + $this->create_time;
        return time()  >= ($expireTime / 1000);
    }

    public function allowCancel(): bool
    {
        // cancel allowing logic
        return true;
    }
}
