<?php

namespace App\Http\Controllers;

use Storage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=Auth::id();
        $users = DB::table('users')->select('name', 'cognome', 'dataNascita', 'email', 'nazionalita', 'affiliazione', 'dipartimento', 'linea_ricerca', 'telefono', 'immagineProfilo')->where('users.id', '=', $id)->get();
        $publications=DB::table('publications')->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'visibilita', 'tags', 'descrizione', 'coautori')->where('idUser','=', $id)->get();
        return view ('users.index', ['users' => $users, 'publications' => $publications, 'filter'=>0]);
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
    public function store(Request $request)
    {
        $user = $request->validate([
          'name' => '',
          'cognome' => '',
          'dataNascita' => '',
          'email' => '',
          'nazionalita' => '',
          'affiliazione' => '',
          'dipartimento' => '',
          'linea_ricerca' => '',
          'telefono' => ''
        ]);
        
        Publication::create([
            'name' => $request['name'],
            'cognome' => $request['cognome'],
            'dataNascita' => $request['dataNascita'],
            'email' => $request['email'],
            'nazionalita' => $request['nazionalita'],
            'affiliazione' => $request['affiliazione'],
            'dipartimento' => $request['dipartimento'],
            'linea_ricerca' => $request['linea_ricerca'],
            'telefono' => $request['telefono']
        ]);

        return back()->with('success', 'User has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = DB::table('users')->select('id','name', 'cognome', 'dataNascita', 'email', 'nazionalita', 'affiliazione', 'dipartimento', 'linea_ricerca', 'telefono', 'visibilitaDN', 'visibilitaE', 'visibilitaN', 'visibilitaT', 'immagineProfilo')->where('users.id', '=', $id)->get();
        $publications=DB::table('publications')->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'visibilita', 'tags', 'descrizione', 'coautori')->where('idUser','=', $id)->where('visibilita','=','1')->get();
        return view ('users.show', ['users' => $users, 'publications' => $publications, 'filter'=>0]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id=Auth::id();
        $users = DB::table('users')->select('name', 'cognome', 'dataNascita', 'email', 'nazionalita', 'affiliazione', 'dipartimento', 'linea_ricerca', 'telefono', 'immagineProfilo')->where('users.id', '=', $id)->get();
        return view('users.edit',compact('users','id'));
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
        $user=User::find($id);
        $this->validate($request, [
            'name' => 'required',
            'cognome' => 'required',
            'dataNascita' => '',
            'visibilitaDN' => '',
            'email' => 'email',
            'visibilitaE' => '',
            'nazionalita' => 'required',
            'visibilitaN' => '',
            'affiliazione' => 'required',
            'dipartimento' => 'required',
            'linea_ricerca' => 'required',
            'telefono' => 'required',
            'visibilitaT' => '',
            'immagineProfilo' => ''
        ]);
        if($request->hasFile('immagineProfilo')) {
            $request->file('immagineProfilo');
            $fileName=$request->file('immagineProfilo')->getClientOriginalName();
            $path=Storage::putFileAs('public', new \Illuminate\Http\File($request->file('immagineProfilo')), $fileName);
            $user->name = $request['name'];
            $user->cognome = $request['cognome'];
            $user->dataNascita = $request['dataNascita'];
            $user->visibilitaDN = $request['visibilitaDN'];
            $user->email = $request['email'];
            $user->visibilitaE = $request['visibilitaE'];
            $user->nazionalita = $request['nazionalita'];
            $user->visibilitaN = $request['visibilitaN'];
            $user->affiliazione = $request['affiliazione'];
            $user->linea_ricerca = $request['linea_ricerca'];
            $user->telefono = $request['telefono'];
            $user->visibilitaT = $request['visibilitaT'];
            $user->immagineProfilo = $path;
        } else {
            $user->name = $request['name'];
            $user->cognome = $request['cognome'];
            $user->dataNascita = $request['dataNascita'];
            $user->visibilitaDN = $request['visibilitaDN'];
            $user->email = $request['email'];
            $user->visibilitaE = $request['visibilitaE'];
            $user->nazionalita = $request['nazionalita'];
            $user->visibilitaN = $request['visibilitaN'];
            $user->affiliazione = $request['affiliazione'];
            $user->linea_ricerca = $request['linea_ricerca'];
            $user->telefono = $request['telefono'];
            $user->visibilitaT = $request['visibilitaT'];
        }
        $user->save();
        return redirect('/home/user');
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

    public function filter(){
        $id=Auth::id();
        $title=$_GET['title'];
        $tags=$_GET['tags'];
        $from_date=$_GET['from_date'];
        $to_date=$_GET['to_date'];
        if($tags!=""){
            if($from_date!=""&&$to_date!="") {//inserite solo le date
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)->whereBetween('dataPubblicazione',[$from_date,$to_date])
                    ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')->get();
            }
            else{
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)
                    ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')->get();
            }
        }else{
            if($from_date!=""&&$to_date!="") {//inserite solo le date
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)->whereBetween('dataPubblicazione',[$from_date,$to_date])
                    ->where('titolo','LIKE','%'.$title.'%')->get();
            }
            else{
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)
                    ->where('titolo','LIKE','%'.$title.'%')->get();
            }
        }
        return view ('users.index', ['publications' => $publications, 'filter'=>1]);
    }

    public function userfilter($id){
        $title=$_GET['title'];
        $tags=$_GET['tags'];
        $from_date=$_GET['from_date'];
        $to_date=$_GET['to_date'];
        if($tags!=""){
            if($from_date!=""&&$to_date!="") {//inserite solo le date
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)->whereBetween('dataPubblicazione',[$from_date,$to_date])
                    ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')->get();
            }
            else{
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)
                    ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')->get();
            }
        }else{
            if($from_date!=""&&$to_date!="") {//inserite solo le date
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)->whereBetween('dataPubblicazione',[$from_date,$to_date])
                    ->where('titolo','LIKE','%'.$title.'%')->get();
            }
            else{
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)
                    ->where('titolo','LIKE','%'.$title.'%')->get();
            }
        }
        $users = DB::table('users')->select('id','name', 'cognome', 'dataNascita', 'email', 'nazionalita', 'affiliazione', 'dipartimento', 'linea_ricerca', 'telefono', 'visibilitaDN', 'visibilitaE', 'visibilitaN', 'visibilitaT')->where('users.id', '=', $id)->get();
        return view ('users.show', ['users'=> $users, 'publications' => $publications, 'filter'=>1]);
    }
}
