<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InputPoinResource\Pages;
use App\Filament\Resources\InputPoinResource\RelationManagers;
use App\Models\PoinHistory;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class InputPoinResource extends Resource
{
    protected static ?string $model = PoinHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-sort-ascending';
    protected static ?string $label = 'Transaksi input poin';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')->getStateUsing(
                    static function (stdClass $rowLoop, HasTable $livewire): string {
                        return (string) ($rowLoop->iteration +
                            ($livewire->tableRecordsPerPage * ($livewire->page - 1
                            ))
                        );
                    }
                ),
                Tables\Columns\TextColumn::make('outlet.name')
                    ->label('Outlet')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.phone')
                    ->label('No HP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('admin.name')
                    ->label('Karyawan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_receipt')
                    ->label('No Receipt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pembelian')
                    ->label('Pembelian')
                    ->formatStateUsing(fn (string $state): string => __(number_format("{$state}"))),
                Tables\Columns\TextColumn::make('poin')
                    ->label('Poin'),
                BooleanColumn::make('isredeem')
                    ->disabled()
                    ->label('Sudah diredeem ?'),
                BooleanColumn::make('isexpired')
                    ->disabled()
                    ->label('Sudah expire ?'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->where('type', 'add')->orderBy('created_at', 'desc');
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
            'index' => Pages\ListInputPoins::route('/'),
            'create' => Pages\CreateInputPoin::route('/create'),
            'edit' => Pages\EditInputPoin::route('/{record}/edit'),
        ];
    }
}
