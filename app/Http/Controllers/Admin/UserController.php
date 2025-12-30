<?php
namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Role;
use App\Forms\Fields\BelongsToManyCheckbox;
use App\Tables\Columns\BelongsToManyColumn;
use Merlion\Components\Table\Columns\Column;
use Merlion\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Hash;
class UserController extends CrudController
{
    protected string $model = User::class;
    protected function schemas(): array
    {
        $roles = Role::all()->pluck('display_name', 'id')->toArray();
        return [
            'id' => [
                'name' => 'id',
                'hideFrom' => 'create,edit',
            ],
            'name',
            'email',
            'password' => [
                'name' => 'password',
                'type' => 'text',
                'inputType' => 'password',
                'showOn' => 'create,edit',
            ],
            'roles' => [
                'name' => 'roles',
                'type' => 'belongsToManyCheckbox',
                'label' => 'Roles',
                'options' => $roles,
                'relationship' => 'roles',
                'gridColumns' => 2,
                'showOn' => 'create,edit',
            ],
        ];
    }
    protected function columns(): array
    {
        // Only show id, name, email columns from schema
        $columns = [
            Column::generate('id'),
            Column::generate('name'),
            Column::generate('email'),
        ];
        // Add custom roles column for list display
        $columns[] = BelongsToManyColumn::make('roles', 'Roles')
            ->relationship('roles', 'display_name')
            ->limit(3);
        return $columns;
    }
    protected function searches(): array
    {
        return ['name', 'email'];
    }
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8',
            'roles' => 'array',
        ];
    }
    protected function createOrUpdate($form)
    {
        $model = $form->getModel();
        $fields = $form->getFlatFields();
        $isNew = is_string($model) || empty($model->getKey());
        if ($isNew) {
            $model = new $model;
        }
        foreach ($fields as $field) {
            if ($field->getRelationship()) {
                continue;
            }
            $name = $field->getName();
            // Handle password field
            if ($name === 'password') {
                $password = $field->getDataFromRequest();
                if (!empty($password)) {
                    $model->password = Hash::make($password);
                }
                continue;
            }
            $field->save($model);
        }
        $model->save();
        foreach ($fields as $field) {
            if (!$field->getRelationship()) {
                continue;
            }
            $field->saveRelationship($model);
        }
    }
}
