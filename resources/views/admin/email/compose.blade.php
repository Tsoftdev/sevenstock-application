@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" class="btn btn-primary btn-sm">Compose<i class="mdi mdi-plus"></i></a>
                            <ul>
                                <li>
                                    <a href="#page-inbox.html"><i class="fa fa-inbox"></i> Inbox <span class="label label-danger">4</span></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-star"></i> Stared</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-rocket"></i> Sent</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-trash"></i> Trash</a>
                                </li>

                            </ul>                
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="page-title-custom">
                                <h4>Compose Mail</h4>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.email.sendmailchimp') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="panel panel-default">
                                @if(Session::has('message'))
                                    <p class="alert alert-info">{{ Session::get('message') }}</p>
                                @endif
                                <div class="panel-body message">
                                    {{-- <p class="text-center">New Message</p> --}}
                                    {{-- <form class="form-horizontal" role="form"> --}}
                                        <div class="form-group">
                                            <label for="to" class="col-sm-1 control-label">To:</label>
                                            <div class="col-sm-11">
                                                  <input type="email" name="email_to" class="form-control select2-offscreen" id="to" placeholder="Type email" tabindex="-1">
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label for="cc" class="col-sm-1 control-label">CC:</label>
                                            <div class="col-sm-11">
                                                  <input type="email" name="email_cc"  class="form-control select2-offscreen" id="cc" placeholder="Type email" tabindex="-1">
                                            </div>
                                          </div>
                                        <div class="form-group">
                                            <label for="bcc" class="col-sm-1 control-label">Subject:</label>
                                            <div class="col-sm-11">
                                                  <input type="text" name="subject" class="form-control select2-offscreen" id="bcc" placeholder="Type email" tabindex="-1">
                                            </div>
                                          </div>
                                      
                                    {{-- </form> --}}
                                    
                                    <div class="col-sm-11 col-sm-offset-1">
                                        
                                        <div class="btn-toolbar" role="toolbar">
                                            
                                            <div class="btn-group">
                                                  <button class="btn btn-default"><span class="fa fa-bold"></span></button>
                                                  <button class="btn btn-default"><span class="fa fa-italic"></span></button>
                                                <button class="btn btn-default"><span class="fa fa-underline"></span></button>
                                            </div>
                    
                                            <div class="btn-group">
                                                  <button class="btn btn-default"><span class="fa fa-align-left"></span></button>
                                                  <button class="btn btn-default"><span class="fa fa-align-right"></span></button>
                                                  <button class="btn btn-default"><span class="fa fa-align-center"></span></button>
                                                <button class="btn btn-default"><span class="fa fa-align-justify"></span></button>
                                            </div>
                                            
                                            <div class="btn-group">
                                                  <button class="btn btn-default"><span class="fa fa-indent"></span></button>
                                                  <button class="btn btn-default"><span class="fa fa-outdent"></span></button>
                                            </div>
                                            
                                            <div class="btn-group">
                                                  <button class="btn btn-default"><span class="fa fa-list-ul"></span></button>
                                                  <button class="btn btn-default"><span class="fa fa-list-ol"></span></button>
                                            </div>
                                            <button class="btn btn-default"><span class="fa fa-trash-o"></span></button>	
                                            <button class="btn btn-default"><span class="fa fa-paperclip"></span></button>
                                            <div class="btn-group">
                                                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="fa fa-tags"></span> <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#">add label <span class="label label-danger"> Home</span></a></li>
                                                    <li><a href="#">add label <span class="label label-info">Job</span></a></li>
                                                    <li><a href="#">add label <span class="label label-success">Clients</span></a></li>
                                                    <li><a href="#">add label <span class="label label-warning">News</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <br>	
                                        
                                        <div class="form-group">
                                            <textarea class="form-control" id="message" name="body" rows="12" placeholder="Click here to reply"></textarea>
                                        </div>
                                        
                                        <div class="form-group">	
                                            <button type="submit" class="btn btn-success">Send</button>
                                            <button type="submit" class="btn btn-default">Draft</button>
                                            <button type="submit" class="btn btn-danger">Discard</button>
                                        </div>
                                    </div>	
                                </div>	
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection