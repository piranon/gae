<div ng-app="customer" ng-controller="CustomerAddCtrl">
    <div class="row top-navigation">
        <div class="col-md-4">
            <a class="btn-cancle" href="<?php echo $curModule->app_url; ?>start">Cancel</a>
        </div>
        <div class="col-md-4">
            <div class="topic-page">Add Customer</div>
        </div>
        <div class="col-md-4">
            <button ng-click="clickOnSubmit(); $event.stopPropagation();" type="button" class="btn-add">
                Save
            </button>
        </div>
    </div>
    <div class="main-container">
        <form ng-submit="submit()">
            <div class="cover-container">
                <div ng-click="clickOnUpload(); $event.stopPropagation();">
                    <div class="area-inner-container">
                        <img id="area-inner-image">
                    </div>
                    <span class="glyphicon glyphicon-picture" id="pic-icon"></span>
                </div>
                <div class="hide">
                    <input type="file" file-model='fileModel' id="imageCategory" onchange="PreviewImage();">
                </div>
            </div>
            <div class="text-center">Profile Pic</div>
            <div class="form-group">
                <div class="text-left">Username</div>
                <input type="text" ng-model="username" class="form-control" placeholder="ชื่อผู้ใช้">
            </div>

            <div class="form-group">
                <div class="text-left">Firstname</div>
                <input type="text" ng-model="firstname" class="form-control" placeholder="ชื่อจริง">
            </div>
            <div class="form-group">
                <div class="text-left">Lastname</div>
                <input type="text" ng-model="lastname" class="form-control" placeholder="นามสกุลจริง">
            </div>
            <div class="form-group">
                <div class="text-left">Birthday</div>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" ng-model="birthday" class="date form-control" placeholder="ว.ด.ป. เกิด">
                    </div>
                    <div class="col-sm-6">
                        <select ng-model="gender" name="Gender" class="form-control">
                            <option value="">เลือกเพศ</option>
                            <option value="1">male</option>
                            <option value="2">female</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="text-left">Email</div>
                <input type="text" ng-model="email" class="form-control" placeholder="อีเมล์ที่ใช้">
            </div>
            <div class="form-group">
                <div class="text-left">Phone</div>
                <input type="text" ng-model="phone" class="form-control" placeholder="เบอร์โทรศัพท์ที่ติดต่อได้">
            </div>
            <div class="form-group">
                <div class="text-left">Add Tags</div>
                <input type="text" ng-model="tag" class="form-control" placeholder="สร้างป้ายระบุเพื่อใช้ในการกรองและค้นหา">
            </div>
            <div class="form-group">
                <div class="text-left">Password</div>
                <input type="password" ng-model="password" class="form-control" placeholder="รหัสที่ใช่">
            </div>
            <div class="form-group">
                <div class="text-left">Confirm Password</div>
                <input type="password" ng-model="password2" class="form-control" placeholder="ยืนยันรหัสอีกครั้ง">
            </div>
            <input type="submit" id="submit" class="hide" />
        </form>
    </div>
</div>
