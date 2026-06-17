<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup as ActionsBulkActionGroup;
use Filament\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn; // Import komponen kolom tabel
use Filament\Tables\Actions\EditAction; // Import Action khusus Table
use Filament\Tables\Actions\BulkActionGroup; 
use Filament\Tables\Actions\DeleteBulkAction; 

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Tambahkan kolom di bawah ini agar data muncul di web
                TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('description')
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tempat filter jika dibutuhkan nanti
            ])
            ->actions([ // Menggunakan ->actions() bukan ->recordActions() untuk tombol baris
                ActionsEditAction::make(),
            ])
            ->bulkActions([ // Menggunakan ->bulkActions() bukan ->toolbarActions() untuk bulk
                ActionsBulkActionGroup::make([
                    ActionsDeleteBulkAction::make(),
                ]),
            ]);
    }
}