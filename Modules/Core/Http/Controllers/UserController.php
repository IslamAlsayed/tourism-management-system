<?php

namespace Modules\Core\Http\Controllers;

use \Modules\Geography\Entities\Country;
use Modules\Core\Entities\User;
use App\Traits\PhotoUploadTrait;
use Illuminate\Routing\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;

class UserController extends Controller
{
    use PhotoUploadTrait;

    public function index()
    {
        return view('core::users.index');
    }

    public function create()
    {
        $countries = Country::all();
        return view('core::users.create', compact('countries'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $data = array_merge($validated, $request->safe()->except('photo'));
        $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        $created = User::create($data);
        if ($created) {
            $this->uploadPhoto($request, $created, 'photo', "users");
            return $request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.type_created', ['type' => __('main.user')]))
                : redirect()->route('dashboard.core.users.index')->withSuccess(__('messages.type_created', ['type' => __('main.user')]));
        }
        return redirect()->route('dashboard.core.users.index')->withError(__('messages.type_creation_failed', ['type' => __('main.user')]));
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
        $countries = Country::all();
        return view('core::users.edit', compact('user', 'countries'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user)
            return redirect()->back()->withError(__('messages.not_found_this_type', ['type' => __('main.user')]));
        $validated = $request->validated();
        $data = array_merge($validated, $request->safe()->except('photo'));
        $data['name'] = ($data['first_name'] ?? $user->first_name) . ' ' . ($data['last_name'] ?? $user->last_name);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $updated = $user->update($request->all());
        if ($request->has('photo')) {
            $this->uploadPhoto($request, $user, 'photo', "users");
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
