<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Project')
                    ->options(Project::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(Page::class, 'slug', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->nullable(),
                Forms\Components\Textarea::make('metadata')
                    ->label('Metadata')
                    ->nullable(),
                Forms\Components\Textarea::make('header')
                    ->label('Header Content')
                    ->nullable(),
                Forms\Components\Textarea::make('footer')
                    ->label('Footer Content')
                    ->nullable(),
                Forms\Components\RichEditor::make('html_content')
                    ->label('HTML Content')
                    ->required(),
                Forms\Components\Textarea::make('css')
                    ->label('CSS')
                    ->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('project.name')
                    ->label('Project')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
