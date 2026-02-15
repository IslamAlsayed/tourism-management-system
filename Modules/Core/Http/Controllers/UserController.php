<?php

namespace Modules\Core\Http\Controllers;

use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\User;
use Modules\Core\Http\Requests\User\StoreRequest;
use Modules\Core\Http\Requests\User\UpdateRequest;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('core::users.index');
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();
        return view('core::users.create', compact('roles'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];
        $created = User::create($validated);

        $created->assignRole($created->role);

        if ($request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $created, 'photo', 'users');
        }
        return $created
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.user')]))
                : redirect()->route('dashboard.core.users.index')->withSuccess(__('messages.type_created', ['type' => __('main.user')])))
            : redirect()->route('dashboard.core.users.index')->withError(__('messages.type_creation_failed', ['type' => __('main.user')]));
    }

    public function show($id)
    {
        $user = User::with((new User)->getRelationshipNames())->find($id);
        if (!$user)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.user')]));
        return view('core::users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        if (!$user)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.user')]));
        $roles = Role::orderBy('name')->get();
        return view('core::users.edit', compact('user', 'roles'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.user')]));
        $validated = $request->validated();
        $validated['name'] = ($validated['first_name'] ?? $user->first_name) . ' ' . ($validated['last_name'] ?? $user->last_name);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $updated = $user->update($validated);
        if ($request->input('remove_photo') && $request->hasFile('photo')) {
            $this->uploadSinglePhoto($request, $user, 'photo', 'users');
        }
        return $updated
            ? redirect()->route('dashboard.core.users.index')->withSuccess(__('messages.type_updated', ['type' => __('main.user')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.user')]));
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.user')]));
        $deleted = $user->delete();
        if ($deleted) {
            $this->deletePhoto($user, 'photo');
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.user')]));
        }
        return redirect()->back()->withError(__('messages.type_deletion_failed', ['type' => __('main.user')]));
    }
}
