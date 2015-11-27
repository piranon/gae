<div ng-app="staff" ng-controller="AddController as add">
    <div class="top-navigation">
        <div class="row module-container">
            <div class="col-md-4">
                <a class="btn-cancle" href="<?php echo $curModule->app_url; ?>start">Cancel</a>
            </div>
            <div class="col-md-4 topic-page">Add New Staff</div>
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
                    <div class="text-left heading-form">Staff Pic</div>
                </div>
                <div class="col-sm-4">
                    <div class="text-left heading-form">Staff Detail</div>
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
                <div class="col-sm-8">
                    <?php if (isset($viewData['myData']['owner_id']) && $viewData['myData']['owner_id']) { ?>
                        <div class="form-group shop-admin">
                            <input type="checkbox" ng-model="add.shopAdmin">
                            <span class="text-left">
                                Set as Shop Admin ตั้งให้เป็นผู้ดูแลหลักของร้าน (ตั้งได้เพียงคนเดียว โดยสามารถเข้าถึงได้ทุกเมนู)
                            </span>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <div class="text-left require-field">Email</div>
                        <div class="text-left desc-field">อีเมล์เพื่อใช้เข้าสู่ระบบ</div>
                        <input type="text" ng-model="add.email" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left require-field">Firstname</div>
                        <div class="text-left desc-field">ชื่อจริง</div>
                        <input type="text" ng-model="add.firstname" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left require-field">Lastname</div>
                        <div class="text-left desc-field">นามสกุลจริง</div>
                        <input type="text" ng-model="add.lastname" class="form-control">
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
                        <div class="text-left require-field">User Role</div>
                        <div class="text-left desc-field">ตำแหน่ง หรือแผนก (ระดับการเข้าถึงระบบหลังร้าน)</div>
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
                        <div class="text-left require-field">Staff Login Password</div>
                        <div class="text-left desc-field">รหัสผ่านเพื่อเข้าสู่ระบบ</div>
                        <input type="{{add.inputType}}" ng-model="add.password" ng-keyup="add.checkPassword()"
                               class="form-control"
                               ng-class="{'add-success': add.password != '' && !add.passwordWarning}" id="password">
                    </div>
                    <div class="add-warning" ng-show='add.passwordWarning'>รหัสต้องมีความยาวอย่างต่ำ 8 ตัว</div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="text-left">&nbsp;</div>
                        <div class="text-left">&nbsp;</div>
                        <input type="checkbox" ng-model="add.passwordCheckbox" ng-click="add.showPassword()">
                        <span class="text-left">Show Password</span>
                    </div>
                </div>
            </div>
            <input type="submit" id="submit" class="hide"/>
        </form>
    </div>
</div>
