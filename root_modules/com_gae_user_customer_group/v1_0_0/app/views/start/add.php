<div ng-app="customerGroup" ng-controller="AddController">
    <div class="row top-navigation">
        <div class="col-md-4">
            <a class="btn-cancle" href="<?php echo $curModule->app_url; ?>start">Cancel</a>
        </div>
        <div class="col-md-4">
            <div class="topic-page">Create Customer Group</div>
        </div>
        <div class="col-md-4">
            <button ng-click="clickOnSubmit(); $event.stopPropagation();" type="button" class="btn-add">
                Save
            </button>
        </div>
    </div>
    <div class="main-container add">
        <form>
            <div class="row">
                <div class="col-md-3">
                    <div class="text-right require-field">Customer Group Name</div>
                    <div class="text-right desc-field">ชื่อกลุ่มลูกค้า</div>
                </div>
                <div class="col-md-8">
                    <input type="text" ng-model="name" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="text-right non-require-field">Description</div>
                    <div class="text-right desc-field">คำอธิบายหรือรายละเอียด</div>
                </div>
                <div class="col-md-8">
                    <textarea class="form-control" rows="20" ng-model="description"></textarea>
                </div>
            </div>
            <br>
        </form>
        <form ng-submit="submitCustomerInGroup()">
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-8">
                    <div class="text-left require-field">Add Customers into the Group</div>
                    <div class="text-left desc-field">เลือกลูกค้าที่ต้องการจัดเข้ากลุ่ม</div>
                    <autocomplete ng-model="inputCustomer" data="customers" on-select="selectedCustomer"
                                  attr-input-class="form-control"
                                  attr-placeholder="พิมพ์ชื่อลูกค้า แล้วกด Enter"></autocomplete>
                </div>
            </div>
        </form>
        <div id="customer-selected-list" ng-repeat="customerSelected in customersSelected"
             add-customer="customerSelected">
        </div>
    </div>
</div>
