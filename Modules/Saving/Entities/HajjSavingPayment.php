<?php

namespace Modules\Saving\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class HajjSavingPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hajjsavings() {
        return $this->belongsTo(HajjSaving::class, 'saving_id', 'id');
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

    public function scopeByHajjSaving($query) {
        return $query->where('saving_id', request()->route('saving_id'));
    }
}
