<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedeemPoinResource\Pages;
use App\Filament\Resources\RedeemPoinResource\RelationManagers;
use App\Models\Poin;
use App\Models\PoinHistory;
use App\Models\RedeemPoin;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class RedeemPoinResource extends Resource
{
    protected static ?string $model = PoinHistory::class;
    protected static ?string $slug = 'redeem_poin';
    protected static ?string $navigationIcon = 'heroicon-o-refresh';
    protected static ?string $label = 'Transaksi tukar poin';

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
                Tables\Columns\TextColumn::make('admin.name')
                    ->label('Karyawan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('poin')
                    ->label('Poin'),
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
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->where('type', 'redeem')->orderBy('created_at', 'desc');
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRedeemPoins::route('/'),
            'create' => Pages\CreateRedeemPoin::route('/create'),
            'edit' => Pages\EditRedeemPoin::route('/{record}/edit'),
        ];
    }    
}
