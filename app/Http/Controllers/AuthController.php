<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Dotenv\Parser\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    //
    public function regist(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20|alpha',
            'nickname' => 'required|string|regex:/^[a-z]*$/',
            'password' => 'required|min:10|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/',
            'phone' => 'required|max:20|digits_between:1,20',
            'email' => 'required|email:rfc,dns',
        ]);

        $user = new User([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        $user->save();

        return response('success', 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        return $this->createToken($request->email, $request->password);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response('logout success', 200);
    }

    public function createToken($email, $password)
    {
        $credential = [
            'email' => $email,
            'password' => $password
        ];

        if (!Auth::attempt($credential)) {
            return 'login failed';
        }

        $data = [
            'grant_type' => 'password',
            'client_id' => '94ad5c66-c08a-4534-8d90-06c06b5de564',
            'client_secret' => 'uOGaDKPrXzR4rBftVq6hcZtKlKG4a2xhqpnLEQEd',
            'username' => Auth::user()['email'],
            'password' => $password,
            'scope' => '*',
        ];

        $request = Request::create('/oauth/token', 'POST', $data);
        $response = app()->handle($request);

        return $response;
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function getUser($id)
    {
        $user = new User();

        return $user->findForUsers('id', $id)->first();
    }

    public function getFindUser(Request $request)
    {
        if ($request->has(['searchType', 'searchValue'])) {
            $request->page = $request->page ?: 1;
            $request->limit = $request->limit ?: 10;
            $user = new User();

            return $user->findForUsers($request->searchType, $request->searchValue)->paginate($request->limit, '*', null, $request->page);
        }
    }

    public function getOrderList()
    {
        $order = new Order();

        return $order->findForOrder('userId', Auth::user()['id']);
    }

    public function getFindOrderList($id)
    {
        $order = new Order();

        return $order->findForOrder('userId', $id);
    }
}
