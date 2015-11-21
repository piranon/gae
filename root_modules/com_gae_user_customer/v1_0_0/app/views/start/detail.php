<div ng-app="customer" ng-controller="DetailController">
    <div class="row top-navigation">
        <div class="col-md-4">
            <a class="btn-cancle" href="<?php echo $curModule->app_url; ?>start">Cancel</a>
        </div>
        <div class="col-md-4">
            <div class="topic-page">Customer Detail</div>
        </div>
    </div>
    <div class="main-container detail">
        <div class="row">
            <div class="col-sm-2">
                <div class="circle-size-100">
                    <img ng-show="customer.image_id" src="<?php echo root_url(), 'root_images/'; ?>{{customer.file_dir}}r100_{{customer.file_name}}">
                    <img ng-hide="customer.image_id">
                </div>
            </div>
            <div class="col-sm-5">
                <div class="detail-name">{{customer.first_name}} {{customer.last_name}}</div>
                <div class="detail-username">{{customer.user_name}}</div>
                <div class="detail-email">{{customer.email}}</div>
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