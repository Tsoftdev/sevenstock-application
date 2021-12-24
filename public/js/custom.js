function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

jQuery(function($) {
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    //------------- Create Record ----------//
    $("#form").off().on("submit", function() {
        var formData = new FormData($("#form")[0]);
        $.ajax({
            beforeSend: function() {
                $("#form").find('button').attr('disabled', true);
                $("#form").find('button>i.fa').show();
            },
            url: $("#form").attr('action'),
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    if (response.reload != '') {
                        location.reload();
                    }else if (response.redirect_url != '') {
                        toastr.success(response.message, 'Success');
                        setTimeout(function() {
                            location.href = response.redirect_url;
                        }, 2000);
                    }
                } else {
                    toastr.error('Something going wrong!', 'Opps!');
                }
            },
            complete: function() {
                $("#form").find('button').attr('disabled', false);
                $("#form").find('button>i.fa').hide();
            },
            error: function(status, error) {
                var errors = JSON.parse(status.responseText);
                if (status.status == 401 || status.status == 400) {
                    console.log(errors);
                    $("#form").find('button').attr('disabled', false);
                    $("#form").find('button>i.fa').hide();
                    $.each(errors.error, function(i, v) {
                        toastr.error(v[0], 'Opps!');
                    });
                } else {
                    toastr.error(errors.message, 'Opps!');
                }
            }
        });
        return false;
    });

    //------------- Create Record ----------//
    $("#form2").off().on("submit", function() {
        var formData = new FormData($("#form2")[0]);
        $.ajax({
            beforeSend: function() {
                $("#form2").find('button').attr('disabled', true);
                $("#form2").find('button>i.fa').show();
            },
            url: $("#form2").attr('action'),
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    if (response.reload != '') {
                        location.reload();
                    } else if (response.redirect_url != '') {
                        toastr.success(response.message, 'Success');
                        setTimeout(function() {
                            location.href = response.redirect_url;
                        }, 2000);
                    }
                } else {
                    toastr.error('Something going wrong!', 'Opps!');
                }
            },
            complete: function() {
                $("#form2").find('button').attr('disabled', false);
                $("#form2").find('button>i.fa').hide();
            },
            error: function(status, error) {
                var errors = JSON.parse(status.responseText);
                if (status.status == 401 || status.status == 400) {
                    console.log(errors);
                    $("#form2").find('button').attr('disabled', false);
                    $("#form2").find('button>i.fa').hide();
                    $.each(errors.error, function(i, v) {
                        toastr.error(v[0], 'Opps!');
                    });
                } else {
                    toastr.error(errors.message, 'Opps!');
                }
            }
        });
        return false;
    });


    /*choose image preview */
    $("body").on('change','.select_img', function () {
        var parent = $(this).closest('.img_contain');
        var id     = parent.find('.preview_img');
        readURL(this, id);
    });
    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                id.attr('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".select2").select2({width: "100%"});
    
    //copy and past address
    $("body").on('click','.copyAddress',function(){
       var address = $(this).data('address');
       $(".pastAddress").val(address);
    });

    $("body").on('click','.show-more',function(){
        $(this).parent().hide();
        $(this).parent().next().show();
    });

    $("body").on('click','.show-less',function(){
        $(this).parent().hide();
        $(this).parent().prev().show();
    });

    //customer filter form reset on sms page
    $("body").on('click','.reset-form',function(){
        document.getElementById("customer_filter_form").reset();
     });

    //show title wrapper
    $("body").on('click','.titleSection',function(){
        $(".title_wrapper").removeClass('d-none');
        $(".title_wrapper").addClass('d-block')
        $(".category_wrapper").addClass('d-none');
        $(".category_wrapper").removeClass('d-block')
        $(".title_listing_wrapper").removeClass('d-none');
        $(".title_listing_wrapper").addClass('d-block');
    });

    //get titles records by category
    $('body').on('change','.category', function(){
        var category_id = $(this).val();
        $.ajax({
            type : 'get',
            url : ajaxUrl+'/admin/getTitlesByCategory',
            data:{'category_id':category_id},
            success:function(response){
                $('.title_listing_wrapper').html(response.html);
            },
            error: function(status, error) {
                var errors = JSON.parse(status.responseText);
                if (status.status == 401 || status.status == 400) {
                    $.each(errors.error, function(i, v) {
                        toastr.error(v[0], 'Opps!');
                    });
                }else{
                    toastr.error(errors.message, 'Opps!');
                }
            }
        });
    });

    //show caregory wrapper
    $("body").on('click','.categorySection',function(){
        $(".category_wrapper").removeClass('d-none');
        $(".category_wrapper").addClass('d-block')
        $(".title_wrapper").addClass('d-none');
        $(".title_wrapper").removeClass('d-block')
        $(".title_listing_wrapper").addClass('d-none');
    });

    //hide caregory wrapper
    $("body").on('click','.hideTitleWrapper',function(){
        $(".title_wrapper").addClass('d-none');
        $(".title_wrapper").removeClass('d-block')
    }); 

    //hide caregory wrapper
    $("body").on('click','.hideCategoryWrapper',function(){
        $(".title_listing_wrapper").addClass('d-block');
        $(".title_listing_wrapper").removeClass('d-none');
        $(".category_wrapper ").addClass('d-none');
        $(".category_wrapper ").removeClass('d-block')
    });

    //edit article
    $("body").on('click','.editArticle',function(){
        var r = $(this).data('data');
        var img = $(this).data('img');
        var tag_ids = $(this).data('tag_ids');
        $("#tag_ids").val(tag_ids).trigger('change');
        $("#company_id").val(r.company_id).trigger('change');
        $("#title").val(r.title);
        $("#website_url").val(r.website_url);
        var date = moment(r.created_at).format('YYYY.MM.DD');
        $("#datepicker1").val(date);
        $("#article_name").val(r.name);
        if(r.comment_on_off=='on'){
            $('#comment_on_off_wrapper').show();
            $("#switch1").val(r.comment_on_off);
            $("#switch1").attr('checked', true);
            $("#comment_title").val(r.comment_title);
            $("#comment_description").val(r.comment_description);
        }else{
            $('#comment_on_off_wrapper').hide();
            $("#switch1").val(r.comment_on_off);
            $("#switch1").attr('checked', false);
            $("#comment_title").val('');
            $("#comment_description").val('');
        }
        
        tinyMCE.get('tinymceEditor1').setContent(r.description);
        tinymce.EditorManager.get('tinymceEditor1').focus();

        $(".select_img").val('');
        $(".preview_img").attr('src',img);
        $("#article_id").val(r.id);
    });

    //tinymce image upload in editor
    tinymce.init({
        selector: '#tinymceEditor1',
        image_class_list: [
            {title: 'img-responsive', value: 'img-responsive'},
        ],
        height: 500,
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
        },
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste imagetools"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image ",

        image_title: true,
        automatic_uploads: true,
        images_upload_url: '/admin/article/tinymce/image/upload',
        file_picker_types: 'image',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        }
    });

    //edit categoey modal
    $("body").on('click','.editCategory',function(){
       var r = $(this).data('data');
       var button = 'Update<i class="fa fa-spinner fa-spin" style="display:none;"></i>'
       $("#category_name").val(r.name);
       $("#categoryId").val(r.id);
       $("#form2 button").html(button);
       $("#category_name").focus();
    });

    //edit file modal
    $("body").on('click','.editFile',function(){
        $(".titleSection").trigger('click');
       var r = $(this).data('data');
       var category_id = $(this).data('category_id');
       var button = 'Update<i class="fa fa-spinner fa-spin" style="display:none;"></i>'
       $("#category_id").val(category_id);
       $("#title_name").val(r.name);
       $("#title_description").val(r.description);
       $("#title_id").val(r.id);
       $("#form button.exp_heading").html(button);
       $("#title_name").focus();
    });

    //file description copy to Clipboard
    $("body").on('click', '.copy-btn', function() {
        let tmpElement = $('<textarea style="opacity:0;"></textarea>');
        let parent = $(this).closest('.row').find('.full-desc span').each(function(){
            tmpElement.text(tmpElement.text() + $(this).text());
        });
        tmpElement.appendTo($('body')).select();
        document.execCommand("copy");
        tmpElement.remove();
        toastr.success('Copy To Clipboard', 'Success');
    });

    var array = [];
    $(".selectCheckboxAll").click(function(){
        if($(this).data('ck') == 1){
            $(".selectCheckboxAll").prop('checked', true);
            $("input:checkbox[name=customer_ids]").prop('checked', true);
        }else{
            $("input:checkbox[name=customer_ids]").prop('checked', $(this).prop('checked'));
        }
        $('input:checkbox[name=customer_ids]').each(function(){
            var value = $(this).val();
            var name = $(this).data('name');
            var phone = $(this).data('phone');
            if($(this).is(':checked')){
                var index = array.findIndex((e) => e.id == value);
                if(index < 0){
                    array.push({id:value,name: name,phone: phone});
                    $(".selectedUser").text(array.length);
                }
            }else{
                var index = array.findIndex((e) => e.id == value);
                array.splice(index, 1);
                $(".selectedUser").text(array.length);
            }
        });
    });
    var array = [];
    $("body").on('click','.selectCheckbox', function(){
        var value = $(this).val();
        var name = $(this).data('name');
        var phone = $(this).data('phone');
        if($(this).is(':checked')){
            var index = array.findIndex((e) => e.id == value);
            if(index < 0){
                array.push({id:value, name: name,phone: phone});
                $(".selectedUser").text(array.length);
            }
        }else{
            var index = array.findIndex((e) => e.id == value);
            array.splice(index, 1);
            $(".selectedUser").text(array.length);
        }
        if($(".selectCheckbox:checked").length == $(".selectCheckbox").length){
            $(".selectCheckboxAll").prop('checked', true);
        }else{
            $(".selectCheckboxAll").prop('checked', false);
        }
    });

    $("#selectuser").click(function(){
        contactList();
    });

    $("body").on('click','.deleteContact', function(){
        var index = $(this).data('index');
        var row = array[index];
        console.log('row',row);
        $("#name_"+row.id).prop('checked', false);
        array.splice(index, 1);
        contactList();
        if($(".selectCheckbox:checked").length == $(".selectCheckbox").length){
            $(".selectCheckboxAll").prop('checked', true);
        }else{
            $(".selectCheckboxAll").prop('checked', false);
        }
        $(".selectedUser").text(array.length);
    });

    $(".reset").click(function(){
        array = [];
        $(".selectCheckboxAll").prop('checked', false);
        $(".selectCheckbox").prop('checked', false);
        $(".selectedUser").text(array.length);
        contactList();
    });
    function contactList(){
           var html = '';
        if(array.length > 0){
            array.forEach(function(k,v){
                console.log(k,v)
                html += '<tr>';
                html += '<td>'+k['name']+'</td>';
                html += '<td>'+k['phone']+'</td>';
                html += '<td><a href="javascript:void(0);" class="deleteContact" data-index="'+v+'"><i class="fa fa-trash text-danger"></i></a></td>';
                html += '</tr>';
            });
        }
        $("#contact_list").html(html);
    }

    $("body").on('click','#send_message',function(){
        if(array.length > 0){
            if($("#message").val() !=''){
                console.log($("#picture").val());
                if($("#picture").val()){
                    var fileExtension = ['jpeg', 'png', 'gif'];
                    if(jQuery.inArray($("#picture").val().split('.').pop().toLowerCase(), fileExtension) < 0){
                        toastr.error('Only formats are allowed : '+fileExtension.join(', '), 'Opps!');
                        return false;
                    }
                }
                var formData = new FormData($("#sendSmsForm")[0]);
                formData.append('customer', JSON.stringify(array));

                $.ajax({
                    beforeSend: function() {
                        $("#sendSmsForm").find('button>i').show();
                    },
                    url: ajaxUrl+'/admin/sendSms',
                    data: formData,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            if (response.reload != '') {
                                location.reload();
                            } else if (response.redirect_url != '') {
                                toastr.success(response.message, 'Success');
                                setTimeout(function() {
                                    location.href = response.redirect_url;
                                }, 2000);
                            }
                        } else {
                            toastr.error('Something going wrong!', 'Opps!');
                        }
                    },
                    complete: function() {
                        $("#sendSmsForm").find('button>i').hide();
                    },
                    error: function(status, error) {
                        var errors = JSON.parse(status.responseText);
                        if (status.status == 401 || status.status == 400) {
                            $("#sendSmsForm").find('button').attr('disabled', false);
                            $("#sendSmsForm").find('button>i').hide();
                            $.each(errors.error, function(i, v) {
                                toastr.error(v[0], 'Opps!');
                            });
                        } else {
                            toastr.error(errors.message, 'Opps!');
                        }
                    }
                });
            }else{
                toastr.error('Please enter the message first.', 'Opps!');
            }
        }else{
            toastr.error('Please first select customer.', 'Opps!');
        }
        return false;
    });
});

