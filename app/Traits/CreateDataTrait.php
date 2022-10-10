<?php

namespace App\Traits;

use App\Models\Uuid;
use Illuminate\Support\Str;


trait CreateDataTrait {


    public function createUuid() {
        $uuid = $this->generateUuid();
        Uuid::create(['uuid'=> $uuid ]);
        return $uuid;
    }

    public function generateUuid() {
        return Str::uuid(now());
    }

}
