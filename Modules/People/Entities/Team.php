<?php

namespace Modules\People\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Team extends Model implements HasMedia
{

    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['media'];

    public function registerMediaCollections(): void {
        $this->addMediaCollection('teams')
            ->useFallbackUrl('/images/fallback_profile_image.png');
    }

    // public static function boot() {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $number = Team::max('id') + 1;
    //         $model->team_code = make_reference_id('TM', $number);
    //     });
    // }

}