var url_vars = getUrlVars();
var sms_customer_datatable = $('#sms_customer_datatable').DataTable({
    aaSorting: [[ 0, "desc" ]],
    lengthChange:false,
    processing: false,
    serverSide: false,
    searching: true, 
    pageLength: 25,
    paging: true, 
    info: false,
    "ajax": {
        "url": ajaxUrl+'/admin/messages',
        "data": function ( d ) {
            d.group_filter = $('select#group_filter').val();
            d.company_filter = $('select#company_filter').val();
            d.city_filter = $("select#city_filter").val();
            d.customer_id= url_vars['customer_id'] !== undefined ? url_vars['customer_id'] : ''
        }
    },
    "dom": 'Bfrtip',
    columnDefs: [ {
        "targets": 0,
        "orderable": false,
        "searchable": false
    } ],
    select: true,
    columns:[
        {"data":"mass_delete"},
        {"data":"name"},
        {"data":"cityName"},
        {"data":"phonenumber1"},
        {"data":"customerGroupID"}
    ],
    "drawCallback": function( settings ) {
        if(url_vars['customer_id'] !== undefined ){
             $("#name_"+url_vars['customer_id']).trigger('click').trigger('click');
        }     
    }
});

sms_customer_datatable.page.len(100).draw();

$('select#group_filter, select#company_filter, select#city_filter').on('change', function(){
    sms_customer_datatable.ajax.reload();
});

