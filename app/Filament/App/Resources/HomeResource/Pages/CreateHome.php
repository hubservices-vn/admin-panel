<?php

namespace App\Filament\App\Resources\HomeResource\Pages;

use App\Filament\App\Resources\HomeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHome extends CreateRecord
{
    protected static string $resource = HomeResource::class;
}
