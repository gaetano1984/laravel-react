<?php

namespace App\Filament\Resources\RestaurantResource\Pages;

use App\Filament\Resources\RestaurantResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Override;

class EditRestaurant extends EditRecord
{
    protected static string $resource = RestaurantResource::class;

    private $dataToSync = [];

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    #[Override]
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $dishes = [];
        foreach($data as $k=>$v){
            if(strpos($k, 'menu_categoria_')!==FALSE){
                $dishes = array_merge($dishes, $v);
            }
        }
        $this->dataToSync = $dishes;
        return $data;
    }

    protected function afterSave(){
        $this->getRecord()->dishes()->sync($this->dataToSync);
    }
}
