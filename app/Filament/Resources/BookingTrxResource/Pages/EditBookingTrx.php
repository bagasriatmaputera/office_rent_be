<?php

namespace App\Filament\Resources\BookingTrxResource\Pages;

use App\Filament\Resources\BookingTrxResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookingTrx extends EditRecord
{
    protected static string $resource = BookingTrxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
