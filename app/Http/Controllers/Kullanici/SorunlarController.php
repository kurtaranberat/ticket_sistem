<?php

namespace App\Http\Controllers\Kullanici;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class SorunlarController extends Controller
{
     public  function  index(){
         $cozum=User::filterByRoleId(3)->get();
         return view ('kullanici.index',compact('cozum'));
     }
     public  function  sor($id){
         $reciver_id=$id;
         $cozum=Role::get();
         return view('kullanici.panel.index',compact('reciver_id'));
     }
    public function cozenFetch(){
        $cozum=User::filterByRoleId(3)->get();

        return DataTables::of($cozum)
            ->addColumn('update', function ($data) {
                return "<a onclick='updateKontenjan(" . $data->id . ")' href='/kullanici/Sorunlar/" . $data->id . "' class='btn btn-warning'>Mesajlas</a>";
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
         //$sended_message = aktif Auth::user ın attığı ve bu sayfadaki receiver_id li kullanıcının aldığı mesajlar
        $sended_message =  Message::where('sender_id',$request->sender_id)->where('receiver_id',$request->receiver_id)->get();

        //$received_message = receiver_id li kullanıcının Auth::user a attığı mesajlar
        $received_message = Message::where('sender_id',$request->receiver_id)->where('receiver_id',$request->sender_id)->get();

        $all_messages = new Collection(); // Bizim attığımız ve bize atılan mesajların toplamı

        $all_messages = $all_messages->concat($sended_message);
        $all_messages = $all_messages->concat($received_message);

        $sorted_all_messages = $all_messages->toArray(); // Koleksiyonu diziye çevir

        usort($sorted_all_messages, function ($a, $b) {
            return strcmp($a['created_at'], $b['created_at']);
        });
        return $sorted_all_messages;
    }

}
