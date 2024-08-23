<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Election extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('F d, Y h:i A', strtotime($value)),
        );
    }

    protected function endDate(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('F d, Y h:i A', strtotime($value)),
        );
    }

    public function users(): HasMany
    {
        return $this->HasMany(User::class);
    }

    public function candidates(): HasMany
    {
        return $this->HasMany(Candidate::class);
    }
}
