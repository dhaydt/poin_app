<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoinRewardResource\Pages;
use App\Filament\Resources\PoinRewardResource\RelationManagers;
use App\Models\PoinReward;
use App\Models\Reward;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class PoinRewardResource extends Resource
{
    protected static ?string $model = Reward::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $label = 'Poin Reward';

    protected static ?string $navigationGroup = 'Poin';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('poin')->label('Poin')->disabled(),
                    Textarea::make('reward')->label('Reward'),
                    Textarea::make('reward_eng')->label('Reward (Eng)')
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
                TextColumn::make('poin'),
                TextColumn::make('reward'),
                TextColumn::make('reward_eng')->label('Reward (Eng)')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')->tooltip('Ubah reward'),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPoinRewards::route('/'),
            'create' => Pages\CreatePoinReward::route('/create'),
            // 'edit' => Pages\EditPoinReward::route('/{record}/edit'),
        ];
    }    
}
