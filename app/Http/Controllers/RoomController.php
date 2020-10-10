<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Shop;
use App\Image;
use App\Table;
Use App\Event;
Use App\Ticket;
use Validator;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allrooms()
    {
        // $room = Room::where('id',1)->get();
        // $room = Room::get();
        $room = Room::with(['shop','image'])->get();
        // $room = Room::get(['name','max_people']);
        // $room = Room::with('shop')->get('name');
        return response()->json(['data'=>$room],200);
    }

    public function alltable()
    {
        $table = Table::with(['shop','image'])->get();
        return response()->json(['data'=>$table],200);

    }

    public function alltevent()
    {
        $event = Event::with(['shop','image'])->get();
        return response()->json(['data'=>$event],200);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createroom(Request $request)
    {
            $room=new room();
            $room->name = $request->input("name");
            $room->max_people = $request->input("max_people");
            $room->floor = $request->input("floor");
            $room->price = $request->input("price");
            $room->special_price = $request->input("special_price");
            $room->shop_id = $request->input("shop_id");
            $room->deposit = $request->input("deposit");
            $room->status = "free";
            $room->description = $request->input("description");
            $room->save();

            // $room=new floor();



            $image=new image();
            $image->item_id = $room->id;
            $image->type = "room";
            $imageUpload = $request->image;
            $explode = explode(",", $imageUpload);
            $imageData = explode("/",$explode[0]);
            $imgExtension = explode(";", $imageData[1])[0];
            // dd($imgExtension);
            $imgSource = $explode[1];
            // dd($imgExtension);
            $imageName = str_random(10).'.'.$imgExtension;
            $path = '/images/rooms/'. $imageName;
            Storage::disk('public')->put($path, base64_decode($imgSource));
            // dd($upload);
            $image->image = $path;
            // $room = Room::with(['shop','image']);
            // dd($room);
            $image->save();
            // return response()->json(['data'=>$room], 200);
            return response()->json(["message"=>"Create Success"], 200);
  
    }

    public function createtable(Request $request)
    {
            $table = new table();
            $table->name = $request->input("name");
            $table->max_people = $request->input("max_people");
            $table->shape = $request->input("shape");
            $table->floor = $request->input("floor");
            $table->price = $request->input("price");
            $table->special_price = $request->input("special_price");
            $table->shop_id = $request->input("shop_id");
            $table->deposit = $request->input("deposit");
            $table->status = "free";
            $table->description = $request->input("description");
            $table->save();


            $image=new image();
            $image->item_id = $table->id;
            $image->type = "table";
            $imageUpload = $request->image;
            $explode = explode(",", $imageUpload);
            $imageData = explode("/",$explode[0]);
            $imgExtension = explode(";", $imageData[1])[0];
            // dd($imgExtension);
            $imgSource = $explode[1];
            // dd($imgExtension);
            $imageName = str_random(10).'.'.$imgExtension;
            $path = '/images/tables/'. $imageName;
            Storage::disk('public')->put($path, base64_decode($imgSource));
            // dd($upload);
            $image->image = $path;
            $image->save();
            return response()->json(["message"=>"Create Success"], 200);
            
        }


        public function createevent(Request $request)
        {
            $event = new event();
            $event->name = $request->input("name");
            $event->shop_id = $request->input("shop_id");
            $event->start_date = $request->input("start_date");
            $event->end_date = $request->input("end_date");
            $event->description = $request->input("description");
            $event->price = $request->input("price");
            $event->special_price = $request->input("special_price");
            $event->available_ticket = $request->input("available_ticket");
            $event->soldout_ticket = $request->input("soldout_ticket");
            $event->save();

            $ticket = new ticket();
            $ticket-> id = $event->id;
            $tickets=[];
            for ($i = 1; $i <= $event->available_ticket; $i++){
                $tickets[] = [
                    'Ticket_ID' => $i,
                    'event_id' => $event->id           
                ];
            }
            // dd($tickets);
            $ticket::insert($tickets);
            // dd($tickets);


            $image=new image();
            $image->item_id = $event->id;
            $image->type = "event";
            $imageUpload = $request->image;
            $explode = explode(",", $imageUpload);
            $imageData = explode("/",$explode[0]);
            $imgExtension = explode(";", $imageData[1])[0];
            $imgSource = $explode[1];
            $imageName = str_random(10).'.'.$imgExtension;
            $path = '/images/events/'. $imageName;
            Storage::disk('public')->put($path, base64_decode($imgSource));
            $image->image = $path;
            $image->save();
            return response()->json(["message"=>"Create Success"], 200);

        }



    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function roomdetail($id)
    {
        // $room = Room::where('id',1)->get();

        // $room = Room::find($id);
        $room = Room::with(['shop','image'])->find($id);
        if(is_null($room)){
            return response()->json(["message"=>"Room not found"], 404);
        }
        return response()->json(['data'=>$room],200);
    }


    public function tabledetail($id)
    {
        $table = Table::with(['shop','image'])->find($id);
        if(is_null($table)){
            return response()->json(["message"=>"Table not found"], 404);
        }
        return response()->json(['data'=>$table],200);
    }


    public function eventdetail($id)
    {
        $event = Event::with(['shop','image'])->find($id);
        if(is_null($event)){
            return response()->json(["message"=>"Event not found"], 404);
        }
        return response()->json(['data'=>$event],200);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateroom(Request $request, $id)
    {
        $room = Room::find($id);
        if(is_null($room)){
            return response()->json(["message" => "Room not found!"], 404);
        }
        $room ->update($request->all());
        return response()->json(['data'=>$room],200);
    }

    public function updatetable(Request $request, $id)
    {
        $table = Table::find($id);
        if(is_null($table)){
            return response()->json(["message" => "Table not found!"], 404);
        }
        $table ->update($request->all());
        return response()->json(['data'=>$table],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyroom($id)
    {
        $room = Room::find($id);
        if(is_null($room)){
            return response()->json(["message" => "Room not found!"], 404);
        }
        $room->delete();
        return response()->json(["message"=>"Room has been deleted"],200);
    }
    
    public function destroytable($id)
    {
        $table = Table::find($id);
        if(is_null($table)){
            return response()->json(["message" => "Table not found!"], 404);
        }
        $table->delete();
        return response()->json(["message"=>"Table has been deleted"],200);
    }

}
