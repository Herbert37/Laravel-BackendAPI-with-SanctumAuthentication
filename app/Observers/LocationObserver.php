<?php

namespace App\Observers;

use App\Models\Location;

class LocationObserver
{
    /**
     * Handle the location "created" event.
     *
     * @param  \App\Models\Location  $location
     * @return void
     */
    public function created(Location $location)
    {
        //
    }
}
