<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resource;
use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

final class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Articles';
    protected static ?string $navigationLabel = 'Comments';

    public static function getNavigationBadge(): ?string
    {
        $count = Comment::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Placeholder::make('name')->content(fn (Comment $record): string => $record->name),
            Placeholder::make('email')->content(fn (Comment $record): string => $record->email),
            Textarea::make('body')->required()->maxLength(5000)->columnSpanFull(),
            Select::make('status')->options(['pending' => __('Pending'), 'approved' => __('Approved'), 'spam' => __('Spam')])->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('created_at', 'desc')->columns([
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('email')->searchable(),
            Tables\Columns\TextColumn::make('post.id')->label('Post ID')->sortable(),
            Tables\Columns\TextColumn::make('body')->limit(80)->searchable(),
            Tables\Columns\TextColumn::make('status')->badge()->formatStateUsing(fn (string $state): string => __(ucfirst($state))),
            Tables\Columns\TextColumn::make('locale'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')->options(['pending' => __('Pending'), 'approved' => __('Approved'), 'spam' => __('Spam')]),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
