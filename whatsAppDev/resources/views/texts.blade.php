@extends('layouts.app')


@section('content')
 <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {{ csrf_field() }}
            <form action="/display/postApi" method="POST" enctype="multipart/form-data">  
              <div class="form-group">                 
                <button type="submit" class="btn btn-primary">Send texts to Lab</button>
              </div>
            </form>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Displaying the Selected Texts!</div>                       
                <div class="panel-body">                    
                   
                    <ul>
                      @foreach ($textToDisplay as $key => $val)
                      <li> {{$textToDisplay[$key][0]. '  ' .$textToDisplay[$key][1]}} </li>
                      @endforeach
                    </ul>
                </div>
            </div>
        </div>                
    </div>
</div>
@endsection
