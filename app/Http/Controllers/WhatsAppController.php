<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Ticket;
use App\Models\Message;
use App\Models\Order;

class WhatsAppController extends Controller
{
    public function index(Request $r) {
        $tickets    =   Ticket::where('close', false)->get();
        $messages   =   null;
        $order      =   null;
        $ticket     =   null;
        $ticketId   =   ($r->has('ticketId') ? $r->ticketId : 0);
        if($ticketId != 0) {
            $ticket     =   Ticket::find($ticketId);
            if(empty($ticket))
                return redirect()->route('dashboard');
            $messages   =   Message::where('ticketId', $ticketId)->orderBy('created_at', 'asc')->get();
            $order      =   Order::where('ticketId', $ticketId)->first();
        }
        return view('dashboard', [
            'tickets' =>  $tickets, // solo tickets abiertos.
            'messages' => $messages,
            'ticketId' => $ticketId,
            'ticket' => $ticket,
            'order' => $order
        ]);
    }

    public function newOrder(Request $r) {
        $data   =   $r->except([
            'cache',
            'url_return',
            '_token'
        ]);
        if(empty(Order::where('ticketId', $r->ticketId)->first()))
            Order::create($data);
        else {
            if($r->cache == "true") 
                Order::where('ticketId', $r->ticketId)->update($data);
            else {
                Order::where('ticketId', $r->ticketId)->update($data);
                // generate data to virtech.
            }
        }
        return ($r->url_return != null ? redirect($r->url_return) : redirect()->route('dashboard'));
    }

    /* Receiver or send messages */
    public function listen(Request $r)
    {
        $ticket     =   Ticket::where('phone', $r->phone)->where('close', false)->first();
        if(empty($ticket))
            $ticket     =   Ticket::create([
                'phone' => $r->phone
            ]);
        if($r->type == 'text') {
            $message    =   Message::create([
                'ticketId' => $ticket->id,
                'message' => $r->message,
                'phone' => $r->phone
            ]); // generate message
        }
        else {
            if($r->type == 'location')
            {
                $createMessage  =   $r->except(['type', 'latitude', 'longitude']);
                $map    =   'Lat: '.$r->latitude.', Lon: '.$r->longitude.'<br />';
                $map    .=   '<a href="https://maps.google.com/?q='.$r->latitude.','.$r->longitude.'">(Check Google Maps)</a>';
                $createMessage['message']   =   $map;
                $createMessage['ticketId']  =   $ticket->id;
                $message    =   Message::create($createMessage);
            }
        }
        return $r->message;
    }
    public function send(Request $r) {
        $message    =   Message::create($r->except('_token'));

        Http::post('https://api-fb.cambiex.net/message/send', [
            'to' => $r->phone,
            'message' => $r->message,
        ]);

        if($r->has('isForm')) {
            return redirect(url('dashboard').'?ticketId='.$r->ticketId);
        }
        else
            return $message->message;
    }
}
