<?php

namespace Modules\Manifest\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Package\Entities\HajjPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HajjManifest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hajjPackages() {
        return $this->hasOne(HajjPackage::class, 'id', 'package_id');
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = HajjManifest::max('id') + 1;
            $model->reference = make_reference_id('HM', $number);
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
