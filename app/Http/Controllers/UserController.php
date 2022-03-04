<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $perPage = request()->query('per_page');
        $channelRegis = request()->query('channel');
        $search = request()->query('search');

        if ($search) {
            return User::where('phone', 'like', '%' . $search . '%')
                ->orWhere('fname', 'like', '%' . $search . '%')
                ->orderBy('id', 'desc')
                ->paginate($perPage);
        }

        if ($channelRegis) {
            return User::orderBy('id', 'desc')
                ->where('register_channel', $channelRegis)
                ->paginate($perPage);
        }

        return User::orderBy('id', 'desc')->paginate($perPage);
    }

    public function editUser(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $dataUpdate = array(
            'fname' => $request['fname'],
            'lname' => $request['lname'],
            'phone' => $request['phone'],
            'email' => $request['email'],
        );
        return User::where('id', $request['id'])
            ->update($dataUpdate);
    }
}
