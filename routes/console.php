<?php

use App\Data;

Artisan::command('alerj:update-data', function () {
    Data::update();
})->describe('Update data from webservices');
