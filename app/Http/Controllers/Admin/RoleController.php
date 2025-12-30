<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Merlion\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class RoleController extends CrudController
{
    protected string $model = Role::class;

    protected function schemas(): array
    {
        $permissions = Permission::all()->pluck('display_name', 'id')->toArray();
        
        return [
            'id',
            'name',
            'display_name',
            'description',
            [
                'name' => 'permissions',
                'type' => 'custom_checkbox',
                'label' => 'Permissions',
                'options' => $permissions,
                'description' => 'Select permissions for this role'
            ]
        ];
    }

    protected function searches(): array
    {
        return ['name', 'display_name'];
    }
    
    public function store(...$args)
    {
        $request = request();
        $validated = $request->validate($this->rules());
        $permissions = $validated['permissions'] ?? [];
        unset($validated['permissions']);
        
        $item = $this->getModel()::create($validated);
        $item->permissions()->sync($permissions);

        return response()->json([
            'message' => 'Created successfully',
            'data' => $item
        ]);
    }

    public function update(...$args)
    {
        $id = end($args);
        $request = request();
        $item = $this->getModel()::findOrFail($id);
        $validated = $request->validate($this->rules());
        $permissions = $validated['permissions'] ?? [];
        unset($validated['permissions']);
        
        $item->update($validated);
        $item->permissions()->sync($permissions);

        return response()->json([
            'message' => 'Updated successfully',
            'data' => $item
        ]);
    }
    
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array'
        ];
    }
}