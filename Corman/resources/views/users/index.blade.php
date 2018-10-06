@extends('layouts.app')
<meta charset="UTF-8" http-equiv="X-UA-COMPATIBLE" content="IE=edge" name="viewport" contend="width=device-width, initial-scale=1">
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            @if(Auth::user()->immagineProfilo === null)
                <img class="img-responsive center-block" height="250" width="250" onclick="showUploadImage()" src="{{asset('images/default.jpg')}}">
            @else
                <img class="img-responsive center-block" height="250" width="250"  onclick="showUploadImage()" src="{{asset('images/'. Auth::user()->immagineProfilo)}}">
            @endif
            <br>
            <center><a href="{{'/users/'.Auth::user()->id}}" class="btn btn-primary">View your public profile</a></center>
            <br>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div>
                        <a style="float: right;" href="{{ action('UserController@edit', Auth::id() )}}"><span class="material-icons" style="font-size:20px; vertical-align:middle;">create</span></a>
                        <div style="float: left;">
                            <span class="material-icons" style="font-size:22px; vertical-align:middle;">cake</span>
                        </div>
                        <div style="margin-left: 25px;">
                            <h7 style="vertical-align: middle;">{{ Auth::user()->dataNascita }}</h7>
                        </div>
                    </div>
                    <div>
                        <div style="float: left;">
                            <span class="material-icons" style="font-size:22px; vertical-align:middle;">email</span>
                        </div>
                        <div style="margin-left: 25px;">
                            <h7 style="vertical-align: middle;">{{ Auth::user()->email }}</h7>
                        </div>
                    </div>
                    <div>
                        <div style="float: left;">
                            <span class="material-icons" style="font-size:22px; vertical-align:middle;">phone</span>
                        </div>
                        <div style="margin-left: 25px;">
                            <h7 style="vertical-align: middle;"> {{Auth::user()->telefono}}</h7>
                        </div>
                    </div>
                    <div>
                        <div style="float: left;">
                            <span class="material-icons" style="font-size:22px; vertical-align:middle;">language</span>
                        </div>
                        <div style="margin-left: 25px;">
                            <h7 style="vertical-align: middle;"> {{Auth::user()->nazionalita}}</h7>
                        </div>
                    </div>
                    <div>
                        <div style="float: left;">
                            <span class="material-icons" style="font-size:22px; vertical-align:middle;">location_on</span>
                        </div>
                        <div style="margin-left: 25px;">
                            <h7 style="vertical-align: middle;"> {{ Auth::user()->dipartimento }}</h7>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div><h1 style="vertical-align:middle;">{{Auth::user()->name." ".Auth::user()->cognome}}</h1></div>
            <h4 style="vertical-align:middle;">{{Auth::user()->affiliazione." - ".Auth::user()->linea_ricerca}}</h4>
            <center><button class="btn btn-primary" onclick="showNewPub()">Add new Paper</button></center>
            @if(count($publications) >0)
                <div>
                    <form action="{{ action('UserController@filter') }}" method="GET" class="form-horizontal">
                        <input name="_method" type="hidden" value="POST">
                        <h3>Filter papers</h3>
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Title</td><td><input class="form-control" type="text" name="title" id="name" placeholder="Paper title"></td>
                                <td>Tags</td><td><input class="form-control" type="text" name="tags" id="tags" placeholder="Tag1, Tag2, ..."></td>
                                <td>From</td><td><input id="from_date" name="from_date" class="form-control" type="number" min="1900" max="{{date('Y')}}" onfocusout="check()" placeholder="Year"></td>
                                <td>To</td><td><input id="to_date" name="to_date" class="form-control" type="number" min="1900" max="{{date('Y')}}" onfocusout="check()" placeholder="Year"></td>
                                <td><button style="float:right;" class="btn btn-success " name="submit" type="submit">Filter</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                @foreach($publications as $p)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="content">
                                @if($p->visibilita===1)
                                    <h5 style="color: green;"><strong>This paper is public</strong></h5>
                                @else
                                    <h5 style="color: red;"><strong>This paper is private</strong></h5>
                                @endif
                                <a style="float: right; margin-left: 10px;" href="{{action('PublicationController@edit', [$p->id] )}}"><span class="material-icons" style="font-size:20px; vertical-align:middle;">create</span></a>
                                <h6 style="float: left;">{{$p->tipo}}</h6><h5 style="text-align: right;">{{$p->dataPubblicazione}}</h5>
                                <!--<img class="img-responsive" style="float: right;" src="http://via.placeholder.com/250x250"> <!-- $->immagine -->
                                <h2>{{$p->titolo}}</h2>
                                @if($p->coautori!="")
                                    <div><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">people</span><h4 style="vertical-align:middle; margin-left: 25px;">{{$p->coautori}}</h4></div>
                                @endif
                                @if($p->tags!="")
                                    <div><span class="material-icons" style="font-size:15px; float: left; vertical-align:middle;">local_offer</span><h5 style="vertical-align:middle; margin-left: 25px;">{{$p->tags}}</h5></div>
                                @endif
                                <br>
                                <p>{{$p->descrizione}}</p>
                                <br>
                                @if($p->pdf != "")
                                    <div><a href="{{asset('pdf')."/".$p->pdf}}"><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">picture_as_pdf</span><h4 style="vertical-align:middle; margin-left: 25px;">PDF</h4></a></div>
                                    <!--
                                        <div><a><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">attach_file</span><h4 style="vertical-align:middle; margin-left: 25px;">nome_file.est</h4></a></div>
                                    -->
                                @else
                                    <div><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">picture_as_pdf</span><h4 style="vertical-align:middle; margin-left: 25px;">No PDF avaible</h4> <a href="{{action('PublicationController@edit', [$p->id] )}}" ><span class="material-icons" style="font-size:20px; vertical-align:middle; float: left;">file_upload</span> Upload PDF</a></div>
                                    <!--
                                        <div><a><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">attach_file</span><h4 style="vertical-align:middle; margin-left: 25px;">nome_file.est</h4></a></div>
                                    -->
                                @endif
                                <!-- in href inserire la action per scaricare i file e in h4 inserire nome del file $p->pdf o $p->multimedia -->
                                <br>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @if($filter==1)
                    <div>
                        <form action="{{ action('UserController@filter') }}" method="GET" class="form-horizontal">
                            <input name="_method" type="hidden" value="POST">
                            <h3>Filter papers</h3>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>Title</td><td><input class="form-control" type="text" name="title" id="name" placeholder="Paper title"></td>
                                    <td>Tags</td><td><input class="form-control" type="text" name="tags" id="tags" placeholder="Tag1, Tag2, ..."></td>
                                    <td>From</td><td><input id="from_date" name="from_date" class="form-control" type="number" min="1900" max="{{date('Y')}}" onfocusout="check()" placeholder="Year"></td>
                                    <td>To</td><td><input id="to_date" name="to_date" class="form-control" type="number" min="1900" max="{{date('Y')}}" onfocusout="check()" placeholder="Year"></td>
                                    <td><button style="float:right;" class="btn btn-success " name="submit" type="submit">Filter</button></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <hr>
                    <center><h4><i>No results</i></h4></center>
                @else
                    <hr>
                    <center><h4><i>You have no papers</i></h4></center>
                @endif
            @endif
        </div>
    </div>

    <div id="uploadImage" class="modal" style="display: none; position: fixed; z-index: 1; padding-top: 100px;
        left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: #F0f8ff; margin: auto;
            border: 1px solid #888; width: 50%; height: auto">
            <div class="panel">
                <div class="panel-heading">
                    <h2>Modify Profile Image</h2>
                </div>
                <div class="panel-body">
                    <form action="{{action('UserController@uploadImage', Auth::id())}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <table class="table">
                            <tr>
                                <td>Profile Image</td>
                                <td><input type="file" name="immagineProfilo" id="pdf"></td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <button style="float:right;" class="btn btn-success " name="submit" type="submit">Upload</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="addPaper" class="modal" style="display: none; position: fixed; z-index: 1; padding-top: 100px;
        left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);">
        <div class="modal-content" style="background-color: #F0f8ff; margin: auto;
            border: 1px solid #888; width: 70%; height: auto">
            <div class="panel">
                <div class="panel-body">
                <form action="{{ action('PublicationController@store') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="POST">
                        <h3>New paper</h3>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td style="width: 50%;">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Title (*)</td><td><input class="form-control" id="titolo" name="titolo" type="text" placeholder="Title (max 255 chars)" required></td>
                                    </tr>
                                    <tr>
                                        <td>Type (*)</td><td><input class="form-control" id="tipo" name="tipo" type="text" placeholder="Paper Type" required></td>
                                    </tr>
                                    <tr>
                                        <td>Year (*)</td><td><input class="form-control" id="year" name="year" type="number" placeholder="Paper Year" min="1900" max="{{date('Y')}}" required></td>
                                    </tr>
                                    <tr>
                                        <td>PDF</td>
                                        <td><input type="file" name="pdf" id="pdf"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width: 50%;">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Visibility</td>
                                        <td class="button-group">
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td>
                                                        <center>
                                                            <label style="font-size: 15px;"><input type="radio" name="visibilita" value="1" checked="checked">Public</label>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <label style="margin-left: 5px; font-size: 15px;"><input type="radio" name="visibilita" value="0">Private</label>
                                                        </center>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tags</td><td><input class="form-control" id="tags" name="tags" type="text" placeholder="Tags separated by a ',' (max 255 chars)"></td>
                                    </tr>
                                    <tr>
                                        <td>Description</td><td><textarea style="resize:none;" maxlength="191" class="form-control" id="descrizione" name="descrizione" type="text" placeholder="Description (max 255 chars)"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td>Coauthors</td><td><input class="form-control" id="coautori" name="coautori" type="text" placeholder="Coauthors separated by a ',' (max 255 chars)"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                        <h6 style="float: left;">Fields with (*) must be set.</h6>
                        <button style="float:right;" class="btn btn-success " name="submit" type="submit">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function check(){
        var to_date, from_date;
        to_date=document.getElementById('to_date');
        from_date=document.getElementById('from_date');
        if(to_date.value!="" && from_date.value!=""){
            if(to_date.value<from_date.value){
                val=to_date.value;
                val++;
                to_date.value=val;
                alert('Inserire una data valida');
            }
        }
    }

    function showNewPub(){
        document.getElementById('addPaper').style.display="block";
    }

    function showUploadImage(){
        document.getElementById('uploadImage').style.display="block";
    }
</script>
@endsection
