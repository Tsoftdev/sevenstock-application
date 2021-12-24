<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center px-3 py-2 bg-secondary">
            <h5 class="m-0 me-2 text-white">메모</h5>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-custom ms-auto" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" id="notifyadmintab" href="#notifyadmin" role="tabnotify">
                        <span class="d-block d-sm-none"><i class="fas fa-user-astronaut"></i></span>
                        <span class="d-none d-sm-block">관리자</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" id="notifycustomertab" href="#notifycustomer" role="tabnotify">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">User</span>
                    </a>
                </li>
            </ul>
        </div>
        <hr class="mt-0" />
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane ps-3 pe-3 pt-1 pb-2" id="notifyadmin" role="tabpanel">
                <div class="row mb-2" id="admin_notify_add_btn">
                    <div class="col-sm-8 pt-1 pb-1">
                        <a href="javascript:void(0);" class="btn btn-primary w-100 rounded btn_admin_add waves-effect waves-light">메모등록</a>
                    </div>
                    <div class="col-sm-4 pt-1 pb-1">
                        <button class="btn btn-secondary btn-block w-100 search-memo-data">To Do</button>
                    </div>
                </div>
                <div class="btn-group mt-1 w-100 mb-3" id="admin_memo_type">
                    <button type="button" class="btn btn-light border dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        All
                    </button>
                    <div class="dropdown-menu dropdown-menu-right w-100" style="padding:0px!important;">
                        @if($adminmemos_count != 0)
                        <a class="dropdown-item border admin_memo_all" style="text-align:center;" href="#">All
                            <span class="ms-1">({{$adminmemos_count}})</span>
                        </a>
                        @else
                        <a class="dropdown-item border admin_memo_all" style="text-align:center;" href="#">All
                        </a>
                        @endif
                        <a class="dropdown-item border admin_memo_personal" style="text-align:center;" href="#">Private</a>
                        <a class="dropdown-item border admin_memo_sent" style="text-align:center;" href="#">Delivered</a>
                    </div>
                </div>
                
                <div class="mt-3" id="admin_memo_type_list"></div>
                <div id="admin_memo_add" style="display:none;">
                    <form class="needs-validation" id="AdminMemoForm" novalidate>
                        <div class="row mb-3">
                            <div class="mb-0">
                                <!-- <label class="form-label" for="adminmemonote">내용 <span class="text-danger">*</span></label> -->
                                <textarea type="text" class="form-control" rows="5" id="adminmemonote" name="adminmemonote" placeholder="Here will be some text..." required></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label mt-1">Send to</label>
                            </div>
                            <div class="col-md-8">
                                <div class="justify-content-end d-flex">
                                    <select class="form-control" id="administrater" name="administrater" >
                                        <option value="">관리자..</option>
                                        @foreach($adminmemos as $adminmemo)
                                            <option value="{{$adminmemo->id}}">{{$adminmemo->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="admin_memo_id" />
                        <div class="row">
                            <div class="col-md-6">
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 btn_admin_memoadd"> 등록하기 </a>
                            </div>
                            <div class="col-md-6">
                                <a href="javascript:void(0);" class="btn btn-secondary btn-sm w-100 btn_admin_memocancel"> 취소 </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="admin_memo_update" style="display:none;">
                    <form class="needs-validation" id="AdminUpMemoForm" novalidate>
                        <div class="row mb-3">
                            <div class="mb-0">
                                <!-- <label class="form-label" for="adminmemonote">내용 <span class="text-danger">*</span></label> -->
                                <textarea type="text" class="form-control" rows="5" id="upadminmemonote" name="upadminmemonote" placeholder="Here will be some text..." required></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label mt-1">Send to</label>
                            </div>
                            <div class="col-md-8">
                                <div class="justify-content-end d-flex">
                                    <select class="form-control" id="upadministrater" name="upadministrater" >
                                        <option value="">관리자..</option>
                                        @foreach($adminmemos as $adminmemo)
                                            <option value="{{$adminmemo->id}}">{{$adminmemo->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="upadmin_memo_id" />
                        <div class="row">
                            <div class="col-md-6">
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 btn_admin_memoupdate"> 등록하기 </a>
                            </div>
                            <div class="col-md-6">
                                <a href="javascript:void(0);" class="btn btn-secondary btn-sm w-100 btn_admin_memocancel"> 취소 </a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="tab-pane active ps-3 pe-3 pt-1 pb-2" id="notifycustomer" role="tabpanel">
                <div class="input-group notifynamesearch" style="flex-wrap: nowrap;">
                    <span class="input-group-btn">
                        <button class="btn btn-light" type="button" style="border-bottom: 1px solid #ced4da;border-left: 1px solid #ced4da;border-top: 1px solid #ced4da;padding: 0.50rem .75rem;"><i class="fa fa-search"></i></button>
                    </span>
                    <input id="notify-user-searchbox" type="text" class="form-control" placeholder="이름/전화번호" style="border-left: 0px;padding: 0.50rem .75rem;">
                </div>
                <input type="hidden" id="notify_memo_customer_id" />
                <div class="mt-3" id="notify_user_list"></div>
                <div class="mt-3" id="notify_user_memo_list" style="display:none;"></div>
                <div id="notify_customer_memo_form_new" style="display:none;">
                    <form class="needs-validation" id="NotifyMemoForm" novalidate>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <a href="javascript:void(0);" class="btn btn-primary w-100 btn_notify_customer_memoadd"> 등록하기 </a>
                            </div>
                            <div class="col-md-4">
                                <a href="javascript:void(0);" class="btn btn-secondary w-100 btn_notify_customer_memocancel"> 취소 </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <!-- <label class="form-label" for="notifymemonote">내용 <span class="text-danger">*</span></label> -->
                                <textarea type="text" class="form-control" rows="6" id="notifymemonote" name="notifymemonote" placeholder="Here will be some text..." required></textarea>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="mb-3">
                                <!-- <label class="form-label" for="notifymemokeyword">키워드 </label> -->
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="notifymemokeyword" name="notifymemokeyword" data-role="tagsinput">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3">
                                <select class="form-control" id="notifymemocompany" name="notifymemocompany">
                                        <option value="">기업 ..</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->companyName}}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div id="notify_customer_memo_form_update" style="display:none;">
                    <form class="needs-validation" id="UpNotifyMemoForm" novalidate>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <a href="javascript:void(0);" class="btn btn-primary w-100 upbtn_notify_customer_memo"> 저장하기 </a>
                            </div>
                            <div class="col-md-4">
                                <a href="javascript:void(0);" class="btn btn-secondary w-100 btn_notify_customer_memocancel"> 취소 </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label" for="upnotifymemonote">내용 <span class="text-danger">*</span></label>
                                <textarea type="text" class="form-control" rows="5" id="upnotifymemonote" name="upnotifymemonote" placeholder="Here will be some text..." required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label" for="upnotifymemokeyword">키워드 </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="upnotifymemokeyword" name="upnotifymemokeyword" data-role="tagsinput">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <select class="form-control" id="upnotifymemocompany" name="upnotifymemocompany">
                                        <option value="">기업 ..</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->companyName}}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <input type="hidden" id="upnotifymemo_id" />
                        
                    </form>
                </div>
            </div>
            
        </div>
        
    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- memo Sidebar -->
