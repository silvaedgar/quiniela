<?php

namespace App\Traits;



trait LogsTrait {

    public function generateLog($log,$properties=[]) {

        $user = ['user' => auth()->user()->name];
        $properties = ['attributes'=> array_merge($properties,$user)];
        activity()
            ->causedBy(auth()->user()->id)
            ->withProperties($properties)
            ->log($log);
        return ;
    }

}