$('.getPageLength').on('change', function(){
    sms_customer_datatable.page.len($(this).val()).draw();
});

$('#message').keyup(function() {
    var characterCount = $(this).val().length,
    current = $('#current'),
    maximum = $('#maximum'),
    theCount = $('#the-count');
    current.text(characterCount);
    if(characterCount > 90){
        maximum.text(2000);
        $(this).attr('maxlength', 2000);
    }else{
        maximum.text(90);
    }
});

$(".company_filter").on('click', function(e){
    var company_id = $(this).data("id");
    var customer_id = $(this).data("customer_id");
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajaxUrl+'/admin/getCompanyFilterView',
        type: 'POST',    
        data: {
            company_id:company_id,
            customer_id:customer_id
        },
        success:function(response){
            if(response.success){
                $("#filter_append_html").html(response.html);
            }
        },
        error:function(status,error){
            var errors = JSON.parse(status.responseText);
            if(status.status == 401){
                $(".ajax_loader").hide();
                $.each(errors.error, function(i,v){
                    toastr.error( v[0],'Opps!');
                });
            }else{
                toastr.error(errors.message,'Opps!');
            }
        }
    });
});
$(".manageModalBtn").on('click', function(e){
    var type = $(this).data("type");
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajaxUrl+'/admin/getModalView',
        type: 'POST',    
        data: {type:type},
        success:function(response){
            if(response.success){
                $("#html_append").html(response.html);
                $("#manageModal").modal('show');
            }
        },
        error:function(status,error){
            var errors = JSON.parse(status.responseText);
            if(status.status == 401){
                $(".ajax_loader").hide();
                $.each(errors.error, function(i,v){
                    toastr.error( v[0],'Opps!');
                });
            }else{
                toastr.error(errors.message,'Opps!');
            }
        }
    });
});
$("body").on('submit', '#infoSubForm', function(){
    var that = $(this);
    var formData = new FormData(that[0]);
    $.ajax({
        beforeSend: function() {
            that.find('button>i.fa').show();
        },
        url: that.attr('action'),
        data: formData,
        type: 'POST',
        processData: false,
        contentType: false,
        success: function(response) {
            if(response.success) {
                toastr.success(response.message, 'Success');
                location.reload();
            } 
        },
        complete: function() {
            that.find('button>i.fa').hide();
        },
        error: function(status, error) {
            var errors = JSON.parse(status.responseText);
            if (status.status == 401 || status.status == 400) {
                that.find('button>i.fa').hide();
                $.each(errors.error, function(i, v) {
                    toastr.error(v[0], 'Opps!');
                });
            } else {
                toastr.error(errors.message, 'Opps!');
            }
        }
    });
    return false;
});

