<link rel="stylesheet" href="https://getappeasy.com/storemanager/assets/css/admin2/style.css">
<div ng-app="customer" ng-controller="DetailController">
    <div class="row top-navigation">
        <div class="col-md-4">
            <a class="btn-cancle" href="<?php echo $curModule->app_url; ?>start">Cancel</a>
        </div>
        <div class="col-md-4">
            <div class="topic-page">Customer Detail</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" id="motherBoard">
            <div class="col-sm-12">
                <div class="itemBlockTopContent">
                    <div class="customer-detail-container">
                        <div class="top-block">
                            <div class="image-container">
                                <div class="cover-container">
                                    <img ng-show="customer.image_id" src="<?php echo root_url(), 'root_images/'; ?>{{customer.file_dir}}r100_{{customer.file_name}}">
                                    <img ng-hide="customer.image_id">
                                </div>
                            </div>
                            <div class="info-container">
                                <div class="name"></div>
                                <div class="user-email">
                                    {{customer.user_name}} /
                                    <span class="emai" ng-model="customer">{{customer.email}}</span>
                                </div>
                                <div class="tag-group-name">
                                    No Group
                                </div>
                                <div class="tag-customer">
                                    Tag:
                                    <div class="list">{{customer.tag}}</div>
                                </div>
                            </div>
                            <div class="info-complete-order">
                                <div class="desc">Completed Order</div>
                                <div class="info">0.00</div>
                                <div class="desc2">From Total 0.00 THB</div>
                            </div>
                            <div class="info-point">
                                <div class="desc">Total</div>
                                <div class="info">0</div>
                                <div class="desc2">Points</div>
                            </div>
                        </div>
                        <div class="tbl-order-list">
                        </div>
                        <div class="address-container">
                            <div class="address-info">
                                <div class="icon">&nbsp;</div>
                                <div class="name">Shipping Address</div>
                            </div>
                            <div class="address-item">
                            </div>
                            <div class="address-detail">
                            </div>
                        </div>
                        <div class="address-container-2">
                            <div class="address-info">
                                <div class="icon">&nbsp;</div>
                                <div class="name">Billing Address</div>
                            </div>
                            <div class="address-item-2">
                            </div>
                            <div class="address-detail-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>