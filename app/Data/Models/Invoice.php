<?php

namespace App\Data\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Photon\Foundation\Eloquent\Model;

class Invoice extends Model
{
    public function tenant():BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id','id' );
    }

    public function landlord():BelongsTo
    {
        return $this->belongsTo(User::class, 'landlord_id','id' );
    }
}
