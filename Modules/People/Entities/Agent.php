<?php

namespace Modules\People\Entities;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Modules\People\Entities\AgentPayment;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Manifest\Entities\UmrohManifestCustomer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Agent extends Model implements HasMedia
{

    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['media'];

    public function umrohManifestCustomers() {
        return $this->hasMany(UmrohManifestCustomer::class, 'id', 'agent_id');
    }

    public function agentPayments() {
        return $this->hasMany(AgentPayment::class, 'agent_id', 'id');
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('agents')
            ->useFallbackUrl('/images/fallback_profile_image.png');
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = Agent::max('id') + 1;
            $model->agent_code = make_reference_id('AS', $number);
        });
    }

}
