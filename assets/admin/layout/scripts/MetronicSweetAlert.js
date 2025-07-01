/**
MetronicSweetAlert script to handle the theme SweetAlert
**/
var MetronicSweetAlert = function() {

    // Handle Theme Settings
    var handleLogout = function() {
        var button = $("a[data-logout=yes]");
        var logoutUrl = $(button).attr('href');
        $(button).on('click', function(e){
            e.preventDefault();
            
            swal({
            	title: "Are you sure ?",
            	text: "Logout from the system securely",
            	type: "warning",
            	showCancelButton: true,
            	confirmButtonColor: "#DD6B55",
            	confirmButtonText: "Yes, let me out securely!",
            	cancelButtonText: "No!",
            	closeOnConfirm: false,
            	closeOnCancel: false
            },
            function(isConfirm){
            	if (isConfirm) {
            		swal("Success!",
            		"You will be logout in 2 seconds.",
            		"success");
                    setTimeout(function () {
                       window.location.href = logoutUrl; //will redirect to your blog page (an ex: blog.html)
                    }, 2000); //will call the function after 2 secs.
            	}else {
            		swal("Cancelled",
            		"You canceled to logout from the system",
            		"error");
            	}
            });
        })
    };


    return {

        //main function to initiate the theme
        init: function() {
             handleLogout();
        }
    };

}();