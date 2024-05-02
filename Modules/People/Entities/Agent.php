<?php

namespace Modules\People\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Agent extends Model implements HasMedia
{

    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['media'];

    public function registerMediaCollections(): void {
        $this->addMediaCollection('agents')
            ->useFallbackUrl('/images/fallback_profile_image.png');
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = Agent::max('id') + 1;
            $model->agent_code = make_reference_id('AG', $number);
        });
    }

}
