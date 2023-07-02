<?php

namespace App\Filament\Resources;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\CPU\Helpers;
use App\Filament\Resources\PoinResource\Pages;
use App\Filament\Resources\PoinResource\RelationManagers;
use App\Models\Poin;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpOption\None;
use stdClass;

class PoinResource extends Resource
{
    protected static ?string $model = Poin::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Poin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('user_id')->label('Customer')
                        ->options(function (callable $get) {
                            $outlet = User::where('is_admin', 0);
                            if (!$outlet) {
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
        Helpers::refresh_all_total();

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
                Tables\Columns\TextColumn::make('user.name')->label('Customer')->searchable(),
                ViewColumn::make('id')->label('Poin Awal')->view('filament.tables.columns.poinawal-view'),
                ViewColumn::make('user_id')->label('Total Redeem')->view('filament.tables.columns.redeem-view'),
                Tables\Columns\TextColumn::make('poin'),
                Tables\Columns\TextColumn::make('total_pembelian')->label('Total Belanja')->formatStateUsing(fn (string $state): string => __(number_format("{$state}"))),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->label('Tanggal Update'),
            ])
            ->filters([
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
                Action::make('history')
                    ->url(fn (Poin $record): string => 'poins/history?id='.$record['user_id'])
                    ->openUrlInNewTab()
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
                FilamentExportBulkAction::make('Export')->fileName('InputPoin' . now()) // Default file name
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
            'history' => Pages\HistoryPoin::route('/history')
        ];
    }
}
