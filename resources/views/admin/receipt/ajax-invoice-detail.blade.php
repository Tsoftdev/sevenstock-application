<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6">
                        <address>
                            <h3><strong>{{$receipt->invoicenumber}}</strong></h3>
                            <h5>{{$receipt->employee->company->companyName}}</h5><br>
                        </address>
                    </div>
                    <div class="col-md-6 text-end">
                        <img class="company-img" src="{{ asset('assets/images/logo.png') }}" alt="sevenstock logo">
                        <address>
                            <strong>340 $ Lemon ave a 3696</strong><br>
                            walruv, California<br>
                            United State 91789<br>
                        </address>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-3">
                <h5>Employee Name</h5>
                <span>{{$receipt->employee->name}}</span>
            </div>
            <div class="col-3">
                <h5>Issued On</h5>
                <span>{{ date('Y.m.d', strtotime($receipt->issueddate)) }}</span>
            </div>
            <div class="col-3">
                <h5>Category</h5>
                <span>{{$receipt->category}}</span>
            </div>
            
        </div>
        <br>
        <div class="row mt-3">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th width="50%"><strong>Item</strong></th>
                                <th width="15%" class="text-center"><strong>Qty</strong></th>
                                <th width="15%" class="text-center"><strong>Price</strong>
                                </th>
                                <th width="15%" class="text-end"><strong>Total</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($receipt->receiptitem as $item)
                            <tr>
                                <td><strong>{{$item->item}}</strong></td>
                                <td class="text-center">{{number_format($item->quantity)}}</td>
                                <td class="text-center">{{number_format($item->price)}}</td>
                                <td class="text-end">{{number_format($item->total)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-end">
                        <div class="col-md-3">
                            <h5 class="text-end p-1">Total Amount</h5>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-end p-1">{{number_format($receipt->receiptitem()->sum('total'))}} 원</h4>
                        </div>
                    </div>
                </div>
                <div class="row p-3 mt-3">
                    <label class="form-label" for="invoicenote">Note</label>
                    <textarea type="text" class="form-control" id="invoicenote" name="invoicenote" rows="3" placeholder="Here will be some note.">{{$receipt->note}}</textarea>
                </div>
                <div class="row p-3 mt-3">
                    <label class="form-label" for="invoicenote">Payment Info</label>
                    <p class="form-control p-3" id="paymentinfo" name="paymentinfo">
                        @if($receipt->payment == "CH")
                        <span class="text-success fw-bold" style="font-size:16px;padding-right: 25px;">CASH  </span>
                        <span class="text-dark fw-bold" style="font-size:16px;">{{$receipt->bankname ? $receipt->bankname : ""}}</span>
                        @elseif($receipt->payment == "CD")
                        <span class="text-success fw-bold" style="font-size:16px;padding-right: 25px;">CARD  </span>
                        @endif
                    </p>
                </div>
                @if($receipt->invoicephoto)
                <div class="row" mt-3>
                    @foreach ($receipt->invoicephoto as $photo)
                        <div class="col-md-3">
                            <a data-lightbox="image-1" href="{{$photo->photo}}">
                                <img src="{{$photo->photo}}" class="img-thumbnail">
                            </a>
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        <!-- end row -->
    </div>
</div>