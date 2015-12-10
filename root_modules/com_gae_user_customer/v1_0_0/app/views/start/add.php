<div ng-app="customer" ng-controller="AddController as add">
    <div class="top-navigation">
        <div class="row module-container">
            <div class="col-md-4">
                <a class="btn-cancle" href="<?php echo $curModule->app_url; ?>start">Cancel</a>
            </div>
            <div class="col-md-4 topic-page">Add Customer</div>
            <div class="col-md-4">
                <a ng-click="add.clickOnSubmit(); $event.stopPropagation();" class="btn-save">
                    Save
                </a>
            </div>
        </div>
    </div>
    <div class="add-page">
        <form ng-submit="add.submit()" class="module-container">
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
                        <div ng-click="add.clickOnUpload(); $event.stopPropagation();">
                            <div class="area-inner-container">
                                <img id="area-inner-image" src="{{add.imageProfile}}">
                            </div>
                            <span ng-hide="add.imageProfile" id="pic-icon"></span>
                        </div>
                        <div class="hide">
                            <input type="file" file-model='add.fileModel' id="imageCategory" onchange="PreviewImage();">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left require-field">Username</div>
                        <div class="text-left desc-field">ชื่อเรียกลูกค้าสมาชิก</div>
                        <input type="text" ng-model="add.username" id="username" class="form-control"
                               ng-keydown="add.keyDownRequired($event)">
                        <div class="add-warning hide" ng-hide='add.username'></div>
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
                            <input type="text" ng-model="add.email" id="email" class="form-control"
                                   ng-keydown="add.keyDownRequired($event)">
                            <div class="add-warning hide" ng-hide='add.email'></div>
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
                        <input type="text" ng-model="add.firstname" id="first_name" class="form-control"
                               ng-keydown="add.keyDownRequired($event)">
                        <div class="add-warning hide" ng-hide='add.firstname'></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left require-field">Lastname</div>
                        <div class="text-left desc-field">นามสกุลจริง</div>
                        <input type="text" ng-model="add.lastname" id="last_name" class="form-control"
                               ng-keydown="add.keyDownRequired($event)">
                        <div class="add-warning hide" ng-hide='add.lastname'></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left non-require-field">Phone</div>
                        <div class="text-left desc-field">เบอร์โทรศัพท์ที่ติดต่อได้</div>
                        <input type="text" ng-model="add.phone" class="form-control">
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
                        <input type="text" ng-model="add.birthday" class="date form-control" placeholder="ว.ด.ป. เกิด">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left non-require-field">Gender</div>
                        <div class="text-left desc-field">เพศ</div>
                        <select ng-model="add.gender" name="gender" class="form-control"
                                ng-options="s.name for s in add.sexOption">
                            <option value="">เลือกเพศ</option>
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
                        <select ng-model="add.customerGroup" name="customerGroup" class="form-control"
                                ng-options="g.name for g in add.groupOption">
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
                        <input type="text" ng-model="add.tag" class="form-control">
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
                        <input type="{{add.inputType}}" ng-model="add.password" ng-keyup="add.checkPassword($event)"
                               class="form-control"
                               ng-class="{'add-success': add.password != '' && !add.passwordWarning}" id="password">
                        <div class="add-warning" ng-show='add.passwordWarning'>รหัสต้องมีความยาวอย่างต่ำ 8 ตัว</div>
                        <div class="add-warning hide" ng-hide='add.email'></div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left">&nbsp;</div>
                        <div class="text-left">&nbsp;</div>
                        <input type="checkbox" ng-model="add.passwordCheckbox" id="password"
                               ng-click="add.showPassword()">
                        <span class="text-left">Show Password</span>
                    </div>
                </div>
            </div>
            <input type="submit" id="submit" class="hide"/>
        </form>
    </div>
</div>
