<div class="gae_manager_view-footer"></div><!--gae_manager_view-header-->

<div ng-app="customer" ng-controller="DetailController as detail">

    <!-- ADD MODULE HTML BY AUTO LAYOUT -->
    <div class="gae_manager_view-module_bar-left">
        <div id="gae_module_bar_btn__1">
            <a class="btn-cancle" href="<?php echo $curModule->app_url; ?>start">Back</a>
        </div>
    </div>

    <div class="gae_manager_view-module_bar-right">
        <div id="gae_module_bar_btn__1"></div>
    </div>

    <div class="gae_manager_view-header"></div><!--gae_manager_view-header-->

    <div class="detail module-container">
        <div class="row">
            <div class="col-sm-2">
                <div class="circle-size-100">
                    <img ng-show="detail.customer.image_id"
                         ng-src="<?php echo root_url(), 'root_images/'; ?>{{detail.customer.file_dir}}r100_{{detail.customer.file_name}}">
                    <img ng-hide="detail.customer.image_id">
                </div>
            </div>
            <div class="col-sm-5">
                <div class="detail-name">{{detail.customer.first_name}} {{detail.customer.last_name}}</div>
                <div class="detail-username">{{detail.customer.user_name}}</div>
                <div class="detail-email">{{detail.customer.email}}</div>
            </div>
            <div class="col-sm-2">
                <div class="detail-point">
                    <div>Total</div>
                    <div>0</div>
                    <div>Points</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="detail-complete-order">
                    <div class="desc">Completed Order</div>
                    <div class="info">0.00</div>
                    <div class="desc2">From Total 0.00 THB</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="detail-icon">&nbsp;</div>
                <span class="detail-label">Default Shipping Address</span>
                <span class="detail-address-desc"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="detail-icon">&nbsp;</div>
                <span class="detail-label">Default Billing Address</span>
                <span class="detail-address-desc"></span>
            </div>
        </div>
    </div>
</div>