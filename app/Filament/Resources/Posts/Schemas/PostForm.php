<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Пользователь')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                TextInput::make('title')
                    ->label('Заголовок')
                    ->maxLength(255)
                    ->required(),
                Textarea::make('text')
                    ->label('Текст поста')
                    ->rows(8)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
