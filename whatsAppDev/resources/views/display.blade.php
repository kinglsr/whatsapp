@extends('layouts.app')


@section('content')
 <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Hurray!!</div>                       
                <div class="panel-body">                    
                    Select the Dates and Name you want to search
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
             <form action="/display/getContent" method="POST" >
             {{ csrf_field() }}
              <div class="form-group">
                <label for="personName">Enter A Person Name</label>
                <input type="text" class="form-control" id="personName" name="personName" >
              </div>
              OR
             <div class="form-group">
                <label for="both">Check the Box to select both texts</label>
                <input type="checkbox" class="form-control" id="both" name="both" >
              </div>
              <div class="form-group">
                <label for="fromDate">From Date</label>
                <input class="form-control" type="date" name="fromDate" id="fromDate" required>
              </div> 

              <div class="form-group">
                <label for="toDate">From Date</label>
                <input class="form-control" type="date" name="toDate" id="toDate" required>
              </div> TO DATE SHOULD BE GREATER THAN FROM DATE       
              
              <div class="form-group">
              <button type="submit" class="btn btn-primary">Get the Content</button>
              </div>
            </form>
       </div>            
    </div>
</div>
@endsection
