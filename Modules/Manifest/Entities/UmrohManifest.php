<?php

namespace Modules\Manifest\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Package\Entities\UmrohPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UmrohManifest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function umrohPackages() {
        return $this->hasOne(UmrohPackage::class, 'id', 'package_id');
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = UmrohManifest::max('id') + 1;
            $model->reference = make_reference_id('UM', $number);
        });
    }

    public function getTotalPriceAttribute($value) {
        return $value;
    }

    public function getTotalPaymentAttribute($value) {
        return $value;
    }

    public function getRemainingPaymentAttribute($value) {
        return $value;
    }

}
