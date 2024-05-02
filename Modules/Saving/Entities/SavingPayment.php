<?php

namespace Modules\Saving\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class SavingPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function savings() {
        return $this->belongsTo(Saving::class, 'saving_id', 'id');
    }

    public function setAmountAttribute($value) {
        $this->attributes['amount'] = $value;
    }

    public function getAmountAttribute($value) {
        return $value;
    }

    public function getDateAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function scopeBySaving($query) {
        return $query->where('saving_id', request()->route('saving_id'));
    }
}
