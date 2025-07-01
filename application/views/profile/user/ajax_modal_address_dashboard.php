<style>
    .address_frame {
        margin-top: 10px;
    }
    #modal_address_dashboard_body {
        margin-bottom: 50px;
    }
    .address_add_new.swiper-slide-active {
        height: 80vh !important;
    }
</style>
<?php if(count($logged_in['user_address']) > 0){ ?>
    <style>
        #modal_address_dashboard_body {
            height: 60vh !important;
        }
    </style>
<?php }else{ ?>
    <style>
        #modal_address_dashboard_body {
            height: 90vh !important;
        }
    </style>

<?php } ?>


<div class="swiper swiper_address">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        <div class="swiper-slide address_add_new">

        </div>
        <div class="swiper-slide address_list">

        </div>
        <div class="swiper-slide">Slide 3</div>
        ...
    </div>
</div>
<div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto; margin-left: -15px;">
    <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
        <a href="javascript: void(0);" data-bs-dismiss="modal" class="tf-btn accent large" style="width: 70px; padding: 5px;background-color: #a10000; color: #FFFFFF;"><i class="fa-solid fa-circle-xmark"></i></a>
        <a href="javascript: void(0);" onclick="javascript: btn_submit_add_new_address();" class="tf-btn accent large btn_submit_new_address">Submit Address</a>
        <a href="javascript: void(0);" onclick="javascript: swiperAddress.slideTo(0);" class="tf-btn accent large btn_list_all_address">New Address</a>
    </div>
</div>


<script>
    var swiperAddress;
    var swiperAddressOptions = {
        // Optional parameters
        direction: 'horizontal',
        loop: false,
        allowTouchMove: false,
        autoHeight: true,
        on: {
            afterInit: function(swiperAddress) {
                process_address_bottom_button(swiperAddress)
            }
        }
    }
    <?php if(count($logged_in['user_address']) > 0){ ?>
    swiperAddressOptions.initialSlide = 1;
    <?php }else{ ?>
    swiperAddressOptions.initialSlide = 0;
    <?php } ?>



    $(function(){

        swiperAddress = new Swiper('.swiper_address', swiperAddressOptions);

        swiperAddress.on('slideChange', function () {
            process_address_bottom_button(swiperAddress);
        });
    });
    function process_address_bottom_button(swiperAddress){
        if(swiperAddress.activeIndex == 0){
            //New address
            $('.btn_list_all_address').hide();
            $('.btn_submit_new_address').show();
        }else if(swiperAddress.activeIndex == 1){
            $('.btn_list_all_address').show();
            $('.btn_submit_new_address').hide();
        }
    }


</script>
