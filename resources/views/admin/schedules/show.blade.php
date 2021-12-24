<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">상태 선택</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="manage_info">
                <form class="needs-validation" id="StatusForm" novalidate>             
                    <div class="mb-3 row">
                        <label class="form-label" for="mstatus">상태 <span class="text-danger">*</span></label>
                        <select class="form-control select_status" id="mstatus" name="mstatus" required>
                            <option value="Active">완료</option>
                            <option value="Pending">진행중</option>
                            <option value="Canceled">취소</option>
                        </select>
                    </div>
                </form>
                <input type="hidden" id="scheduleid" />
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">취소하기</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_schedule_status_change">등록하기</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>