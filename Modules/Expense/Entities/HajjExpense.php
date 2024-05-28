<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class HajjExpense extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function travelcategory() {
        return $this->belongsTo(TravelExpenseCategory::class, 'category_id', 'id');
    }

    public function hajjexpensePackages() {
        return $this->hasOne(HajjPackage::class, 'id', 'package_id');
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = HajjExpense::max('id') + 1;
            $model->reference = make_reference_id('HXP', $number);
        });
    }

    public function getDateAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function setAmountAttribute($value) {
        $this->attributes['amount'] = $value;
    }

    public function getAmountAttribute($value) {
        return $value;
    }
}
