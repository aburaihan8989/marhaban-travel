<?php

namespace Modules\Saving\Entities;

use Modules\People\Entities\Agent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HajjSaving extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hajjsavingPayments() {
        return $this->hasMany(HajjSavingPayment::class, 'saving_id', 'id');
    }

    public function umrohAgents() {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = HajjSaving::max('id') + 1;
            $model->reference = make_reference_id('SH', $number);
        });
    }

    public function getLastAmountAttribute($value) {
        return $value;
    }

    public function getTotalSavingAttribute($value) {
        return $value;
    }
}
