@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>

<div id="app">
<passport-clients></passport-clients>
<passport-authorized-clients></passport-authorized-clients>
<passport-personal-access-tokens></passport-personal-access-tokens>
</div>

<div class="container">
    <div class="starter">
    <h1>Bootstrap starter template<small><abbr title="attribute">attr</abbr></small></h1>
    <p class="lead text-center">MOUM</p>
    You can use the mark tag to <mark>highlight</mark> text.
    <del>This line of text is meant to be treated as deleted text.</del>

    </div>

    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Library</a></li>
        <li class="active">Data</li>
    </ol>

    <span class="label label-default">Default</span>
    <span class="label label-primary">Primary</span>
    <span class="label label-success">Success</span>
    <h3>Example Header <span class="label label-info">New</span></h3>

    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        Well done!
    </div>

    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Warning!</strong> Better check yourself, you're not looking too good.
    </div>

    <div class="jumbotron">
        <h1>Hello, world!</h1>
    </div>

    <form role="form">
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      <div class="form-group">
        <label for="exampleInputFile">File input</label>
        <input type="file" id="exampleInputFile">
        <p class="help-block">Example block-level help text here.</p>
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox"> Check me out
        </label>
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>

    <nav>
        <ul class="pagination pagination-lg">
            <li class="disabled"><a href="#">&laquo;</a></li>
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">&raquo;</a></li>    
        </ul>
    </nav>

    <nav>
        <ul class="pager">
            <li class="previous disabled"><a href="#">&larr; Older</a></li>
            <li class="next"><a href="#">Newer &rarr;</a></li>
        </ul>
    </nav>
</div>
@endsection
