<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('expense_date')
                    ->required(),
                Select::make('category')
                    ->options([
                        'salary' => 'Salary',
                        'rent' => 'Rent',
                        'electricity' => 'Electricity',
                        'water' => 'Water',
                        'internet' => 'Internet',
                        'transportation' => 'Transportation',
                        'office' => 'Office Supplies',
                        'others' => 'Others',
                    ])
                    ->required(),
                TextInput::make('description')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Hidden::make('created_by')
                    ->default(fn() => Auth::id()),
            ]);
    }
}
