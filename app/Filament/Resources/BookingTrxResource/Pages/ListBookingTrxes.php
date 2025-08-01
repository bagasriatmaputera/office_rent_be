<?php

namespace App\Filament\Resources\BookingTrxResource\Pages;

use App\Filament\Resources\BookingTrxResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookingTrxes extends ListRecords
{
    protected static string $resource = BookingTrxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
