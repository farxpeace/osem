/*
	Plugin Name: Name of the plugin.
	Description: Brief description about plugin.
*/
; (function ($, window, document, undefined) {
    "use strict";
    let plugin;
    const PLUGIN_NAME = 'score_report';
    function Plugin(element, options) {
        this._element    = element;
        this._pluginName = PLUGIN_NAME;
        this._defaults   = $.fn[PLUGIN_NAME].defaults;
        this._settings 	 = $.extend({}, this._defaults, options);
        this._init();
    }
    // Avoid Plugin.prototype conflicts
    $.extend(Plugin.prototype, {
        // Initialization logic
        _init: function () {
            plugin = this;
            this._build();
            this._bindEvents();
            this._initialize();
        },
        // Cache DOM nodes for performance
        _build: function () {
            this.$_element = $(this._element);
        },
        // Bind events that trigger methods
        _bindEvents: function () {
            plugin.$_element.on('click' + '.' + plugin._pluginName, function () {
                plugin._someOtherFunction.call(plugin);
            });
        },
        // Unbind events that trigger methods
        _unbindEvents: function () {
            this.$_element.off('.' + this._pluginName);
        },
        // Remove plugin instance completely
        _destroy: function () {
            this._unbindEvents();
            this.$_element.removeData();
        },
        _initialize: function(){

            $("body").append('<div id="score_report_temporary"></div>');
            //this._load_frame_score_report();
        },
        _load_frame_score_report: function(){
            var ajaxPostdata = {}
            ajaxPostdata.uacc_id = this._settings.uacc_id;
            $(this._element).load(this._settings.base_url+'score_report/load_frame_score_report', { postdata: ajaxPostdata }, function(){
                console.log('Score Report Frame loaded');
                //plugin._prepare_toolbar();
                //plugin.use_this_address(plugin._settings.user_address_id)
                //plugin._bind_btn_new_address();
                //plugin._bind_btn_choose_address();
            })
        },
        load_score_report: function(div_element_id, report_options){
            var ajaxPostdata = {}
            ajaxPostdata = report_options;
            blockUI_secondary();
            $(div_element_id).load(this._settings.base_url+'score_report/ajax_load_score_report', { postdata: ajaxPostdata }, function(){
                console.log(report_options.view)
                if(report_options.view == 'desktop'){
                    $(".main_frame_score_report").addClass("row")
                    $('.score_card').each(function(){
                        $(this).wrapAll('<div class="col-6 desktop_score_card"></div>');
                    })
                }
                unblockUI();
            })
        },
        modal_open_booking_slot: function(){
            var ajaxPostdata = {}
            ajaxPostdata = report_options;
            $("#score_report_temporary").load(this._settings.base_url+'score_report/modal_open_booking_slot', { postdata: ajaxPostdata }, function(){
                unblockUI();
            })
        },
        // Create custom methods
        _someOtherFunction: function () {
            console.log('Function is called.');
            this._callback();
        },
        // Callback methods
        _callback: function () {
            // Cache onComplete option
            let onComplete = this._settings.onComplete;
            if (typeof onComplete === "function") {
                onComplete(this._element);
            }
        }
    });
    //Plugin wrapper
    $.fn[PLUGIN_NAME] = function (options) {

        this.modal_open_booking_slot = function(){
            plugin.modal_open_booking_slot();
        }

        this.render_report = function(div_element_id, report_options){
            plugin.load_score_report(div_element_id,report_options);
        }
        this.each(function () {
            if (!$.data(this, "plugin_" + PLUGIN_NAME)) {
                $.data(this, "plugin_" + PLUGIN_NAME, new Plugin(this, options));
            }
        });
        return this;
    };
    $.fn[PLUGIN_NAME].defaults = {
        property  : 'value',
        onComplete: null
    };
})(jQuery, window, document);