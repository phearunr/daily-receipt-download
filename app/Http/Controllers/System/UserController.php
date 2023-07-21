<?php

namespace App\Http\Controllers\System;

use Exception;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(User::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Inertia::render('Users/IndexUser', [
            'entries' => UserResource::collection(
                User::query()
                    ->search(request('term'))
                    ->paginate(5)
            ),
            'months' => [
                ['value' => 'logged-in-today', 'label' => 'Logged In Today'],
                ['value' => 'logged-in-last-7-days', 'label' => 'Logged In Last 7 Days'],
                ['value' => 'logged-in-last-30-days', 'label' => 'Logged In Last 30 Days'],
                ['value' => 'not-logged-in-for-30-days', 'label' => 'Not Logged In For 30 Days']
            ],
            'queryParams' => request()->all(['month', 'term'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Inertia::render('Users/CreateUser', [
            'roles' =>  Role::select('id As value', 'title As label')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $input)
    {
        Validator::make($input->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required'],
            'password' => 'required| min:4| max:8 |confirmed',
            'password_confirmation' => 'required| min:4'

        ])->validateWithBag('createUser');

        DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) use ($input) {
                $this->createTeam($user);
                $user->roles()->sync($input->input('role', []));
            });
        });
        return redirect()->back()->with('toast', 'sucess created!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Inertia::render('Users/EditUser', [
            'user' =>  User::query()->with('roles')->findOrFail($user['id']),
            'roles' =>  Role::select('id As value', 'title As label')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        $user->roles()->sync($request->input('roles', []));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            request()->validate([
                'entryIds' => ['required', 'array']
            ]);
            foreach (User::find(request('entryIds')) as $entry) {
                $entry->delete();
                $entry->update(['status' => 5]);
            }
            return redirect()->back();
        } catch (Exception $error) {
            return response([
                'exception' => get_class($error),
                'errors' => $error->getMessage()
            ], 400);
        }
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0] . "'s Team",
            'personal_team' => true,
        ]));
    }
}
