<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RespostaResource\Pages;
use App\Models\Resposta;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class RespostaResource extends Resource
{
    protected static ?string $model = Resposta::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Denúncias';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('protocolo')
                    ->required(),
                TextInput::make('senha')
                    ->password()
                    ->required(),
                TextInput::make('users_id')
                    ->label('Usuário interno')
                    ->numeric()
                    ->default(fn () => auth()->id()),
                Textarea::make('resposta')
                    ->rows(5)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('protocolo')->label('Protocolo')->searchable(),
                TextColumn::make('denuncias_id')->label('Denúncia'),
                TextColumn::make('user.name')->label('Usuário')->default('—'),
                TextColumn::make('created_at')->label('Criada em')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRespostas::route('/'),
            'create' => Pages\CreateResposta::route('/create'),
            'edit' => Pages\EditResposta::route('/{record}/edit'),
        ];
    }
}
