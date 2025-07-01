/*
	Plugin Name: Name of the plugin.
	Description: Brief description about plugin.
*/
; (function ($, window, document, undefined) {
	"use strict";
	let plugin;
	const PLUGIN_NAME = 'address_management';
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
		},
		initialize: function(){
			this.load_address_management_frame();
			if(this._settings.user_address_id){
				console.log('default')
			}
			$("body").append('<div id="address_management_temporary"></div>')
			console.log(this._settings)
		},
		// Cache DOM nodes for performance
		_build: function () {
			this.$_element = $(this._element);
			this.initialize();
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
		load_address_management_frame: function(){
			var ajaxPostdata = {}
			if(this._settings.user_address_id){
				ajaxPostdata.user_address_id = this._settings.user_address_id;
			}
			$(this._element).load(this._settings.base_url+'address_management/load_address_management_frame', { postdata: ajaxPostdata }, function(){
				console.log('asdasd')
				plugin.use_this_address(plugin._settings.user_address_id)
				plugin._bind_btn_new_address();
				plugin._bind_btn_choose_address();
			})
		},
		_bind_btn_new_address: function(){
			if($(this._settings.btn_add_new_address).length > 0){
				$(this._settings.btn_add_new_address).on("click", function(){
					plugin.load_create_new_address_modal();
				})
			}

		},
		_bind_btn_choose_address: function(){
			if($(this._settings.btn_choose_address).length > 0){
				$(this._settings.btn_choose_address).on("click", function(){
					plugin.load_user_address_list();
				})
			}
		},
		load_user_address_list: function(){
			blockUI_secondary();
			$('#modal_address_management_body').load(this._settings.base_url+'address_management/load_modal_user_address_list', {
				postdata: {
					uacc_id: plugin._settings.uacc_id
				}
			}, function(){
				$("#modal_address_management").modal("show");

				//bind delete address
				$("#user_address_list .btn_delete_this_address").each(function(i, j){
					var btn_element = this;
					$(this).on("click", function(){
						var user_address_id = $(this).data('user_address_id');
						blockUI_secondary();
						plugin.delete_this_address(user_address_id, function(){
							$(btn_element).closest('.address_frame').slideUp("slow").remove();

							//check if zero
							if($('#modal_address_management .address_frame').length == 0){
								plugin.load_user_address_list();
							}

							unblockUI();
						});
					})
				})

				$("#user_address_list .use_this_address").each(function(i, j){
					$(this).on("click", function(){
						var user_address_id = $(this).data('user_address_id');
						plugin.use_this_address(user_address_id, function(){
							$("#modal_address_management").modal("hide")
						});
					})
				})

				unblockUI();
			})
		},
		load_create_new_address_modal: function(){
			blockUI_secondary();
			$('#modal_address_management_body').load(this._settings.base_url+'address_management/load_create_new_address_modal', { }, function(){
				$("#modal_address_management").modal("show");
				$("#frame_modal_create_new_address .state_code").on("change", function(){
					plugin._onchange_state_code();
				});
				$("#frame_modal_create_new_address .post_office").on("change", function(){
					plugin._onchange_post_office();
				});
				$("#frame_modal_create_new_address .area_name").on("change", function(){
					plugin._onchange_area_name();
				});
				$("#frame_modal_create_new_address .btn_submit_new_address").on("click", function(){
					plugin._submit_new_address();
				});
				unblockUI();
			})
		},
		load_user_address_by_user_address_id: function(user_address_id){
			$.ajax({
				url: this._settings.base_url+'address_management/load_user_address_by_user_address_id',
				type: "POST",
				dataType: "JSON",
				data: {
					postdata: {
						user_address_id: user_address_id
					}
				},
				success: function(data){

				}
			})
		},
		delete_this_address: function(user_address_id, callback){
			$.ajax({
				url: this._settings.base_url+'address_management/ajax_delete_address',
				type: "POST",
				dataType: "JSON",
				data: {
					postdata: {
						user_address_id: user_address_id
					}
				},
				success: function(data){
					unblockUI();
					if(data.status == "success"){

						if($(plugin._element).find('.address_management_frame #user_address_id').val() == user_address_id){
							plugin.use_this_address('');
						}

						if (typeof callback === "function") {
							callback(data);
						}

					}else{

						var eell = data.errors;
						$.each(eell, function(i,j){
							var el_on_page = $("#"+i).length;
							if (el_on_page){
								$("#"+i).closest('.form-group').addClass('has-error');
								$("#"+i).closest('.form-group').find('.error_message').text(j).show();
							} else {

							}
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: j,
							})

						})
					}
				}
			})

		},
		use_this_address: function(user_address_id, callback){
			blockUI_secondary();
			plugin._ajax_get_address_detail(user_address_id, function(data){
				if(data.address_line_1){
					$(plugin._element).find('.address_management_frame .address_line_1').text(data.address_line_1)
					$(plugin._element).find('.address_management_frame .address_line_2').text(data.address_line_2)
					$(plugin._element).find('.address_management_frame .postcode_area_location').text(data.area_name+", "+data.post_office)
					$(plugin._element).find('.address_management_frame .postcode').text(data.postcode)
					$(plugin._element).find('.address_management_frame .state_code').text(data.state_code);
					$(plugin._element).find('.address_management_frame input#user_address_id').val(data.user_address_id);
					$(".btn_add_new_address_middle").hide();
					$(".preview_address_frame").show()
				}else{
					$(".btn_add_new_address_middle").show();
					$(".preview_address_frame").hide();
					$(plugin._element).find('.address_management_frame input#user_address_id').val('');
				}

				if (typeof callback === "function") {
					callback(data);
				}

				unblockUI();
			})
		},
		_ajax_get_address_detail: function(user_address_id, callback){
			$.ajax({
				url: this._settings.base_url+'address_management/ajax_get_address_detail',
				type: "POST",
				dataType: "JSON",
				data: {
					postdata: {
						user_address_id: user_address_id
					}
				},
				success: function(dataReturn){
					callback(dataReturn)
				}
			});
			this._callback();
		},
		_submit_new_address: function(){
			var address_line_1 = $("#frame_modal_create_new_address .address_line_1").val();
			var address_line_2 = $("#frame_modal_create_new_address .address_line_2").val();
			var postcode_id = $("#frame_modal_create_new_address .postcode").val();
			blockUI_secondary();
			$.ajax({
				url: this._settings.base_url+'address_management/ajax_add_new_address',
				type: "POST",
				dataType: "JSON",
				data: {
					postdata: {
						address_line_1: address_line_1,
						address_line_2: address_line_2,
						postcode_id: postcode_id
					}
				},
				success: function(data){
					unblockUI();
					if(data.status == "success"){

						plugin.use_this_address(data.user_address_id, function(){

							$("#modal_address_management").modal("hide");
						});


					}else{

						var eell = data.errors;
						$.each(eell, function(i,j){
							var el_on_page = $("#"+i).length;
							if (el_on_page){
								$("#"+i).closest('.form-group').addClass('has-error');
								$("#"+i).closest('.form-group').find('.error_message').text(j).show();
							} else {

							}
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: j,
							})

						})
					}
				}
			})
		},
		_onchange_area_name: function(){
			var selected_area_name = $("#frame_modal_create_new_address .area_name").val();
			var selected_state_code = $("#frame_modal_create_new_address .state_code").val();
			var selected_post_office = $("#frame_modal_create_new_address .post_office").val();
			$.ajax({
				url: this._settings.base_url+'address_management/list_postcode_by_post_office_state_and_area',
				type: "POST",
				dataType: "JSON",
				data: {
					postdata: {
						state_code: selected_state_code,
						post_office: selected_post_office,
						area_name: selected_area_name
					}
				},
				success: function(data){
					var htmloption = '<option value="0">Select postcode</option>';
					$(data).each(function(i, j){
						if(data.length == 1){
							htmloption += '<option value="'+j.postcode_id+'" selected="">'+j.postcode+'</option>';
						} else {
							htmloption += '<option value="'+j.postcode_id+'">'+j.postcode+'</option>';
						}

					});
					$("#frame_modal_create_new_address .postcode").html(htmloption);
					$(".postcode").select2({
						placeholder: "Select postcode",
						dropdownParent: $("#modal_address_management_body")
					});
				}
			})
		},
		_onchange_post_office: function(){
			var selected_state_code = $("#frame_modal_create_new_address .state_code").val();
			var selected_post_office = $("#frame_modal_create_new_address .post_office").val();
			$.ajax({
				url: this._settings.base_url+'address_management/list_area_name_by_post_office',
				type: "POST",
				dataType: "JSON",
				data: {
					postdata: {
						state_code: selected_state_code,
						post_office: selected_post_office
					}
				},
				success: function(data){
					var htmloption = '<option value="0">Select city</option>';
					$(data).each(function(i, j){
						htmloption += '<option value="'+j.area_name+'">'+j.area_name+'</option>';
					});
					$("#frame_modal_create_new_address .area_name").html(htmloption);
					$(".area_name").select2({
						placeholder: "Select City",
						dropdownParent: $("#modal_address_management_body")
					});
				}
			})
		},
		_onchange_state_code: function(){
			var selected_state_code = $("#frame_modal_create_new_address .state_code").val();
			$.ajax({
				url: this._settings.base_url+'address_management/list_area_by_state_code',
				type: "POST",
				dataType: "JSON",
				data: {
					postdata: {
						state_code: selected_state_code
					}
				},
				success: function(data){
					var htmloption = '<option value="0">Select area</option>';
					$(data).each(function(i, j){
						htmloption += '<option value="'+j.post_office+'">'+j.post_office+'</option>';
					});
					$("#frame_modal_create_new_address .post_office").html(htmloption)
					$(".post_office").select2({
						placeholder: "Select an Area",
						dropdownParent: $("#modal_address_management_body")
					});
				}
			})
		}
	});
	//Plugin wrapper
	/*
	$.fn[PLUGIN_NAME] = function (options) {
		this.each(function () {
			if (!$.data(this, "plugin_" + PLUGIN_NAME)) {
				$.data(this, "plugin_" + PLUGIN_NAME, new Plugin(this, options));
			}
		});
		return this;
	};
	 */
	$.fn[PLUGIN_NAME] = function (options) {

		this.get_user_address_id = function() {
			var current_user_address_id = $(".address_management_frame input#user_address_id").val();
			return current_user_address_id;
		}
		this.open_modal_create_new_address = function(){
			plugin.load_create_new_address_modal();
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
