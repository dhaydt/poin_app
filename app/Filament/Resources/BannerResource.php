<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?int $navigationSort = 1;

    protected static ?string $label = 'Promo / Banner';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->columns(1)->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul banner')
                        ->maxLength(100),
                    Forms\Components\TextInput::make('title_eng')
                        ->label('Judul banner (Eng)')
                        ->maxLength(100),
                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi'),
                    Forms\Components\Textarea::make('description_eng')
                        ->label('Deskripsi (Eng)'),
                    FileUpload::make('image')
                        ->label('Banner')
                        ->directory('storage/banner')
                        ->storeFileNamesIn('banner_' . now())
                        ->placeholder('Telusuri foto'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->getStateUsing(
                        static function (stdClass $rowLoop, HasTable $livewire): string {
                            return (string) (
                                $rowLoop->iteration +
                                ($livewire->tableRecordsPerPage * (
                                    $livewire->page - 1
                                ))
                            );
                        }
                    ),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Judul'),
                Tables\Columns\TextColumn::make('title_eng')
                    ->searchable()
                    ->label('Judul (Eng)'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi'),
                Tables\Columns\TextColumn::make('description_eng')
                    ->label('Deskripsi (Eng)'),
                ImageColumn::make('image')
                    ->label('Banner'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')->tooltip('Ubah Banner'),
            Tables\Actions\DeleteAction::make()->label('')->tooltip('Hapus Banner')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
