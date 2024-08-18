<?php

namespace App\Filament\App\Resources\HomeResource\Pages;

use App\Filament\App\Resources\HomeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomes extends ListRecords
{
    protected static string $resource = HomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
