<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatalogResource\Pages;
use App\Filament\Resources\CatalogResource\RelationManagers;
use App\Models\Catalog;
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

class CatalogResource extends Resource
{
    protected static ?string $model = Catalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-template';
    protected static ?string $label = "Katalog";
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\TextInput::make('name_eng')
                        ->label('Nama (Eng)')
                        ->maxLength(100),
                    Forms\Components\TextInput::make('price')
                        ->numeric()
                        ->label('Harga')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\Textarea::make('description')->label('Deskripsi'),
                    Forms\Components\Textarea::make('description_eng')->label('Deskripsi (Eng)'),
                    FileUpload::make('image')
                        ->label('Foto')
                        ->directory('storage/catalog')
                        ->storeFileNamesIn('catalog_' . now())
                        ->required()
                        ->placeholder('Telusuri foto'),
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
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('name_eng')->label('Nama (Eng)')->searchable(),
                Tables\Columns\TextColumn::make('price')->label('Harga')->formatStateUsing(fn (string $state): string => __(number_format("{$state}"))),
                Tables\Columns\TextColumn::make('description')->label('Deskripsi')->wrap()->words(30),
                Tables\Columns\TextColumn::make('description_eng')->label('Deskripsi (Eng)')->wrap()->words(30),
                ImageColumn::make('image')->label('Foto'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('')->tooltip('Ubah Katalog'),
                Tables\Actions\DeleteAction::make()->label('')->tooltip('Hapus Katalog')
            ])
            ->bulkActions([
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
            'index' => Pages\ListCatalogs::route('/'),
            'create' => Pages\CreateCatalog::route('/create'),
            'edit' => Pages\EditCatalog::route('/{record}/edit'),
        ];
    }
}