$("body").on('click','.editStatus', function(){
    var r = $(this).data("data");
    $("#statusName").val(r.statusName);
    $("#type_id").val(r.id);
});
$("body").on('click','.editLevel', function(){
    var r = $(this).data("data");
    $("#levelName").val(r.levelName);
    $("#type_id").val(r.id);
});
$("body").on('click','.editCity', function(){
    var r = $(this).data("data");
    $("#cityName").val(r.cityName);
    $("#type_id").val(r.id);
});
$("body").on('click','.editAgent', function(){
    var r = $(this).data("data");
    $("#groupName").val(r.groupName);
    $("#type_id").val(r.id);
});
$("body").on('click','.editStockbroker', function(){
    var r = $(this).data("data");
    $("#brokerName").val(r.brokerName);
    $("#type_id").val(r.id);
});
$("body").on('click','.editRouteknown', function(){
    var r = $(this).data("data");
    $("#routeName").val(r.routeName);
    $("#type_id").val(r.id);
});
$("body").on('click','.editTag', function(){
    var r = $(this).data("data");
    $("#name").val(r.name);
    $("#tag_id").val(r.id);
});


/*Action : ajax
* used to: delete record
*/ 
$("body").on('click','.deleteRecord',function(){
    var checkstr =  confirm('Are you sure?');
    if(checkstr == true){
        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',    
            success:function(response){
                if(response.success){
                    toastr.success(response.message,'Success');
                    location.reload();
                }
            },
            error:function(status,error){
                var errors = JSON.parse(status.responseText);
                if(status.status == 401){
                    $(".ajax_loader").hide();
                    $.each(errors.error, function(i,v){
                        toastr.error( v[0],'Opps!');
                    });
                }else{
                    toastr.error(errors.message,'Opps!');
                }
            }
        });
        return false;
    }else{
        return false;
    }
});

