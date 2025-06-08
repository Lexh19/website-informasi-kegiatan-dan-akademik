<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Beranda;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\BerandaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BerandaResource\RelationManagers;

class BerandaResource extends Resource
{
    protected static ?string $model = Beranda::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Beranda';
    protected static ?string $modelLabel = 'Beranda';
    protected static ?string $slug = 'beranda';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\ImageColumn::make('image')
                ->url(fn ($record) => asset('storage/' . $record->image))
                ->label('Gambar'),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->label('Dibuat'),
                TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->label('Diperbarui'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()->after(function (Collection
                         $records) {
                foreach ($records as $key => $value) {
                    if($value->image){
                        Storage::disk('public')->delete($value->image);
                    }
                }
            }
        ),
                ]),
            ]);
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
            'index' => Pages\ListBerandas::route('/'),
            'create' => Pages\CreateBeranda::route('/create'),
            'edit' => Pages\EditBeranda::route('/{record}/edit'),
        ];
    }
}
