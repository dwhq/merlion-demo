<?php

 namespace App\Http\Controllers\Admin;


 // app/Http/Controllers/Admin

 use App\Models\User;
 use App\Models\Role;
 use Merlion\Http\Controllers\CrudController;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Hash;

 class UserController extends CrudController
 {
     protected string $model = User::class;

     protected function schemas(): array
     {
         $roles = Role::all()->pluck('display_name', 'id')->toArray();

         return [
             'id',
             'name',
             'email',
             [
                 'name' => 'roles',
                 'type' => 'custom_checkbox',
                 'label' => 'Roles',
                 'options' => $roles,
                 'description' => 'Select roles for this user'
             ]
         ];
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
             'password' => 'nullable|string|min:8|confirmed',
             'roles' => 'array'
         ];
     }

     public function store(...$args)
     {
         $request = request();
         $validated = $request->validate($this->rules());

         // Handle password hashing
         if (!empty($validated['password'])) {
             $validated['password'] = Hash::make($validated['password']);
         } else {
             unset($validated['password']);
         }

         $roles = $validated['roles'] ?? [];
         unset($validated['roles']);

         $item = $this->getModel()::create($validated);
         $item->roles()->sync($roles);

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

         // Handle password hashing
         if (!empty($validated['password'])) {
             $validated['password'] = Hash::make($validated['password']);
         } else {
             unset($validated['password']);
         }

         $roles = $validated['roles'] ?? [];
         unset($validated['roles']);

         $item->update($validated);
         $item->roles()->sync($roles);

         return response()->json([
             'message' => 'Updated successfully',
             'data' => $item
         ]);
     }
 }
