<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingTrxResource\Pages;
use App\Filament\Resources\BookingTrxResource\RelationManagers;
use App\Models\BookingTransaction;
use App\Models\BookingTrx;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingTrxResource extends Resource
{
    protected static ?string $model = BookingTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                TextInput::make('phone_number')
                    ->numeric()
                    ->maxLength(15),
                TextInput::make('booking_trx')
                    ->required(),
                Select::make('office_space_id')
                    ->relationship('office_space','name')
                    ->required(),
                TextInput::make('duration')
                    ->required()
                    ->numeric()
                    ->prefix('Days'),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),
                DatePicker::make('started_at')
                    ->required(),
                DatePicker::make('ended_at')
                    ->required(),
                Select::make('is_paid')
                    ->options([
                        true => 'Paid',
                        false => 'Not Paid'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->searchable()
                ->label('Nama'),
                TextColumn::make('booking_trx')
                ->searchable()
                ->label('Booking ID'),
                TextColumn::make('office_space.name')
                ->label('Office'),
                IconColumn::make('is_paid')
                ->boolean()
                ->trueColor('success')
                ->falseColor('danger')
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->label('Sudah Bayar?')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookingTrxes::route('/'),
            'create' => Pages\CreateBookingTrx::route('/create'),
            'edit' => Pages\EditBookingTrx::route('/{record}/edit'),
        ];
    }
}
