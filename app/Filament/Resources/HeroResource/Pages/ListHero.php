<?php

namespace App\Filament\Resources\HeroResource\Pages;

use Filament\Actions;
use App\Filament\Resources\HeroResource;
use Filament\Resources\Pages\ListRecords;

class ListHero extends ListRecords
{
    protected static string $resource = HeroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
