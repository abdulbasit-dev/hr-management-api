<?php

namespace App\Traits;

use App\Models\User;
use Log;

trait ActionByTrait
{

    public static function bootActionByTrait()
    {
        if (auth()->check()) {
            static::creating(function ($model) {
                // if  its already set then don't override it
                if (empty($model->created_by)){
                    $model->created_by = auth()->id();
                }
            });

            static::updating(function ($model) {
                $model->updated_by = auth()->id();
            });
        }
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault(
            [
                'name' => '---',
            ]
        );
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault(
            [
                'name' => '---',
            ]
        );
    }
}
