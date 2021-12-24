$(function () {
    if ($('#status_span').length) {
        var status = $('#status_span').attr('data-status');
        if (status === '1') {
            toastr.success($('#status_span').attr('data-msg'));
        } else if (status === '0') {
            toastr.error($('#status_span').attr('data-msg'));
        }
    }

    //Toastr setting
    toastr.options.preventDuplicates = true;

    //Play notification sound on success, error and warning
    // toastr.options.onShown = function() {
    // 	if($(this).hasClass('toast-success')){
    // 		var audio = $("#success-audio")[0];
    // 		if(audio !== undefined){
    // 			audio.play();
    // 		}
    // 	} else if($(this).hasClass('toast-error')){
    // 		var audio = $("#error-audio")[0];
    // 		if(audio !== undefined){
    // 			audio.play();
    // 		}
    // 	} else if($(this).hasClass('toast-warning')){
    // 		var audio = $("#warning-audio")[0];
    // 		if(audio !== undefined){
    // 			audio.play();
    // 		}
    // 	}
    // }
});
