<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\RelationManagers\PagesRelationManager;
use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('domain')
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description'),
                Forms\Components\Textarea::make('head_script')
                    ->label('Head Script')
                    ->rows(5),
                Forms\Components\Textarea::make('footer_script')
                    ->label('Footer Script')
                    ->rows(5),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('domain')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('F j, Y') // Format the timestamp as a human-readable date
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('F j, Y') // Format the timestamp as a human-readable date
                    ->sortable(),
            ])
            ->filters([
                Filter::make('updated_at')
                    ->form([
                        Forms\Components\DatePicker::make('updated_from')
                            ->label('Updated From'),
                        Forms\Components\DatePicker::make('updated_until')
                            ->label('Updated Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['updated_from'], fn ($query, $date) => $query->whereDate('updated_at', '>=', $date))
                            ->when($data['updated_until'], fn ($query, $date) => $query->whereDate('updated_at', '<=', $date));
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
