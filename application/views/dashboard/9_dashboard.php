<?php $this->load->view('includes/dashlite_header'); ?>
<style>
    .nk-ecwg .amount {
        font-size: 2rem;
        font-weight: 500;
        color: #364a63;
    }
    .nk-top-products .item{
        display:flex;
        align-items:center;
        padding:.625rem 0;
        line-height:1.2
    }
    .nk-top-products .thumb{
        width:44px;
        margin-right:1rem
    }
    .nk-top-products .thumb img{
        border-radius:4px
    }
    .nk-top-products .total{
        margin-left:auto;
        text-align:right
    }
    .nk-top-products .amount,.nk-top-products .title{
        font-size:.9375rem;
        color:#364a63;
        margin-bottom:.25rem
    }
    .nk-top-products .count,.nk-top-products .price{
        font-size:.8125rem;
        color:#8094ae;
        margin-bottom:1px
    }
    .nk-store-statistics .item{
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:.5rem 0
    }
    .nk-store-statistics .title{
        font-size:.8125rem;
        color:#8094ae
    }
    .nk-store-statistics .count{
        font-size:1.25rem;
        color:#364a63;
        font-weight:700
    }
    .nk-store-statistics .icon{
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:1.5rem;
        height:44px;
        width:44px;
        border-radius:6px
    }
    .nk-download{
        display:flex;
        width:100%;
        flex-wrap:wrap;
        align-items:center;
        justify-content:space-between;
        padding:1.25rem;
        border-radius:4px;
        background:#fff
    }
    .nk-download .data{
        display:flex;
        flex-grow:1
    }
    .nk-download .info{
        margin-top:.35rem
    }
    .nk-download .title{
        font-size:1rem;
        line-height:1.2
    }
    .nk-download .thumb{
        flex-shrink:0;
        width:3rem;
        margin-right:1rem
    }
    .nk-download .meta .release,.nk-download .meta .version{
        display:block;
        line-height:1.2;
        padding:.25rem 0
    }
    .nk-download .title .badge{
        margin-left:1rem
    }
    @media (min-width:768px){
        .nk-download{
            padding:1.5rem
        }
        .nk-download .thumb{
            width:2.5rem;
            margin-right:1.5rem
        }
        .nk-download .data{
            align-items:center
        }
        .nk-download .meta .release,.nk-download .meta .version{
            display:inline-block;
            padding-right:1.5rem
        }
    }
    @media (max-width:575px){
        .nk-download .data{
            width:100%;
            padding-left:4rem
        }
        .nk-download .thumb{
            position:absolute;
            margin-left:-4rem
        }
        .nk-download .actions{
            margin:.75rem 0 0;
            padding-left:4rem
        }
    }
</style>
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-xxl-3 col-sm-6">
            <div class="card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Pending</h6>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount"><?php echo $this->far_dashboard->count_score_report_pending_fulfillment($logged_in['uacc_id']); ?></div>
                            </div>
                        </div>
                    </div><!-- .card-inner -->
                </div><!-- .nk-ecwg -->
            </div><!-- .card -->
        </div><!-- .col -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Submitted</h6>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount"><?php echo $this->far_dashboard->count_score_report_submitted_fulfillment($logged_in['uacc_id']); ?></div>
                            </div>
                        </div>
                    </div><!-- .card-inner -->
                </div><!-- .nk-ecwg -->
            </div><!-- .card -->
        </div><!-- .col -->


    </div><!-- .row -->
</div><!-- .nk-block -->
<?php $this->load->view('includes/dashlite_footer'); ?>


<style>
    .left_menu_counter {
        padding: 1px 6px 1px 4px;
        top: -2px;
    }
</style>
<script>
    $(function(){
        $(".nk-menu-text:contains('Score Report')").click();
    });

</script>
