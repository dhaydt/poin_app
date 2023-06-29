<?php

namespace App\Filament\Resources;

use App\CPU\Helpers;
use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\RelationManagers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Models\Admin;
use App\Models\Outlet;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use stdClass;

class AdminResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'admins';

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 7;
    protected static ?string $label = 'Admin';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationGroup = 'Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->columns(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(ignorable: fn ($record) => $record)
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->default('123456')->hidden(),
                    Forms\Components\TextInput::make('phone')
                        ->label('Nomor Handphone')
                        ->tel()
                        ->unique(ignorable: fn ($record) => $record)
                        ->maxLength(20),
                    Select::make('outlet_id')->label('Outlet')
                        ->options(function(callable $get){
                            $outlet = Outlet::get();
                            if(!$outlet){
                                return [];
                            }
                            return $outlet->pluck('name', 'id');
                        })
                        ->placeholder('Pilih Outlet'),
                    Select::make('roles')
                        ->label('Hak Akses')
                        ->placeholder('Pilih hak akses')
                        ->multiple()
                        ->relationship('roles', 'name',  fn (Builder $query) => $query->where('name', '!=', 'customer'))
                        ->preload()
                        ->default(2),
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
            Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
            Tables\Columns\TextColumn::make('phone')->label('No Handphone')->searchable(),
            Tables\Columns\TextColumn::make('roles.name')->label('Hak Akses'),
            Tables\Columns\TextColumn::make('outlet.name'),
        ])
        ->filters([
            // 
        ])
        ->actions([
            Tables\Actions\EditAction::make()->label('')->tooltip('Ubah Admin'),
            Tables\Actions\DeleteAction::make()->label('')->tooltip('Hapus Admin')
        ])
        ->bulkActions([
            // Tables\Actions\DeleteBulkAction::make(),
        ]);
    }
    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->where('is_admin', 1);
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }    
}
