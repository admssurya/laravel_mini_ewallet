<?php


namespace App\Services;


use Illuminate\Http\Request;

interface AppServiceInterface
{
    public function getAll();

    public function getById($id);

    public function create(Request $request);

    public function update(Request $request, $id);

    public function delete($id);
}
