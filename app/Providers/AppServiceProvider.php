<?php
namespace App\Providers;
use App\Forms\Fields\BelongsToManyCheckbox;
use App\Tables\Columns\BelongsToManyColumn;
use Illuminate\Support\ServiceProvider;
use Merlion\Components\Form\Fields\Field;
use Merlion\Components\Table\Columns\Column;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Field::$fieldsMap['belongsToManyCheckbox'] = BelongsToManyCheckbox::class;
        Column::$columns['belongsToMany'] = BelongsToManyColumn::class;
    }
}
