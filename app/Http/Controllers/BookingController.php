<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Shop;
use App\User;
use App\Event;
use App\Room;
use App\Table;
use App\BookingItem;
use App\BookingList;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allbooking()
    {

        $Booking = Booking::with('user')->get();
        return response()->json(['data'=>$Booking],200);
    }
    
    public function listshop()
    {
        $shop = Shop::with('room','table','event')->get();
        return response()->json(['data'=>$shop],200);
    }

    public function listalluser(){
        $user = User::with('booking')->get();
        return response()->json(['data'=>$user],200);
    }

    public function allbookinglist(){
        $bookingItem = BookingItem::get();
        return response()->json(['data'=>$bookingItem],200);
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
    // public function createbooking(Request $request)
    // {

    //     $booking = new booking();
    //     $booking->type = $request->input("type");
    //     $booking->shop_id = $request->input("shop_id");
    //     $booking->user_id = $request->input("user_id");
    //     $booking->date = $request->input("date");
    //     $booking->start_date = $request->input("start_date");
    //     $booking->end_date = $request->input("end_date");
    //     $booking->subtotal = $request->input("subtotal");
    //     $booking->total = $request->input("total");
    //     $booking->paymentMethod = $request->input("paymentMethod");
    //     $booking->comment = $request->input("comment");
    //     $booking->status= "pending";
    //     $booking->save();
    //     return response()->json(["message"=>"Create Sucuss"], 200);

    // }



    public function createbooking(Request $request)
    {
        // dd($request->get('items'));

        $booking = new booking();
        $booking-> shop_id = $request->input("shop_id");
        $booking-> user_id = $request->input("user_id");
        $booking-> date = $request->input("date");    
        $booking-> start_date = $request->input("start_date");
        $booking-> end_date = $request->input("end_date");
        $booking-> subtotal = $request->input("subtotal");
        $booking-> total = $request->input("total");
        $booking-> paymentMethod = $request->input("paymentMethod");
        $booking->status= "pending";
        $booking-> comment = $request->input("comment");
        $booking->save();

        $bookingItem = new bookingItem();
        $bookingItem-> booking_id = $booking->id;
        $item = $request->items;
        // dd($item);
        $elements=[];
        for ($i = 0; $i < count($item); $i++){
            $elements [] = [
                'item_id' => $item[$i]['item_id'],
                'type' => $item[$i]['type'],
                'quantity' => "1",
                'booking_id' => $booking->id,
            ];
        }
        // dd($elements);
        $bookingItem::insert($elements);
        return response()->json(["message"=>"Create Succuss"], 200);

    }



    public function createbookingList(Request $request){
        $bookingList = new bookingList();
        $listItem = $request->listItems;
        $List = [];
        for ($i = 0; $i < count($listItem); $i++){
            $List [] = [
                'id' => $bookingList->id,
                'item_id' => $listItem[$i]['item_id'],
                'quantity' => "1",
                'type' => $listItem[$i]['type']
            ];
        }
        $bookingList::insert($List);
        return response()->json(["message"=>"Create Success"], 200);

    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bookingdetail($id)
    {
        $booking = Booking::with(['user','bookingItem'])->find($id);
        if(is_null($booking)){
            return response()->json(["message"=>"Bookingdetail not found"], 404);
        }
        return response()->json(['data'=>$booking],200);
    }


    // public function bookinglistdetail($id)
    // {
    //     $bookinglist = BookingList::find($id);
    //     if(is_null($bookinglist)){
    //         return response()->json(["message"=>"Bookingdetail not found"], 404);
    //     }
    //     return response()->json(['data'=>$bookinglist],200);
    // }

    public function bookingitemdetail($id)
    {
        if ('type' == 'room'){
            $bookingItem = Room::find($id);
            if(is_null($bookingItem)){
                return response()->json(["message"=>"Bookingdetail not found"], 404);
            }
            return response()->json(['data'=>$bookingItem],200);
        }
        elseif ('type' == 'table'){
            $bookingItem = Table::find($id);
            if(is_null($bookingItem)){
                return response()->json(["message"=>"Bookingdetail not found"], 404);
            }
            return response()->json(['data'=>$bookingItem],200);
        }

    }



    // public function shopdetail($id)
    // {
    //     $shop = Shop::with(['room','table','event'])->find($id);
    //     if(is_null($shop)){
    //         return response()->json(["message"=>"Shop not found"], 404);
    //     }
    //     return response()->json(['data'=>$shop],200);
    // }
 


        public function shopdetail(Request $request,$id)
        {
        $per_page = 3;
        $per_page = \Request::get('per_page') ?: 3;
        request()->get('per_page');
        $model = request()->get('type');
        if($model == 'room'){
            $model = 'App\Room';
        }
        elseif($model == 'table'){
            $model = 'App\Table';
        }
        elseif($model == 'event') {
            $model = 'App\Event';
        }
        // $shop = $model::where('shop_id', $id && 'per_page','=',$request->get('per_page'))->with('image')->paginate(10);
        $shop = $model::where('shop_id', $id)->with('image')->paginate($per_page);
        if(is_null($shop)){
            return response()->json(["message"=>"Shop not found"], 404);
        }
        return response()->json(['data'=>$shop],200);
        }




    public function shoproomdetail($id)
    {
        $shop = Shop::with('room')->find($id);
        // $shop = Shop::with('room')->find($id);
        if(is_null($shop)){
            return response()->json(["message"=>"Shop not found"], 404);
        }
        return response()->json(['data'=>$shop],200);
    }

    public function shoptabledetail($id)
    {
        $shop = Shop::with('table')->find($id);
        // $shop = Shop::with('room')->find($id);
        if(is_null($shop)){
            return response()->json(["message"=>"Shop not found"], 404);
        }
        return response()->json(['data'=>$shop],200);
    }

    public function shopeventdetail($id)
    {
        $shop = Shop::with('event')->find($id);
        // $shop = Shop::with('room')->find($id);
        if(is_null($shop)){
            return response()->json(["message"=>"Shop not found"], 404);
        }
        return response()->json(['data'=>$shop],200);
    }
    
    

    public function userbookinghistory($id)
    {
        $user = User::with('booking')->find($id);
        if(is_null($user)){
            return response()->json(["message"=>"This booking is null"], 404);
        }
        return response()->json(['data'=>$user]);
    }


    public function shopbookinghistory($id)
    {
        $model = 'App\Booking';
        $shop = $model::where('shop_id', $id)->paginate(5);
        // $shop = Shop::with('booking')->find($id);
        if(is_null($shop)){
            return response()->json(["message"=>"Shop not found"], 404);
        }
        return response()->json($shop,200);
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
    public function update(Request $request, $id)
    {
        //
    }


    public function updatebookingstatus(Request $request, $id)
    {
        $booking = Booking::find($id);
        if(is_null($booking)){
            return response()->json(["message" => "Room not found!"], 404);
        }
        $booking ->update($request->all());
        //response only booking_id and status
        return response()->json(['data'=>$booking],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
