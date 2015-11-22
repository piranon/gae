angular.module('customerGroup').directive('addCustomer', function () {
  return {
    template: '\
      <div class="row">\
        <div class="col-md-3"></div>\
          <div class="col-md-8"><div>\
            <div class="row">\
              <div class="col-md-12 customer-selected-box">\
                <div class="row">\
                  <div class="col-md-2">\
                    <div class="circle-size-80">\
                      <img ng-show="customerSelected.image_url" src="{{customerSelected.image_url}}">\
                    </div>\
                  </div>\
                  <div class="col-md-10">\
                    <div class="name">{{customerSelected.first_name}} {{customerSelected.last_name}}</div>\
                    <div class="username">{{customerSelected.user_name}}</div>\
                  </div>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
        <div class="col-md-1">\
          <a href="" class="btn-circle-gray" ng-click="removeCustomer(customerSelected.customer_id);">\
            <span class="glyphicon glyphicon-trash"></span>\
          </a>\
        </div>\
      </div>',
    scope: false
  };
});