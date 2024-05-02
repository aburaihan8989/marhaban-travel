<?php

namespace Modules\Saving\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Saving extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function savingPayments() {
        return $this->hasMany(SavingPayment::class, 'saving_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = Saving::max('id') + 1;
            $model->reference = make_reference_id('SU', $number);
        });
    }

    public function getLastAmountAttribute($value) {
        return $value;
    }

    public function getTotalSavingAttribute($value) {
        return $value;
    }
}
