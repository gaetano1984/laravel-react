<?php

namespace App\Filament\Resources\DishCategoryResource\Pages;

use App\Filament\Resources\DishCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDishCategories extends ListRecords
{
    protected static string $resource = DishCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