<div class="right-bar-memo">
    <div data-simplebar class="h-100">

        <div class="rightbar-title d-flex align-items-center px-3 py-3 bg-secondary">
            <h5 class="m-0 me-2 text-white">메모</h5>
        </div>
        <hr class="mt-0" />
        <div class="p-3">
            <div class="row mb-2" id="customer_memo_add_form">
                <div class="col-sm-12 pt-1 pb-1">
                    <button class="btn btn-primary w-100 btn-block" id="customer_memo_add"> 메모등록</button>
                </div>
                <!-- <div class="col-sm-3 pt-1 pb-1">
                    <button class="btn btn-secondary btn-block w-100 search-memo-data"><i class="fa fa-search"></i></button>
                </div> -->
            </div>
            <div class="loader" style="display: none;"></div>
            <div id="customer_memo_list"></div>
            <div id="customer_memo_form_new" style="display:none;">
                <form class="needs-validation" id="MemoForm" novalidate>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <a href="javascript:void(0);" class="btn btn-primary w-100 btn_customer_memoadd"> 등록하기 </a>
                        </div>
                        <div class="col-md-4">
                            <a href="javascript:void(0);" class="btn btn-secondary w-100 btn_customer_memocancel"> 취소 </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <!-- <label class="form-label" for="memonote">내용 <span class="text-danger">*</span></label> -->
                            <textarea type="text" class="form-control" rows="6" id="memonote" name="memonote" placeholder="Here will be some text..." required></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="mb-3">
                            <!-- <label class="form-label" for="memokeyword">키워드 </label> -->
                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="키워드" id="memokeyword" name="memokeyword" data-role="tagsinput">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <select class="form-control" id="memocompany" name="memocompany">
                                    <option value="">기업 ..</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->companyName}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <input type="hidden" id="memo_customer_id" />
                    
                </form>
            </div>
            <div id="customer_memo_form_update" style="display:none;">
                <form class="needs-validation" id="UpMemoForm" novalidate>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <a href="javascript:void(0);" class="btn btn-primary w-100 upbtn_customer_memo"> 저장하기 </a>
                        </div>
                        <div class="col-md-4">
                            <a href="javascript:void(0);" class="btn btn-secondary w-100 btn_customer_memocancel"> 취소 </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <!-- <label class="form-label" for="upmemonote">내용 <span class="text-danger">*</span></label> -->
                            <textarea type="text" class="form-control" rows="6" id="upmemonote" name="upmemonote" placeholder="Here will be some text..." required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <!-- <label class="form-label" for="upmemokeyword">키워드 </label> -->
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="upmemokeyword" name="upmemokeyword" data-role="tagsinput">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <select class="form-control" id="upmemocompany" name="upmemocompany">
                                    <option value="">기업 ..</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->companyName}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <input type="hidden" id="upmemo_id" />
                    
                </form>
            </div>

        </div>


    </div>
</div>

<div class="rightbar-overlay-memo"></div>

<style>
    .nav-tabs>li>a {
        color: #ffffff;
    }
    .nav-tabs-custom .nav-item .nav-link.active {
        color: #343131;
    }
</style>



