<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use App\Livewire\CategoryOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    // 1. Tempat untuk Tombol-tombol Aksi (seperti tombol "Create")
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    // 2. Tempat untuk Widget (seperti Stats Overview / Kartu Statistik)
    protected function getHeaderWidgets(): array
    {
        return [
            CategoryOverview::class,
        ];
    }
}