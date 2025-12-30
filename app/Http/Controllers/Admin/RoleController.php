<?php
namespace App\Http\Controllers\Admin;
use App\Models\Role;
use App\Models\Permission;
use App\Forms\Fields\BelongsToManyCheckbox;
use App\Tables\Columns\BelongsToManyColumn;
use Merlion\Http\Controllers\CrudController;
class RoleController extends CrudController
{
    protected string $model = Role::class;
    protected function schemas(): array
    {
        $permissions = Permission::all()->pluck('display_name', 'id')->toArray();
        return [
            'id' => [
                'name' => 'id',
                'hideFrom' => 'create,edit',
            ],
            'name',
            'display_name',
            'description' => [
                'name' => 'description',
                'type' => 'textarea',
            ],
            'permissions' => [
                'name' => 'permissions',
                'type' => 'belongsToManyCheckbox',
                'label' => 'Permissions',
                'options' => $permissions,
                'relationship' => 'permissions',
                'gridColumns' => 3,
                'hideFrom' => 'index',
            ],
        ];
    }
    protected function columns(): array
    {
        $columns = parent::columns();
        $columns[] = BelongsToManyColumn::make('permissions', 'Permissions')
            ->relationship('permissions', 'display_name')
            ->limit(3);
        return $columns;
    }
    protected function searches(): array
    {
        return ['name', 'display_name'];
    }
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array',
        ];
    }
}