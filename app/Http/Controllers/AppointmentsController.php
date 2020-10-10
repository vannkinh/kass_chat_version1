<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use App\Image;
use App\Hospital;
use App\Appointment;
use App\User;
use App\Service;
use Illuminate\Support\Facades\Storage;


class AppointmentsController extends Controller
{
    // List all doctor
    public function alldoctor()
    {
        $doctor = Doctor::with(['hospital','image'])->get();
        return response()->json(['data'=>$doctor], 200);
    }

    // doctor detail
    public function doctordetail($id){
        $doctor = Doctor::with(['hospital','image'])->find($id);
        if(is_null($doctor)){
            return response()->json(["message"=>"Doctor not found"], 400);
        }
        return response()->json(['data'=>$doctor], 200);
    }

    // Create doctor
    public function createdoctor(Request $request)
    {
        $doctor=new doctor();
        $doctor->hospital_id = $request->input("hospital_id");
        $doctor->name = $request->input("name");
        $doctor->service_id = $request->input("service_id");
        $doctor->degree = $request->input("degree");
        $doctor->work_experience = $request->input("work_experience");
        $doctor->work_hours = $request->input("work_hours");
        $doctor->age = $request->input("age");
        $doctor->gender = $request->input("gender");
        $doctor->status = "free";
        $doctor->save();

       
        $image=new image();
        $image->item_id = $doctor->id;
        $image->type = "doctor";
        $imageUpload = $request->image;
        $explode = explode(",", $imageUpload);
        $imageData = explode("/",$explode[0]);
        $imgExtension = explode(";", $imageData[1])[0];
        // dd($imgExtension);
        $imgSource = $explode[1];
        // dd($imgExtension);
        $imageName = str_random(10).'.'.$imgExtension;
        $path = '/images/doctors/'. $imageName;
        Storage::disk('public')->put($path, base64_decode($imgSource));
        // dd($upload);
        $image->image = $path;
        // $room = Room::with(['shop','image']);
        // dd($room);
        $image->save();
        // return response()->json(['data'=>$room], 200);
        return response()->json(["message"=>"Create Success"], 200);
  
    }

    //update doctor
    public function updatedoctor(Request $request, $id){
        $doctor = Doctor::find($id);
        if(is_null($doctor)){
            return response()->json(["message" => "Doctor not found!"], 404);
        }
        $doctor ->update($request->all());
        return response()->json(['data'=>$doctor],200);
    }

    // delete doctor
    public function destroydoctor($id)
    {
        $doctor = Doctor::find($id);
        if(is_null($doctor)){
            return response()->json(["message" => "Doctor not found!"], 404);
        }
        $doctor->delete();
        return response()->json(["message"=>"Doctor has been deleted"],200);
    }

    // list all hospital
    public function allhospital()
    {
        $hospital = Hospital::with('doctor')->get();
        return response()->json(['data'=>$hospital],200);
    }

    // hospital detail
    public function hospitaldetail($id){
        $hospital = Hospital::with('doctor')->find($id);
        if(is_null($hospital)){
            return response()->json(["message"=>"hosppital not found"], 400);
        }
        return response()->json(['data'=>$hospital], 200);
    }



    //make appointment
    public function createappointment(Request $request){
        $appointment = new appointment();
        $appointment-> user_id = $request->input("user_id");
        $appointment-> doctor_id = $request->input("doctor_id");
        $appointment-> hospital_id = $request->input("hospital_id");
        $appointment-> start_date = $request->input("start_date");
        $appointment->status= "Request";
        $appointment-> comment = $request->input("comment");
        $appointment->save();
        return response()->json(["message"=>"Create Success"], 200);

    }


    //list all appointment
    public function allappointment()
    {
        // $Booking = Booking::where('user_id',1)->get();
        // $bookingItem = BookingItem::with('booking')->get(['shop_id','user_id']);
        $appointment = Appointment::with('user')->get();
        return response()->json(['data'=>$appointment],200);
    }


    //appointment detail
    public function appointmentdetail($id)
    {
        $appointment = Appointment::with('user')->find($id);
        if(is_null($appointment)){
            return response()->json(["message"=>"Not found"], 404);
        }
        return response()->json(['data'=>$appointment],200);
    }
    

    //cancelled booking (user)
    public function cancelledappointment(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        if(is_null($appointment)){
            return response()->json(["message" => "Appointment not found!"], 404);
        }
        $appointment ->update($request->all());
        return response()->json(['data'=>$appointment],200);
    }


    //user appointment history
    public function userappointmenthistory($id){
        $user = User::with('appointment')->find($id);
        if(is_null($user)){
            return response()->json(["message"=>"This appointment is null"], 404);
        }
        return response()->json(['data'=>$user]);

    }

    //hospital appoinment history
    public function hospitalappointmenthistory($id)
    {
        $hospital = Hospital::with('appointment')->find($id);
        if(is_null($hospital)){
            return response()->json(["message"=>"Hospital not found"], 404);
        }
        return response()->json(['data'=>$hospital],200);
    }

    // create service
    public function createservice(Request $request)
    {
            $service=new service();
            $service->service_name = $request->input("service_name");
            $service->duration = $request->input("duration");
            $service->price = $request->input("price");
            $service->special_price = $request->input("special_price");
            $service->hospital_id = $request->input("hospital_id");
            $service->save();

            $image=new image();
            $image->item_id = $service->id;
            $image->type = "service";
            $imageUpload = $request->image;
            $explode = explode(",", $imageUpload);
            $imageData = explode("/",$explode[0]);
            $imgExtension = explode(";", $imageData[1])[0];
            // dd($imgExtension);
            $imgSource = $explode[1];
            // dd($imgExtension);
            $imageName = str_random(10).'.'.$imgExtension;
            $path = '/images/services/'. $imageName;
            Storage::disk('public')->put($path, base64_decode($imgSource));
            // dd($upload);
            $image->image = $path;
            // $room = Room::with(['shop','image']);
            // dd($room);
            $image->save();
            // return response()->json(['data'=>$room], 200);
            return response()->json(["message"=>"Create Success"], 200);
  
    }


    // }
    // list all skill in one hospital
    // public function allspecialist(Request $request)
    // {
    //     request()->get('hospital_id');
    //     $service = Service::where('hospital_id','=',$request->get('hospital_id'))->get();
    //     return response()->json(['data'=>$service],200);
    // }

    // update skill
    // public function updatespecialist(Request $request, $id)
    // {
    //     $skill = Skill::find($id);
    //     if(is_null($skill)){
    //         return response()->json(["message" => "skill not found!"], 404);
    //     }
    //     $skill ->update($request->all());
    //     return response()->json(['data'=>$skill],200);
    // }

    // deleted skill
    // public function destroyspecialist($id)
    // {
    //     $skill = Skill::find($id);
    //     if(is_null($skill)){
    //         return response()->json(["message" => "Skill not found!"], 404);
    //     }
    //     $specialist->delete();
    //     return response()->json(["message"=>"Skill has been deleted"],200);
    // }

    // specialist detail
    // public function specialistdetail($id)
    // {
    //     $skill = Skill::with('doctor')->find($id);
    //     if(is_null($skill)){
    //         return response()->json(["message"=>"Skill not found"], 404);
    //     }
    //     return response()->json(['data'=>$skill],200);
    // }

}
