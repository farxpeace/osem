/*
	Plugin Name: Name of the plugin.
	Description: Brief description about plugin.
*/
; (function ($, window, document, undefined) {
    "use strict";
    let plugin;
    const PLUGIN_NAME = 'income_management';
    function Plugin(element, options) {
        this._element    = element;
        this._pluginName = PLUGIN_NAME;
        this._defaults   = $.fn[PLUGIN_NAME].defaults;
        this._settings 	 = $.extend({}, this._defaults, options);
        this._swiper = '';
        this.swiperData = {
            currentSlideIndex: ''
        }
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
        _initialize: function(){

            this._load_frame_income_management();

            if(this._settings.user_address_id){
                console.log('default')
            }
            $("body").append('<div id="income_management_temporary"></div>')
            console.log(this._settings)
        },
        _load_frame_income_management: function(){
            var ajaxPostdata = {}
            ajaxPostdata.uacc_id = this._settings.uacc_id;
            $(this._element).load(this._settings.base_url+'income_management/load_income_management_frame', { postdata: ajaxPostdata }, function(){
                console.log('Income Management Frame loaded');
                plugin._prepare_toolbar();
                //plugin.use_this_address(plugin._settings.user_address_id)
                //plugin._bind_btn_new_address();
                //plugin._bind_btn_choose_address();
            })
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
        },
        _initialize_preData: function(){
            var incomeData = this._settings.incomeData;
            console.log(incomeData)
            if(incomeData){
                $.each(incomeData, function(i, j){
                    if($("#modal_income_management_body").find("#"+i)){
                        $("#modal_income_management_body").find("#"+i).val(j);
                        formatCurrency($("#modal_income_management_body #"+i), "blur")
                    }
                    console.log(j)
                })
            }
        },
        _prepare_toolbar: function(){
            //add income
            $(this._element).find('.btn_add_income').on("click", function(){
                plugin._load_modal_add_edit_income(function(data){
                    $("#modal_income_management").modal("show");
                    plugin._swiper = new Swiper("#modal_income_management_body .income_management_swiper", {
                        on: {
                            slideChange: function () {
                                plugin._swiperOnchangeSlide();
                            },
                        }
                    });
                    plugin._swiperOnchangeSlide();

                    //plugin._initialize_preData();
                });
                /*
                if($("#modal_income_management_body .income_management_swiper").length == 0){
                    plugin._load_modal_add_edit_income(function(data){
                        plugin._swiper = new Swiper("#modal_income_management_body .income_management_swiper", {
                            on: {
                                slideChange: function () {
                                    plugin._swiperOnchangeSlide();
                                },
                            }
                        });
                        $("#modal_income_management").modal("show");
                        plugin._swiperOnchangeSlide();
                    });
                } else {
                    $("#modal_income_management").modal("show");
                }
                 */


            })
        },
        _swiperOnchangeSlide: function(){
            var slideIndex = plugin._swiper.activeIndex;
            var totalSlide = $("#modal_income_management .swiper-slide").length;
            var lastSlideIndex = totalSlide-1;
            plugin.swiperData.currentSlideIndex = slideIndex;
            console.log("current slide index : "+slideIndex);

            if(slideIndex == 0){
                $("#modal_income_management_body .bottom_pagination_start").removeClass('d-none');
                $("#modal_income_management_body .bottom_pagination_middle").addClass('d-none');
                $("#modal_income_management_body .bottom_pagination_end").addClass('d-none');
                $("#modal_income_management_body").height('400px');
                $(".card_preview").addClass('d-none');
            }else if(slideIndex > 0 && slideIndex < lastSlideIndex){
                $("#modal_income_management_body .bottom_pagination_start").addClass('d-none');
                $("#modal_income_management_body .bottom_pagination_middle").removeClass('d-none');
                $("#modal_income_management_body .bottom_pagination_end").addClass('d-none');
                $("#modal_income_management_body").height('400px');
                $(".card_preview").addClass('d-none');
            }else if(slideIndex == lastSlideIndex){
                this._process_preview();
                $("#modal_income_management_body .bottom_pagination_start").addClass('d-none');
                $("#modal_income_management_body .bottom_pagination_middle").addClass('d-none');
                $("#modal_income_management_body .bottom_pagination_end").removeClass('d-none');
                $("#modal_income_management_body").height('80vh');
                $("#modal_income_management_body .card_preview").removeClass('d-none');
                //plugin._onPreviewScrollToEnd();
            }
        },
        _onPreviewScrollToEnd: function(){
            $(".btn_submit_income_detail").addClass("btn_disabled");
            $(".btn_submit_income_detail").attr("disabled", "disabled");
            $('.modal-content').scroll(function() {
                if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                    $(".btn_submit_income_detail").removeClass("btn_disabled");
                    $(".btn_submit_income_detail").removeAttr("disabled");
                    console.log('Bottom reached!');
                }else{
                    $(".btn_submit_income_detail").addClass("btn_disabled");
                    $(".btn_submit_income_detail").attr("disabled", "disabled");
                }
            });
        },
        _process_preview: function(operation){
            var previewData = [];
            $("#modal_income_management_body input, #modal_income_management_body select").each(function(i, j){

                var swiperAreaLabel = $(j).closest('.swiper-slide').attr("aria-label");
                var ss = swiperAreaLabel.split(" / ");
                var swiperIndex = parseInt(swiperAreaLabel[0])-1;

                var attrData = {};
                if($(j).is('input')){
                    var element_id = $(j).attr("id");
                    var element_value = $(j).val();
                    attrData.element_id = element_id;
                    attrData.element_value = element_value;
                }
                if($(j).is('select')){
                    var element_id = $(j).attr("id");
                    var element_value = $(j).val();
                    attrData.element_id = element_id;
                    attrData.element_value = element_value;
                    attrData.element_text = $(j).find("option:selected").text();
                }
                attrData.swiperIndex = swiperIndex;
                previewData.push(attrData)
            });
            if(!operation){
                operation = 'validate_only';
            }else{
                operation = 'submit';
            }
            blockUI_secondary();
            $(".card_preview").load(plugin._settings.base_url+'income_management/validate_submit', {
                postdata: {
                    uacc_id: plugin._settings.uacc_id,
                    operation: operation,
                    previewData: previewData
                }
            }, function(){
                unblockUI();
            })
        },
        _process_preview_old: function(){
            var previewData = {}
            previewData.employment_type_value = $("#modal_income_management_body #employment_type").val();
            previewData.employment_type_text = $("#modal_income_management_body #employment_type option:selected").text();
            previewData.monthly_gross_income = $("#modal_income_management_body #monthly_gross_income").val();
            previewData.monthly_net_income = $("#modal_income_management_body #monthly_net_income").val();
            previewData.monthly_allowance = $("#modal_income_management_body #monthly_allowance").val();
            previewData.monthly_hire_purchase = $("#modal_income_management_body #monthly_hire_purchase").val();
            previewData.monthly_mortgage = $("#modal_income_management_body #monthly_mortgage").val();
            previewData.monthly_personal_loan = $("#modal_income_management_body #monthly_personal_loan").val();
            previewData.monthly_credit_card = $("#modal_income_management_body #monthly_credit_card").val();
            previewData.monthly_others_outgoing = $("#modal_income_management_body #monthly_others_outgoing").val();

            console.log(previewData);

            if(previewData.employment_type_value) {
                if(previewData.employment_type_value == "0"){
                    plugin._card_preview_item_status('error','employement_type', 'Please select Employement');
                }else{
                    plugin._card_preview_item_status('success','employement_type', previewData.employment_type_text);
                }
            }
            if(previewData.monthly_gross_income) {
                if(plugin.convertToFloat(previewData.monthly_gross_income) < 100){
                    plugin._card_preview_item_status('error','monthly_gross_income', "Compulsory to fill-in");
                }else{
                    plugin._card_preview_item_status('success','monthly_gross_income', "RM " + previewData.monthly_gross_income);
                }
            }else{
                plugin._card_preview_item_status('error','monthly_gross_income', "Compulsory to fill-in");
            }

            if(previewData.monthly_net_income) {
                if(plugin.convertToFloat(previewData.monthly_net_income) < 100){
                    plugin._card_preview_item_status('error','monthly_net_income', "Compulsory to fill-in");
                }else{
                    plugin._card_preview_item_status('success','monthly_net_income', "RM " + previewData.monthly_net_income);
                }
            }else{
                plugin._card_preview_item_status('error','monthly_net_income', "Compulsory to fill-in");
            }

            plugin._card_preview_item_status('optional','monthly_allowance', "Not available");
            if(previewData.monthly_allowance) {
                plugin._card_preview_item_status('success','monthly_allowance', "RM " + previewData.monthly_allowance);
            }

            plugin._card_preview_item_status('optional','monthly_hire_purchase', "Not available");
            if(previewData.monthly_hire_purchase) {
                plugin._card_preview_item_status('success','monthly_hire_purchase', "RM " + previewData.monthly_hire_purchase);
            }
            if(previewData.monthly_mortgage) {
                $(".text_monthly_mortgage").text("RM "+previewData.monthly_mortgage)
            }
            if(previewData.monthly_personal_loan) {
                $(".text_monthly_personal_loan").text("RM "+previewData.monthly_personal_loan)
            }
            if(previewData.monthly_credit_card) {
                $(".text_monthly_credit_card").text("RM "+previewData.monthly_credit_card)
            }
            if(previewData.monthly_others_outgoing){
                $(".text_monthly_others_outgoing").text("RM "+previewData.monthly_others_outgoing)

            }





        },
        _card_preview_item_status: function(status,item_name, message){
            if(status == 'success'){
                $(".text_"+item_name).closest(".user-card").children('.user-avatar').html('<i class="fa-solid fa-circle-check icon_success"></i>');
            }else if(status == 'error'){
                $(".text_"+item_name).closest(".user-card").children('.user-avatar').html('<i class="fa-solid fa-circle-exclamation icon_exclamation"></i>');
            }else if(status == 'optional'){
                $(".text_"+item_name).closest(".user-card").children('.user-avatar').html('<i class="fa-solid fa-thumbs-up icon_thumbs_up"></i>');
            }

            if(message){
                $(".text_"+item_name).text(message)
            }else{
                $(".text_"+item_name).text("")
            }



        },
        _load_modal_add_edit_income: function(callback){
            var ajaxPostdata = {}
            ajaxPostdata.uacc_id = this._settings.uacc_id;
            $("#modal_income_management_body").load(this._settings.base_url+'income_management/load_modal_add_edit_income', { postdata: ajaxPostdata }, function(){
                console.log('Modal Add/Edit Income loaded');
                $("#modal_income_management_body .btn_swiper_next_slide").on("click", function(){
                    plugin._swiper.slideNext();
                });
                $("#modal_income_management_body .btn_swiper_prev_slide").on("click", function(){
                    plugin._swiper.slidePrev();
                });
                $("#modal_income_management_body .btn_swiper_preview").on("click", function(){
                    var slideIndex = plugin._swiper.activeIndex;
                    var totalSlide = $("#modal_income_management .swiper-slide").length;
                    var lastSlideIndex = totalSlide-1;
                    plugin._swiper.slideTo(lastSlideIndex);
                });
                $("#modal_income_management_body .btn_submit_income_detail").on("click", function(){
                    if($('.btn_submit_income_detail').hasClass("btn_disabled")){

                    }else{
                        plugin._process_preview('submit');
                    }

                });


                if (typeof callback === "function") {
                    callback();
                }
                //plugin.use_this_address(plugin._settings.user_address_id)
                //plugin._bind_btn_new_address();
                //plugin._bind_btn_choose_address();
            })
        },
        convertToFloat: function(stringNumber){
            stringNumber = stringNumber.replace(/\,/g,''); // 1125, but a string, so convert it to number
            stringNumber = parseFloat(stringNumber);
            return stringNumber;
        }
    });
    //Plugin wrapper
    $.fn[PLUGIN_NAME] = function (options) {
        this.slideTo = function(slideIndexNumber){
            plugin._swiper.slideTo(slideIndexNumber, 100)
        }
        this.swiperSlideNext = function(){
            plugin._swiper.slideNext();
        }
        this.swiperSlidePrev = function(){
            plugin._swiper.slidePrev();
        }
        this.get_user_address_id = function() {
            var current_user_address_id = $(".address_management_frame input#user_address_id").val();
            return current_user_address_id;
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


