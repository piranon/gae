<div ng-app="staffGroup" ng-controller="AddController as add">
    <div class="top-navigation">
        <div class="row module-container">
            <div class="col-md-4">
                <a class="btn-cancle" href="<?php echo $curModule->app_url; ?>start">Cancel</a>
            </div>
            <div class="col-md-4 topic-page">Create User Role</div>
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
                    <div class="text-right require-field">User Role Name</div>
                    <div class="text-right desc-field">ชื่อตำแหน่งเจ้าหน้าที่ หรือชื่อแผนก</div>
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
                    <textarea class="form-control" rows="8" ng-model="add.description"></textarea>
                </div>
            </div>
            <br>
        </form>
    </div>
</div>
