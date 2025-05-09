<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\CategoryResource;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    
    protected static ?string $navigationGroup = 'Menu principal';
    protected static ?string $navigationLabel = 'Productos';
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    
    protected static ?string $slug = "productos";
    protected static ?string $label = "Producto";
    protected static ?string $pluralLabel = "Productos";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del producto')
                    ->schema([

                        Toggle::make('is_active')
                            ->label('¿Esta activo?')
                            ->default(true),

                        TextInput::make('code')
                            ->label('Codigo')
                            ->required()
                            ->maxLength(20)
                            ->unique(table: 'products', column: 'code', ignorable: fn($record) => $record)
                            ->placeholder('Ej: FIC-001')
                            ->rules(
                                ['unique:products,code']
                            )
                            ->validationMessages([
                                'unique' => 'El código ya existe, por favor ingrese otro.'
                            ]),

                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('summary')
                            ->label('Resumen')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('price')
                            ->label('Precio de venta')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->suffix('Bs'),

                        Select::make('category_id')
                            ->label("Categoria")
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm(
                                CategoryResource::getFormSchema(),
                            ),
                    ]),
                Section::make('Imagen del producto')
                    ->schema([
                        FileUpload::make('image')
                            ->disk('public')
                            ->label('Imagen')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->maxSize(1024)
                            ->acceptedFileTypes(['image/*'])
                            ->required()
                    ]),

                Section::make('Descripción detallada')
                    ->schema([
                        RichEditor::make('description')
                            ->label("Descripción")
                            ->required()
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Codigo')
                    ->searchable(),

                ImageColumn::make('image')
                    ->label('Imagen')
                    ->size(50),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),

                TextColumn::make('summary')
                    ->label('Resumen'),

                TextColumn::make('is_active')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string  => $state ? 'Activo' : 'Inactivo'),

                TextColumn::make('created_at')
                    ->label('Fecha de creación'),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
