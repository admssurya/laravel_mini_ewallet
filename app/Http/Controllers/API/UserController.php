<?php

namespace App\Http\Controllers\API;

use App\Exceptions\APIException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use App\Transformers\UserTransformer;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserService $userService
     * @return array
     */
    public function index(UserService $userService)
    {
        $users = $userService->getAll();

        return [
            'payload' => fractal($users, new UserTransformer())
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @param UserService $userService
     * @return array
     */
    public function store(CreateUserRequest $request, UserService $userService)
    {
        $user = $userService->create($request);

        return [
            'payload' => fractal($user, new UserTransformer())
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param UserService $userService
     * @return array
     * @throws APIException
     */
    public function show($id, UserService $userService)
    {
        $this->validation($userService, $id);
        $user = $userService->getById($id);

        return [
            'payload' => fractal($user, new UserTransformer())
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @param UserService $userService
     * @return array
     * @throws APIException
     */
    public function update(UpdateUserRequest $request, $id, UserService $userService)
    {
        $this->validation($userService, $id);
        $user = $userService->update($request, $id);

        return [
            'payload' => fractal($user, new UserTransformer())
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param UserService $userService
     * @return array
     * @throws APIException
     */
    public function destroy($id, UserService $userService)
    {
        $this->validation($userService, $id);
        $user = $userService->delete($id);

        return [
            'payload' => fractal($user, new UserTransformer())
        ];
    }

    private function validation(UserService $userService, $id)
    {
        if (!$userService->getById($id)) :
            throw new APIException('Data Not Found');
        endif;
    }
}
