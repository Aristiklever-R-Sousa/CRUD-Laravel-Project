<?php

namespace App\Http\Controllers;

use App\Models\Consult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultsController extends Controller
{
    public function index() {
        $consults = DB::table('consults')
                    ->join('doctors', 'doctors.id', '=', 'consults.doctor')
                    ->select('consults.*', 'doctors.name')
                    ->orderBy('consults.timeMarked', 'asc')
                    ->get();
                    
        foreach($consults as $consult) {
            $tmp = explode(' ', $consult->timeMarked);
            $date = explode('-', $tmp[0]);
            $hour = explode(':', $tmp[1]);
            
            $aux = $date[0];
            $date[0] = $date[2];
            $date[2] = $aux;
            
            $consult->timeMarked = "Dia " . implode("/", $date) . " às " . "$hour[0]:$hour[1]";
        }

        return view('consults.index', ['consults' => $consults]);
    }

    public function insertView() {
        $doctors = DB::table('doctors')
                    ->select('doctors.*')
                    ->get();
        
        return view('consults.create', [
            'doctors' => $doctors
        ]);
    }

    public function insert(Request $request) {
        if(
            $request->idDoctor == "" ||
            $request->desc == "" ||
            $request->dateTime == ""
        ) {
            echo "<script> window.alert('Preencha todos os campos para que a consulta seja marcada!') </script>";
            return $this->insertView(); 
        }

        $consult = new Consult();
        $consult->doctor = $request->idDoctor;
        $consult->desc = $request->desc;
        
        $tmp = explode(' ', $request->dateTime);
        $date = explode('/', $tmp[0]);
        $aux = $date[0];
        $date[0] = $date[2];
        $date[2] = $aux;

        $consult->timeMarked = implode('-', $date) .' '. $tmp[1] . ':00';
        
        $consult->save();

        return redirect()->route('consults.get.index');
    }

    public function updateView($id) {
        if(is_numeric($id) === false) return redirect()->route('consults.get.index');

        $doctorId = DB::table('consults')
                    ->select('consults.doctor')
                    ->where('consults.id', '=', $id)
                    ->get();

        if(count($doctorId) === 0) return redirect()->route('consults.get.index');

        $doctorId = $doctorId[0]->doctor;

        $doctors = DB::table('doctors')
                    ->select('doctors.*')
                    ->where('doctors.id', '!=', $doctorId)
                    ->get();

        $consult = DB::table('consults')
                    ->join('doctors', 'doctors.id', '=', 'consults.doctor')
                    ->select('consults.*', 'doctors.id', 'doctors.name')
                    ->where('consults.id', '=', $id)
                    ->get()[0];
        
        $tmp = explode(' ', $consult->timeMarked);
        $date = explode('-', $tmp[0]);
        $hour = explode(':', $tmp[1]);
                        
        $aux = $date[0];
        $date[0] = $date[2];
        $date[2] = $aux;
                        
        $consult->timeMarked = implode("/", $date) . " " . "$hour[0]:$hour[1]";
        $consult->id = $id;

        return view('consults.edit', [
            'consult' => $consult,
            'doctors' => $doctors
        ]);
    }

    public function update(Request $request, $id) {
        if(
            $request->idDoctor == "" ||
            $request->desc == "" ||
            $request->dateTime == ""
        ) {
            echo "<script> window.alert('Preencha todos os campos para que a consulta seja marcada!') </script>";
            return $this->updateView($id);
        }

        $consult = new Consult();
        $consult->doctor = $request->idDoctor;
        $consult->desc = $request->desc;
        
        $tmp = explode(' ', $request->dateTime);
        $date = explode('/', $tmp[0]);
        $aux = $date[0];
        $date[0] = $date[2];
        $date[2] = $aux;

        $consult->timeMarked = implode('-', $date) .' '. $tmp[1] . ':00';

        DB::table('consults')
        ->where('consults.id', '=', $id)
        ->update([
            "desc" => $consult->desc,
            "timeMarked" => $consult->timeMarked,
            "doctor" => $consult->doctor
        ]);

        return redirect()->route('consults.get.index');
    }

    public function show($id) {
        if(is_numeric($id) === false) return redirect()->route('consults.get.index');
        
        $consult = DB::table('consults')
                    ->join('doctors', 'doctors.id', '=', 'consults.doctor')
                    ->select('consults.*', 'doctors.name', 'doctors.speciality')
                    ->where('consults.id', '=', $id)
                    ->get();
        
        if(count($consult) === 0) return redirect()->route('consults.get.index');

        $consult = $consult[0];

        $tmp = explode(' ', $consult->timeMarked);
        $date = explode('-', $tmp[0]);
        $hour = explode(':', $tmp[1]);
                        
        $aux = $date[0];
        $date[0] = $date[2];
        $date[2] = $aux;
                        
        $consult->timeMarked = "Dia " . implode("/", $date) . " às " . "$hour[0]:$hour[1]";

        return view('consults.show', ['consult' => $consult]);
    }

    public function deleteView($id) {
        if(is_numeric($id) === false) return redirect()->route('consults');
        
        $exist = DB::table('consults')
        ->where('consults.id', '=', $id)
        ->get();
        
        if(count($exist) === 0) return redirect()->route('consults');
        
        $consults = DB::table('consults')
                    ->join('doctors', 'doctors.id', '=', 'consults.doctor')
                    ->select('consults.*', 'doctors.name')
                    ->orderBy('consults.timeMarked', 'asc')
                    ->get();
                    
        foreach($consults as $consult) {
            $tmp = explode(' ', $consult->timeMarked);
            $date = explode('-', $tmp[0]);
            $hour = explode(':', $tmp[1]);
                        
            $aux = $date[0];
            $date[0] = $date[2];
            $date[2] = $aux;
                        
            $consult->timeMarked = "Dia " . implode("/", $date) . " às " . "$hour[0]:$hour[1]";
        }
                    
        return view('consults.index', [
            'consults' => $consults,
            'id' => $id
        ]);
    }
                    
    public function delete($id) {
        DB::table('consults')
            ->where('consults.id', '=', $id)
            ->delete();
            
        return redirect()->route('consults.get.index');
    }
                
}