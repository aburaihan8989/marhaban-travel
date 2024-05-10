<?php

namespace Modules\People\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Customer extends Model implements HasMedia
{

    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['media'];

    // public function umrohManifestCustomers() {
    //     return $this->hasMany(UmrohManifestCustomer::class, 'id', 'customer_id');
    // }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('photos')
            ->useFallbackUrl('/images/fallback_profile_image.png');
    }

    protected static function newFactory() {
        return \Modules\People\Database\factories\CustomerFactory::new();
    }

}
