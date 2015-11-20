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
            <div class="row">
                <div class="col-sm-3">
                    <div class="text-left heading-form">Profile Pic</div>
                </div>
                <div class="col-sm-4">
                    <div class="text-left heading-form">Customer Detail</div>
                </div>
                <div class="col-sm-4"></div>
            </div>
            <div class="row">
                <div class="col-sm-3">
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
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left require-field">Username</div>
                        <div class="text-left desc-field">ชื่อเรียกลูกค้าสมาชิก</div>
                        <input type="text" ng-model="username" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left require-field">Member Id</div>
                        <div class="text-left desc-field">ชื่อเรียกลูกค้าสมาชิก</div>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="text-left require-field">Email</div>
                            <div class="text-left desc-field">ชื่อเรียกลูกค้าสมาชิก</div>
                            <input type="text" ng-model="email" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left require-field">Firstname</div>
                        <div class="text-left desc-field">ชื่อจริง</div>
                        <input type="text" ng-model="firstname" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left require-field">Lastname</div>
                        <div class="text-left desc-field">นามสกุลจริง</div>
                        <input type="text" ng-model="lastname" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left non-require-field">Phone</div>
                        <div class="text-left desc-field">เบอร์โทรศัพท์ที่ติดต่อได้</div>
                        <input type="text" ng-model="phone" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left non-require-field">Mobile Phone</div>
                        <div class="text-left desc-field">เบอร์โทรศัพท์มือถือที่ติดต่อได้</div>
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left non-require-field">Birthday</div>
                        <div class="text-left desc-field">วันเดือนปีเกิด</div>
                        <input type="text" ng-model="birthday" class="date form-control" placeholder="ว.ด.ป. เกิด">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left non-require-field">Gender</div>
                        <div class="text-left desc-field">เพศ</div>
                        <select ng-model="gender" name="Gender" class="form-control">
                            <option value="">เลือกเพศ</option>
                            <option value="1">male</option>
                            <option value="2">female</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left non-require-field">Customer Group</div>
                        <div class="text-left desc-field">กลุ่มลูกค้า</div>
                        <select ng-model="customerGroup" name="customerGroup" class="form-control">
                            <option value="">เลือกกลุ่มลูกค้า</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4"></div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left non-require-field">Customer Tag</div>
                        <div class="text-left desc-field">ป้ายกำกับลูกค้า</div>
                        <input type="text" ng-model="tag" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left non-require-field">Note</div>
                        <div class="text-left desc-field">ข้อความจำอื่นๆ</div>
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left require-field">Login Password</div>
                        <div class="text-left desc-field">รหัสผ่านของลูกค้า</div>
                        <input type="{{inputType}}" ng-model="password" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left">&nbsp;</div>
                        <div class="text-left">&nbsp;</div>
                        <input type="checkbox" ng-model="passwordCheckbox" ng-click="showPassword()">
                        <span class="text-left">Show Password</span>
                    </div>
                </div>
            </div>
            <input type="submit" id="submit" class="hide" />
        </form>
    </div>
</div>