$("body").on('click','.deleteMultipleRecord',function(){
    var type = $(this).data("type");
    var checkstr =  confirm('Are you sure?');
    if(checkstr == true){
        if(type=='delete_cities'){
            var count = $('input[name="city_id[]"]:checked').length;
            if(count > 0){
                $("#deleteAllCityForm").submit();  
            }else{
                toastr.error('Please first slected any city.','Opps!');
                return false;
            }
        }
        if(type=='delete_levels'){
            var count = $('input[name="level_id[]"]:checked').length;
            if(count > 0){
                $("#deleteAllLevelForm").submit();  
            }else{
                toastr.error('Please first slected any level.','Opps!');
                return false;
            }
        }
        if(type=='delete_status'){
            var count = $('input[name="status_id[]"]:checked').length;
            if(count > 0){
                $("#deleteAllStatusForm").submit();  
            }else{
                toastr.error('Please first slected any status.','Opps!');
                return false;
            }
        }
        if(type=='delete_agents'){
            var count = $('input[name="agent_id[]"]:checked').length;
            if(count > 0){
                $("#deleteAllAgentForm").submit();  
            }else{
                toastr.error('Please first slected any agent.','Opps!');
                return false;
            }
        }
        if(type=='delete_stocks'){
            var count = $('input[name="stockbroker_id[]"]:checked').length;
            if(count > 0){
                $("#deleteAllStockForm").submit();  
            }else{
                toastr.error('Please first slected any stock.','Opps!');
                return false;
            }
        }
        if(type=='delete_routes'){
            var count = $('input[name="routeknown_id[]"]:checked').length;
            if(count > 0){
                $("#deleteAllRouteknownsForm").submit();  
            }else{
                toastr.error('Please first slected any route.','Opps!');
                return false;
            }
        }
        if(type=='tags'){
            var count = $('input[name="tag_id[]"]:checked').length;
            if(count > 0){
                $("#deleteAllTagsForm").submit();  
            }else{
                toastr.error('Please first slected any tag.','Opps!');
                return false;
            }
        }
        if(type=='articles'){
            var count = $('input[name="article_id[]"]:checked').length;
            if(count > 0){
                $("#deleteAllArticlesForm").submit();  
            }else{
                toastr.error('Please first slected any article.','Opps!');
                return false;
            }
        }
    }else{
        return false
    }
});

$("body").on('click', '.note_tab', function(){
    $(".note_heading").show();
    $(".finance_heading").hide();
});
$("body").on('click', '.finance_tab', function(){
    $(".note_heading").hide();
    $(".finance_heading").show();
});

$('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
$('#datepicker1').datepicker({ 
    showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
});