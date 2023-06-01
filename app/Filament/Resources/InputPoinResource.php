<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\InputPoinResource\Pages;
use App\Filament\Resources\InputPoinResource\RelationManagers;
use App\Models\Outlet;
use App\Models\PoinHistory;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
                SelectFilter::make('outlet_id')
                    ->label('Outlet')
                    ->options(Outlet::all()->pluck('name', 'id')),
                SelectFilter::make('admin_id')
                    ->label('Karyawan')
                    ->options(User::where('is_admin', 1)->pluck('name', 'id')),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Dari'),
                        Forms\Components\DatePicker::make('created_until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('Export')->fileName('InputPoin'.now()) // Default file name
                ->timeFormat('m y d') // Default time format for naming exports
                ->defaultFormat('xlsx') // xlsx, csv or pdf
                ->defaultPageOrientation('landscape') // Page orientation for pdf files. portrait or landscape
                ->directDownload() // Download directly without showing modal
                ->disableAdditionalColumns() // Disable additional columns input
                ->disableFilterColumns() // Disable filter columns input
                ->disableFileName() // Disable file name input
                ->disableFileNamePrefix() // Disable file name prefix
                ->disablePreview() // Disable export preview
                ->withHiddenColumns() //Show the columns which are toggled hidden
                ->fileNameFieldLabel('File Name') // Label for file name input
                ->formatFieldLabel('Format') // Label for format input
                ->pageOrientationFieldLabel('Page Orientation') // Label for page orientation input
                ->filterColumnsFieldLabel('filter columns') // Label for filter columns input
                ->additionalColumnsFieldLabel('Additional Columns') // Label for additional columns input
                ->additionalColumnsTitleFieldLabel('Title') // Label for additional columns' title input
                ->additionalColumnsDefaultValueFieldLabel('Default Value') // Label for additional columns' default value input
                ->additionalColumnsAddButtonLabel('Add Column') // Label for additional columns' add button,
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
