<?php

namespace Modules\People\Entities;

use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Modules\People\Entities\Agent;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AgentPayment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['media'];

    public function agents() {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('rewards')
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

    public function scopeByAgent($query) {
        return $query->where('agent_id', request()->route('agent_id'));
    }
}
