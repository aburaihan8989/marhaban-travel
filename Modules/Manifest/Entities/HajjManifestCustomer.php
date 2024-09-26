<?php

namespace Modules\Manifest\Entities;

use Modules\People\Entities\Agent;
use Modules\People\Entities\Customer;
use Illuminate\Database\Eloquent\Model;
use Modules\Package\Entities\HajjPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HajjManifestCustomer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hajjManifestPayments() {
        return $this->hasMany(HajjManifestPayment::class, 'id', 'hajj_manifest_customer_id');
    }

    public function hajjCustomers() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function umrohAgents() {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    public function hajjPackages() {
        return $this->hasOne(HajjPackage::class, 'id', 'package_id');
    }

    public function packages() {
        return $this->belongsTo(HajjPackage::class, 'package_id', 'id');
    }

    public function agents() {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = HajjManifestCustomer::max('id') + 1;
            $model->reference = make_reference_id('CM', $number);
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
