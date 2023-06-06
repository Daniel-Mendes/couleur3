<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperWinner
 */
class Winner extends Model
{
    use HasFactory;

    protected $fillable = [
        'interaction_id',
        'auditor_id',
    ];

    public function interaction()
    {
        return $this->belongsTo(Interaction::class);
    }

    public function auditor()
    {
        return $this->belongsTo(Auditor::class);
    }
}
