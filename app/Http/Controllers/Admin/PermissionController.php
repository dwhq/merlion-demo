<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Merlion\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class PermissionController extends CrudController
{
    protected string $model = Permission::class;

    protected function schemas(): array
    {
        return [
            'id',
            'name',
            'display_name',
            'description',
        ];
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
        ];
    }
}