<?php

namespace App\Http\Controllers\Cozen;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class CozumlerController extends Controller
{
    public function  index(){
        $coz=User::filterByRoleId(2)->get();
        return view ('cozen.index',compact('coz'));
    }

    public function coz($id){
        $reciver_id=$id;
        return view('cozen.panel.index',compact('reciver_id'));
    }

    public function listeleFetch(){
        $coz=User::filterByRoleId(2)->get();
        return DataTables::of($coz)
            ->addColumn('update', function ($data) {
                return "<a onclick='updateKontenjan(" . $data->id . ")' href='/cozen/Cozumler/" . $data->id . "' class='btn btn-warning'>Mesajlas</a>";
            })->addColumn('delete', function ($data) {
                return "<button onclick='deleteKontenjan(" . $data->id . ")' class='btn btn-danger'>Sil</button>";
            })
            ->rawColumns(['name', 'update', 'delete'])
            ->make(true);
    }

    public function messagePost(Request $request){

        $message = new Message();
        $message->sender_id = $request->sender_id;
        $message->receiver_id = $request->receiver_id;
        $message->content = $request->message_content;
        $message->save();

        return response()->json(['Success','success']);
    }

    public function messageGet(Request $request){
        $sended_message =  Message::where('sender_id',$request->sender_id)->where('receiver_id',$request->receiver_id)->get();
        $received_message = Message::where('sender_id',$request->receiver_id)->where('receiver_id',$request->sender_id)->get();

        $all_messages = new Collection();

        $all_messages = $all_messages->concat($sended_message);
        $all_messages = $all_messages->concat($received_message);

        $sorted_all_messages = $all_messages->toArray(); // Koleksiyonu diziye çevir

        usort($sorted_all_messages, function ($a, $b) {
            return strcmp($a['created_at'], $b['created_at']);
        });
        return $sorted_all_messages;
    }
}
