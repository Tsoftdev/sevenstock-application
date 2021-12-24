<form class="form-horizontal needs-validation" enctype="multipart/form-data" method="POST" action="{{ route('admin.receipt.update', ['id' => $receipt->id]) }}" novalidate>
    @csrf
    <div class="row mb-3">
        <div class="col-md-6 invoice-title">
            <span class="mt-1 bold" style="font-size:18px;">Update a receipt transaction</span>
        </div>
        <div class="col-md-6">
            <div class="row d-flex justify-content-end">
                <div class="col-md-3 p-1">
                    <button type="button" class="btn btn-secondary waves-effect waves-light w-100 invoice-btn">Cancel</button>
                </div>
                <div class="col-md-3 p-1">
                    <button type="submit" name="submit" value="submit" class="btn btn-success waves-effect waves-light w-100 invoice-btn">Update</button>
                </div>
            </div>
        </div>              
    </div>
    <hr/>
    <div class="row p-1">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label" for="uppayment">Cash/Card</label>
                        <select class="form-control select2" id="uppayment" name="uppayment">
                            <option value="">Select..</option>
                            <option value="CD" @if($receipt->payment == "CD") selected @endif>Card</option>
                            <option value="CH" @if($receipt->payment == "CH") selected @endif>Cash</option>
                        </select>
                    </div>  
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="upbankname">Bank Name</label>
                            <input type="text" class="form-control" style="height:38px;" id="upbankname" name="upbankname" value="{{$receipt->bankname}}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="upbankinformation">Bank Information</label>
                            <input type="text" class="form-control" style="height:38px;" id="upbankinformation" name="upbankinformation" value="{{$receipt->bankinformation}}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="upistatus">Status</label>
                            <div class="input-group">
                                <select class="form-control select2" id="upistatus" name="upistatus" required>
                                    <option value="P" @if($receipt->status == "P") selected @endif>Pending</option>
                                    <option value="PP" @if($receipt->status == "PP") selected @endif>Request a Photo</option>
                                    <option value="R" @if($receipt->status == "R") selected @endif>Rejected</option>
                                    <option value="A" @if($receipt->status == "A") selected @endif>Completed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label" for="upemployee_filter">Employee</label>
                        <select class="form-control select2" id="upemployee_filter" name="upemployee_filter" required>
                            <option value="">Employee ..</option>
                            @foreach($employees as $employee)
                                <option value="{{$employee->id}}" data-company="{{$employee->companyId}}" @if($receipt->employeeId == $employee->id) selected @endif>{{$employee->name}}</option>
                            @endforeach
                        </select>
                    </div>  
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="upicompany">Company</label>
                            <select class="form-control select2" id="upicompany" name="upicompany" required>
                                <option value="">기업 ..</option>
                                @foreach($ucompanies as $ucompany)
                                    <option value="{{$ucompany->id}}" @if($receipt->companyId == $ucompany->id) selected @endif>{{$ucompany->companyName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="upicategory">Category</label>
                            <input type="text" class="form-control" style="height:38px;" id="upicategory" name="upicategory" value="{{$receipt->category}}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="upissuedon">Issued On</label>
                            <input type="text" class="form-control" id="upissuedon" name="upissuedon" style="height:38px;" value="{{ date('Y.m.d', strtotime($receipt->issueddate)) }}" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="border p-3">
                    @foreach($receipt->receiptitem as $key=>$item)
                    <div class="row" id="upreceiptdetail_{{$key}}">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label" for="upitemname_{{$key}}">Item Name</label>
                                <input type="text" class="form-control" value="{{$item->item}}" style="height:38px;" id="upitemname_{{$key}}" name="upitemname_{{$key}}" required>
                            </div>
                        </div>  
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label" for="upquantity_{{$key}}">Quantity</label>
                                <input type="text" class="form-control integer" value="{{$item->quantity}}" style="height:38px;" id="upquantity_{{$key}}" name="upquantity_{{$key}}" onchange="upvalor()" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label" for="price_{{$key}}">Price</label>
                                <input type="text" class="form-control integer" value="{{$item->price}}" style="height:38px;" id="upprice_{{$key}}" name="upprice_{{$key}}" onchange="upvalor()" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label" for="uptotal_{{$key}}">Total</label>
                                <input type="text" class="form-control integer" value="{{$item->total}}" style="height:38px;" id="uptotal_{{$key}}" name="uptotal_{{$key}}" readonly required>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <input type="hidden" name="uptotal_item" id="uptotal_item" value="{{$receipt->receiptitem->count()}}"/>
                </div>
                <div class="row mt-3">
                    <div class="justify-content-end d-flex">
                        <div class="col-md-2 invoice-title">
                            <h5 class="text-end p-1">Total Amount</h5>
                        </div>
                        <div class="col-md-2 invoice-title">
                            <h5 class="text-end p-1" id="uptotalamount">{{number_format($receipt->receiptitem->sum('total'))}} 원</h5>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" id="btn_add_item_up" class="btn btn-sm btn-primary invoice-btn">Add Item</button>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label" for="upinote">Note</label>
                            <textarea type="text" class="form-control" rows="4" id="upinote" name="upinote" required>{{$receipt->note}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label" for="inote">Photo</label>
                            <div class="upinvoice_photo" style="padding-top: .5rem;"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</form>
<script>
    $('#upissuedon').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $('.upinvoice_photo').imageUploader();
    $(".select2").select2({width: '100%'});
    var j =0;
    $("#btn_add_item_up").on('click', function (){
        var div_uptemp = "#upreceiptdetail_" + k;
        k++;
        $("#uptotal_item").val(k+1);
        return $(
            '<div class="row" id="upreceiptdetail_'+ k + '">'+
                '<div class="col-md-3">'+
                    '<div class="mb-3">'+
                        '<label class="form-label" for="upitemname_' + k + '">Item Name</label>' + 
                        '<input type="text" class="form-control" style="height:38px;" id="upitemname_' + k + '" name="upitemname_' + k + '" required>' + 
                    '</div>'+
                '</div>' +
                '<div class="col-md-3">'+
                    '<div class="mb-3">'+
                        '<label class="form-label" for="upquantity_' + k + '">Quantity</label>' + 
                        '<input type="text" class="form-control integer" style="height:38px;" onchange="upvalor()" id="upquantity_' + k + '" name="upquantity_' + k + '" required>' + 
                    '</div>'+
                '</div>' +
                '<div class="col-md-3">'+
                    '<div class="mb-3">'+
                        '<label class="form-label" for="upprice_' + k + '">Price</label>' + 
                        '<input type="text" class="form-control integer" style="height:38px;" onchange="upvalor()" id="upprice_' + k + '" name="upprice_' + k + '" required>' + 
                    '</div>'+
                '</div>' +
                '<div class="col-md-3">'+
                    '<div class="mb-3">'+
                        '<label class="form-label" for="uptotal_' + k + '">Total</label>' + 
                        '<input type="text" class="form-control integer" style="height:38px;" id="uptotal_' + k + '" name="uptotal_' + k + '" readonly required>' + 
                    '</div>'+
                '</div>' +
            '</div>'
        ).insertAfter(div_uptemp);
    });
    function upvalor() {	 
        var upalltotal = 0;
        var uptotal_len = $("#uptotal_item").val();
        
        for (var i=0; i<uptotal_len; i++){
            var uptotal = "#uptotal_" + i;
            uptquantity = "#upquantity_" + i;
            uptprice = "#upprice_" + i;
            if($(uptquantity).val() != "" && $(uptprice).val() != ""){
                uptotal_temp = parseFloat($(uptquantity).val()*$(uptprice).val());
                $(uptotal).val(uptotal_temp);
                upalltotal += uptotal_temp;	
            } 
        }
        $("#uptotalamount").text(Intl.NumberFormat('en-US').format(upalltotal) + "원");
    }
</script>