<?php


namespace App\Services;


use App\Exceptions\APIException;
use App\Models\User;
use Illuminate\Http\Request;

class UserService implements AppServiceInterface
{
    public function getAll()
    {
        return User::all();
    }

    public function getById($id)
    {
        return User::find($id);
    }

    public function create(Request $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->name = $request->get('username');
        $user->save();

        return $user;
    }

    public function update(Request $request, $id)
    {
        $user = $this->getById($id);
        $user->password = $request->get('password');
        $user->name = $request->get('name');
        $user->save();

        return $user;
    }

    public function delete($id)
    {
        $user = $this->getById($id);
        $user->delete();

        return $user;
    }
}
