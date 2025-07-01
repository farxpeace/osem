(function( $ ) {
    $.fn.FarModalListUser = function(options, callback) {
        
        var settings = $.extend({
            title: "Select User",
            url: "",
            data: {  },
            
            //modal popup select user
            closeAfterSelectUser: true,
            selectUserClassBtn: '.select_user_btn',
            afterSelectUserTextInputId: '#new_upline_text',
            afterSelectUserHiddenInputId: '#new_upline_uacc_id'
        }, options );

        var varHtml="";
        varHtml += "<div id='modal-modal_list_downline_and_upline' class='modal modal-scroll container fade' tabindex='-1' data-replace='true'>";
        varHtml += "    <div class='modal-header'>";
        varHtml += "        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'><\/button>";
        varHtml += "        <h4 class='modal-title'>Select User<\/h4>";
        varHtml += "    <\/div>";
        varHtml += "    <div class='modal-body' id='modal-body-modal_list_downline_and_upline'>";
        varHtml += "				";
        varHtml += "    <\/div>";
        varHtml += "    <div class='modal-footer'>";
        varHtml += "        <button type='button' data-dismiss='modal' class='btn btn-default'>Close<\/button>";
        varHtml += "    <\/div>";
        varHtml += "<\/div>";


        $(this).on('click', function(){
            var modal = $(varHtml);
            var modal_body = $(modal).children('#modal-body-modal_list_downline_and_upline');
            
            
            $(modal_body).load(settings.url, settings.data, function(){
                console.log("List User appended to modal");
                setTimeout(function () {
                    $(modal).modal('show');
                    $(settings.selectUserClassBtn).on('click', function(){
                        var data = $(this).data();
                        var fullname = data.uaccusername+" ( "+data.fullname+" )";
                        $(settings.afterSelectUserTextInputId).val(fullname);
                        $(settings.afterSelectUserHiddenInputId).val(data.uaccid);
                        $(modal).modal('hide');
                    });
                }, 100); //will call the function after 2 secs.
            });
        });

        return this;
 
    };
 
}( jQuery ));