<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoinResource\Pages;
use App\Filament\Resources\PoinResource\RelationManagers;
use App\Models\Poin;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class PoinResource extends Resource
{
    protected static ?string $model = Poin::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('user_id')->label('Customer')
                        ->options(function(callable $get){
                            $outlet = User::where('is_admin', 0);
                            if(!$outlet){
                                return [];
                            }
                            return $outlet->pluck('name', 'id');
                        })
                        ->required()
                        ->placeholder('Pilih Customer'),
                    Forms\Components\TextInput::make('poin')
                        ->required()
                        ->maxLength(200),
                    Forms\Components\TextInput::make('total_pembelian')
                        ->label('Total belanja (Rp.)')
                        ->required(),
                ])
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
                Tables\Columns\TextColumn::make('user.name')->label('Customer')->searchable(),
                Tables\Columns\TextColumn::make('poin'),
                Tables\Columns\TextColumn::make('total_pembelian')->label('Total Belanja'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->label('Tanggal Update'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
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
            'index' => Pages\ListPoins::route('/'),
            'create' => Pages\CreatePoin::route('/create'),
            'edit' => Pages\EditPoin::route('/{record}/edit'),
        ];
    }    
}
