<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DenunciaResource\Pages;
use App\Filament\Resources\DenunciaResource\RelationManagers\RespostasRelationManager;
use App\Models\Denuncia;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class DenunciaResource extends Resource
{
    protected static ?string $model = Denuncia::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationGroup = 'Denúncias';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('protocolo')
                        ->label('Protocolo')
                        ->disabled()
                        ->dehydrated(false),
                    TextInput::make('departamentos_id')
                        ->label('Departamento')
                        ->numeric()
                        ->required(),
                    Select::make('status_id')
                        ->label('Status')
                        ->options([
                            1 => 'Nova',
                            2 => 'Em análise',
                            3 => 'Concluída',
                        ])
                        ->required(),
                    Textarea::make('denuncia')
                        ->label('Descrição')
                        ->rows(6)
                        ->required(),
                    TextInput::make('senha')
                        ->label('Senha de acompanhamento')
                        ->password()
                        ->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('protocolo')->label('Protocolo')->searchable()->sortable(),
                TextColumn::make('departamentos_id')->label('Departamento')->sortable(),
                TextColumn::make('status_id')->label('Status')->sortable(),
                TextColumn::make('created_at')->label('Criado em')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status_id')
                    ->label('Status')
                    ->options([
                        1 => 'Nova',
                        2 => 'Em análise',
                        3 => 'Concluída',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RespostasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDenuncias::route('/'),
            'create' => Pages\CreateDenuncia::route('/create'),
            'view' => Pages\ViewDenuncia::route('/{record}'),
            'edit' => Pages\EditDenuncia::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest();
    }
}
