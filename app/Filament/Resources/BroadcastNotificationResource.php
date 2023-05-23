<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BroadcastNotificationResource\Pages;
use App\Filament\Resources\BroadcastNotificationResource\RelationManagers;
use App\Models\BroadcastNotification;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class BroadcastNotificationResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'broadcast';
    protected static ?string $label = 'Broadcast Notification';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->tableRecordsPerPage * (
                                $livewire->page - 1
                            ))
                        );
                    }
                ),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->label('No Handphone'),
                // Tables\Columns\TextColumn::make('birthday')
                //     ->label('Tanggal lahir')
                //     ->date(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Kelamin'),
                // Tables\Columns\TextColumn::make('roles.name')
                //     ->label('Hak Akses'),
                Tables\Columns\TextColumn::make('occupation')
                    ->label('Pekerjaan'),
                Tables\Columns\TextColumn::make('province')
                    ->label('Provinsi'),
                Tables\Columns\TextColumn::make('city')
                    ->label('Kota'),
                // Tables\Columns\TextColumn::make('address')
                //   
            ])
            ->filters([
                SelectFilter::make('province')
                    ->query(fn(Builder $query): Builder => $query->where('province',))
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->where('is_admin', 0);
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
            'index' => Pages\ListBroadcastNotifications::route('/'),
            'create' => Pages\CreateBroadcastNotification::route('/create'),
            'edit' => Pages\EditBroadcastNotification::route('/{record}/edit'),
        ];
    }    
}
