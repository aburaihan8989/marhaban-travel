<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class UmrohExpense extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function travelcategory() {
        return $this->belongsTo(TravelExpenseCategory::class, 'category_id', 'id');
    }

    public function umrohexpensePackages() {
        return $this->hasOne(UmrohPackage::class, 'id', 'package_id');
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = UmrohExpense::max('id') + 1;
            $model->reference = make_reference_id('UXP', $number);
        });
    }

    public function getDateAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function setAmountAttribute($value) {
        $this->attributes['amount'] = ($value * 100);
    }

    public function getAmountAttribute($value) {
        return ($value / 100);
    }
}
