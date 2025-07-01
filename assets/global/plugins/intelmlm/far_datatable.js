(function( $ ) {
 
    $.fn.Far_datatable = function(options) {
        
        var settings = $.extend({
            url: "",
            pageLength: 10,
            order:  [
                [1, "asc"] // set first column as a default sort by asc
            ],
            lengthMenu: [
                [1, 2, 5, 100, 150, -1],
                [1, 2, 5, 100, 150, "All"] // change per page values here
            ],
            bStateSave: true,
            loadingMessage: 'Loading...'
        }, options );
        
        //datatable
        var grid = new Datatable();

        grid.init({
            src: $(this),
            onSuccess: function (grid) {
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            onDataLoad: function(grid) {
                // execute some code on ajax data load
            },
            loadingMessage: settings.loadingMessage,
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 

                "bStateSave": settings.bStateSave, // save datatable state(pagination, sort, etc) in cookie.

                "lengthMenu": settings.lengthMenu,
                "pageLength": settings.pageLength, // default record count per page
                "ajax": {
                    "url": settings.url, // ajax source
                    "data": settings.data
                },
                "order": settings.order
            }
        });

        
        
 
        return this;
 
    };
 
}( jQuery ));