<?php

namespace Modules\Expense\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelExpenseCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function umrohexpenses() {
        return $this->hasMany(UmrohExpense::class, 'category_id', 'id');
    }
}
