<?php

namespace App\Http\Controllers;

use App\Models\Consult;
use App\Models\Doctor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConsultsController extends Controller
{
    private const MESSAGES = [
        'required' => 'Preencha todos os campos!'
    ];

    private function formatDate($date, $show = true) {
        $tmp = explode(' ', $date);
        
        if(count($tmp) > 2) $tmp = explode(' ', $tmp[1].' '.$tmp[3]);

        if($show) {
            $date = explode('-', $tmp[0]);
            $hour = explode(':', $tmp[1]);
            
            $aux = $date[0];
            $date[0] = $date[2];
            $date[2] = $aux;

            return "Dia " . implode("/", $date) . " às " . "$hour[0]:$hour[1]";
        }

        $date = explode('/', $tmp[0]);
    
        $aux = $date[0];
        $date[0] = $date[2];
        $date[2] = $aux;

        return implode('-', $date) .' '. $tmp[1] . ':00';
    }

    public function index() {
        $consults = DB::table('consults')
                    ->join('doctors', 'doctors.id', '=', 'consults.doctor')
                    ->select('consults.*', 'doctors.name')
                    ->orderBy('consults.timeMarked', 'asc')
                    ->get();
                    
        foreach($consults as $consult)
            $consult->timeMarked = $this->formatDate($consult->timeMarked);

        return view('consults.index', ['consults' => $consults]);
    }

    public function insertView() {

        $doctors = Doctor::all();
        
        return view('consults.create', [
            'doctors' => $doctors
        ]);
    }

    public function insert(Request $request) {
        $validatedData = Validator::make(
            $request->all(),
            [
                'idDoctor' => ['bail', 'required'],
                'desc' => ['bail', 'required'],
                'dateTime' => ['required']
            ],
            ConsultsController::MESSAGES
        )->validate();

        $consult = new Consult();
        
        $consult->doctor = $request->idDoctor;
        $consult->desc = $request->desc;
        $consult->timeMarked = $this->formatDate($request->dateTime, false);
        
        $consult->save();

        return redirect()->route('consults.get.index');
    }

    public function show($id) {
        if(is_numeric($id) === false) return redirect()->route('consults.get.index');
        
        $consult = DB::table('consults')
                    ->where('consults.id', '=', $id)
                    ->join('doctors', 'doctors.id', '=', 'consults.doctor')
                    ->select('consults.*', 'doctors.name', 'doctors.speciality')
                    ->get();
        
        if(count($consult) === 0) return redirect()->route('consults.get.index');

        $consult = $consult[0];
        $consult->timeMarked = $this->formatDate($consult->timeMarked);

        return view('consults.show', ['consult' => $consult]);
    }

    public function updateView($id) {
        if(is_numeric($id) === false) return redirect()->route('consults.get.index');

        $doctorId = Consult::where('id', $id)
                    ->select('doctor')
                    ->get();

        if(count($doctorId) === 0) return redirect()->route('consults.get.index');

        $doctorId = $doctorId[0]->doctor;

        $doctors = Doctor::where('id', '!=', $doctorId)->get();

        $consult = DB::table('consults')
                    ->join('doctors', 'doctors.id', '=', 'consults.doctor')
                    ->select('consults.*', 'doctors.id', 'doctors.name', 'doctors.speciality')
                    ->where('consults.id', '=', $id)
                    ->get()[0];

        $consult->timeMarked = $this->formatDate($consult->timeMarked);
        $consult->id = $id;

        return view('consults.edit', [
            'consult' => $consult,
            'doctors' => $doctors
        ]);
    }

    public function update(Request $request, $id) {
        $validatedData = Validator::make(
            $request->all(),
            [
                'idDoctor' => ['bail', 'required'],
                'desc' => ['bail', 'required'],
                'dateTime' => ['required']
            ],
            ConsultsController::MESSAGES
        )->validate();

        $doctor = $request->idDoctor;
        $desc = $request->desc;
        $timeMarked = $this->formatDate($request->dateTime, false);
        
        Consult::where('id', $id)->update([
            "desc" => $desc,
            "timeMarked" => $timeMarked,
            "doctor" => $doctor
        ]);

        return redirect()->route('consults.get.index');
    }

    public function deleteView($id) {
        if(is_numeric($id) === false) return redirect()->route('consults.get.index');
        
        $exist = Consult::where('id', $id)->get();

        if(count($exist) === 0) return redirect()->route('consults.get.index');
        
        $consults = DB::table('consults')
                    ->join('doctors', 'doctors.id', '=', 'consults.doctor')
                    ->select('consults.*', 'doctors.name')
                    ->orderBy('consults.timeMarked', 'asc')
                    ->get();
                    
        foreach($consults as $consult)
            $consult->timeMarked = $this->formatDate($consult->timeMarked);
                    
        return view('consults.index', [
            'consults' => $consults,
            'id' => $id
        ]);
    }
                    
    public function delete($id) {
        Consult::where('id', $id)->delete();
            
        return redirect()->route('consults.get.index');
    }
                
}