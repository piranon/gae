<div ng-app="customerGroup" ng-controller="AddController as add">
    <div class="top-navigation">
        <div class="row module-container">
            <div class="col-md-4">
                <a class="btn-cancle" href="<?php echo $curModule->app_url; ?>start">Cancel</a>
            </div>
            <div class="col-md-4 topic-page">Create Customer Group</div>
            <div class="col-md-4">
                <a ng-click="add.clickOnSubmit(); $event.stopPropagation();" class="btn-save">
                    Save
                </a>
            </div>
        </div>
    </div>
    <div class="add-page">
        <form class="module-container">
            <div class="row">
                <div class="col-md-3">
                    <div class="text-right require-field">Customer Group Name</div>
                    <div class="text-right desc-field">ชื่อกลุ่มลูกค้า</div>
                </div>
                <div class="col-md-8">
                    <input type="text" ng-model="add.name" id="name" class="form-control"
                           ng-keydown="add.keyDownRequired($event)">

                    <div class="add-warning hide" ng-hide='add.name'></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="text-right non-require-field">Description</div>
                    <div class="text-right desc-field">คำอธิบายหรือรายละเอียด</div>
                </div>
                <div class="col-md-8">
                    <textarea class="form-control" rows="20" ng-model="add.description"></textarea>
                </div>
            </div>
            <br>
        </form>
        <form ng-submit="add.submitCustomerInGroup()" class="module-container">
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-8">
                    <div class="text-left require-field">Add Customers into the Group</div>
                    <div class="text-left desc-field">เลือกลูกค้าที่ต้องการจัดเข้ากลุ่ม</div>
                    <autocomplete ng-model="add.inputCustomer" id="customer_ids" data="add.customers"
                                  on-select="add.selectedCustomer"
                                  attr-input-class="form-control"
                                  attr-placeholder="พิมพ์ชื่อลูกค้า แล้วกด Enter"
                                  ng-keydown="add.keyDownRequired($event)"></autocomplete>
                </div>
            </div>
        </form>
        <div id="customer-selected-list" class="module-container" ng-repeat="customerSelected in add.customersSelected"
             add-customer="add.customerSelected">
        </div>
    </div>
</div>
