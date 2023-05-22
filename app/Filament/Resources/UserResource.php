<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions\DeleteAction;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $label = 'Customer';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->columns(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->label('Nama')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->label('Email')
                        ->required()
                        ->unique()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->unique()
                        ->label('No Handphone')
                        ->maxLength(20),
                    Forms\Components\DatePicker::make('birthday')
                        ->label('Tanggal Lahir'),
                    Forms\Components\Select::make('gender')
                        ->options(['laki-laki' => 'Laki - Laki', 'perempuan' => 'Perempuan'])
                        ->placeholder('Pilih jenis kelamin')
                        ->label('Jenis Kelamin'),
                    Forms\Components\TextInput::make('occupation')
                        ->label('Pekerjaan')
                        ->maxLength(20),
                    Forms\Components\TextInput::make('province')
                        ->label('Provinsi')
                        ->maxLength(20),
                    Forms\Components\TextInput::make('city')
                        ->label('Kota')
                        ->maxLength(20),
                    Forms\Components\TextInput::make('address')
                        ->label('Alamat')
                        ->maxLength(200),
                    Select::make('roles')->multiple()->label('Hak Akses')->placeholder('Pilih hak akses')->relationship('roles', 'name',  fn (Builder $query) => $query->where('name', 'customer'))->preload()->required(),
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
                // Tables\Columns\TextColumn::make('gender')
                //     ->label('Kelamin'),
                // Tables\Columns\TextColumn::make('roles.name')
                //     ->label('Hak Akses'),
                Tables\Columns\TextColumn::make('occupation')
                    ->label('Pekerjaan'),
                // Tables\Columns\TextColumn::make('province')
                //     ->label('Provinsi'),
                // Tables\Columns\TextColumn::make('city')
                //     ->label('Kota'),
                // Tables\Columns\TextColumn::make('address')
                //     ->label('Alamat'),
            ])
            ->filters([
                // 
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->tooltip('Lihat Customer'),
                Tables\Actions\EditAction::make()->label('')->tooltip('Ubah Customer'),
                Tables\Actions\DeleteAction::make()->label('')->tooltip('Hapus Customer')
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getTranslatableLocales(): array
    {
        return ['en', 'id'];
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
