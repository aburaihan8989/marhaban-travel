<?php

namespace Modules\Package\Entities;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
// use Modules\Product\Notifications\NotifyQuantityAlert;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Manifest\Entities\UmrohManifest;
use Modules\Manifest\Entities\UmrohManifestCustomer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UmrohPackage extends Model implements HasMedia
{

    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['media'];

    public function umrohCustomer() {
        return $this->hasMany(UmrohManifestCustomer::class, 'package_id', 'id');
    }

    public function umrohManifest() {
        return $this->belongsTo(UmrohManifest::class, 'package_id', 'id');
    }

    public function umrohExpense() {
        return $this->belongsTo(UmrohExpense::class, 'package_id', 'id');
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('brosurs')
            ->useFallbackUrl('/images/fallback_product_image.png');
    }

    public function registerMediaConversions(Media $media = null): void {
        $this->addMediaConversion('thumb')
            ->width(50)
            ->height(50);
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = UmrohPackage::max('id') + 1;
            $model->package_code = make_reference_id('UP', $number);
        });
    }


    public function setPackageCostAttribute($value) {
        $this->attributes['package_cost'] = ($value * 100);
    }

    public function getPackageCostAttribute($value) {
        return ($value / 100);
    }

    public function setPackagePriceAttribute($value) {
        $this->attributes['package_price'] = ($value * 100);
    }

    public function getPackagePriceAttribute($value) {
        return ($value / 100);
    }
}
