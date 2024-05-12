<?php

namespace Modules\Manifest\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HajjManifestPayment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['media'];

    public function hajjManifestCustomers() {
        return $this->belongsTo(HajjManifestCustomer::class, 'hajj_manifest_customer_id', 'id');
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('payments')
            ->useFallbackUrl('/images/fallback_product_image.png');
    }

    public function registerMediaConversions(Media $media = null): void {
        $this->addMediaConversion('thumb')
            ->width(50)
            ->height(50);
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

    public function scopeByHajjManifestCustomer($query) {
        return $query->where('hajj_manifest_customer_id', request()->route('hajj_manifest_customer_id'));
    }
}
