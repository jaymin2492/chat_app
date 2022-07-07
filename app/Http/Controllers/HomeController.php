<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Message;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('id','!=',Auth::id())->get();
        return view('home')->with('users',$users);
    }

    public function chat_messages(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|integer'
                ]
            );
            if ($validator->fails()) {
                return response()->json(array("success"=>false,"message"=>"Please select User"), 422);
            }
            $curretUSerId = Auth::id();
            $selectedUSerId = $request->user_id;
            $messages = Message::where(function ($query) use ($curretUSerId) {
                                    $query->where('from_user_id', $curretUSerId)
                                        ->orWhere('to_user_id',  $curretUSerId);
                                })->where(function ($query) use ($selectedUSerId) {
                                    $query->where('from_user_id', $selectedUSerId)
                                        ->orWhere('to_user_id',  $selectedUSerId);
                                })
                                ->orderBy('id', 'asc')
                                ->get()
                                ->toArray();
            return response()->json(array("success"=>true,"data"=>$messages), 200);
        } catch (\Exception $ex) {
            return response()->json(array("success"=>false,"message"=>$ex->getMessage()), 422);
        }
    }
    public function add_chat_messages(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|integer',
                    'message' => 'required'
                ]
            );
            if ($validator->fails()) {
                return response()->json(array("success"=>false,"message"=>"Please select User"), 422);
            }
            $curretUSerId = Auth::id();
            $messageObj = array(
                "from_user_id" => $curretUSerId,
                "to_user_id" => $request->user_id,
                "message" => $request->message
            );
            Message::create($messageObj);
            return response()->json(array("success"=>true,"data"=>[]), 200);
        } catch (\Exception $ex) {
            return response()->json(array("success"=>false,"message"=>$ex->getMessage()), 422);
        }
        
    }
    public function delete_chat_messages(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'message_id' => 'required|integer'
                ]
            );
            if ($validator->fails()) {
                return response()->json(array("success"=>false,"message"=>"Please select User"), 422);
            }
            Message::where("id",$request->message_id)->delete();
            return response()->json(array("success"=>true,"data"=>[]), 200);
        } catch (\Exception $ex) {
            return response()->json(array("success"=>false,"message"=>$ex->getMessage()), 422);
        }
        
    }
}
