<?php

namespace Task\Http\Controllers;

use Illuminate\Http\Request;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Task\Http\Requests\StoreUserRequest;
use Task\Http\Requests\UpdateUserRequest;
use Task\Transformers\UserTransformer;
use Task\User;

class APIUsersController extends Controller
{
    public function index() {
        $this->authorize('index', User::class);

        $users = User::orderBy('created_at', 'desc')->paginate(10);
        $usersCollection = $users->getCollection();

        return fractal()
            ->collection($usersCollection)
            ->parseIncludes(['posts'])
            ->transformWith(new UserTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($users))
            ->toArray();
    }

    public function show(User $user) {
        $this->authorize('show', $user);

        return fractal()
        ->item($user)
        ->parseIncludes(['posts'])
        ->transformWith(new UserTransformer)
        ->toArray();
    }

    public function store(StoreUserRequest $request) {
        $this->authorize('create', User::class);
        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->admin = $request->admin;

        $user->save();

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    public function update(UpdateUserRequest $request, User $user) {
        $this->authorize('update', $user);

        $user->name = $request->get('name', $user->name);
        $user->password = $request->get('password', $user->password);
        $user->email = $request->get('email', $user->email);
        $user->admin = $request->get('admin', $user->admin);
        $user->save();

        return fractal()
            ->item($user)
            ->parseIncludes(['posts'])
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    public function destroy(User $user) {
        $this->authorize('delete', $user);

        $user->delete();

        return response(null, 204); // Successful && No Content
    }
}
