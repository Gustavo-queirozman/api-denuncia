<?php

namespace App\Filament\Resources\DenunciaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class RespostasRelationManager extends RelationManager
{
    protected static string $relationship = 'respostas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('resposta')
                    ->label('Resposta')
                    ->rows(4)
                    ->required(),
                Hidden::make('users_id')
                    ->default(fn () => auth()->id()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#'),
                TextColumn::make('resposta')->label('Resposta')->limit(80),
                TextColumn::make('user.name')->label('Usuário')->default('—'),
                TextColumn::make('created_at')->label('Criada em')->dateTime(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
