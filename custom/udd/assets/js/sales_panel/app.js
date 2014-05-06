(function(window, angular, undefined) {

var app = 	angular.module('sales_vendor_app', ['Globals'])
				

				.controller('SalesPanelController', [
					'Vendors',
					'Courses',
					'urls',
					'$scope',
					'$timeout',
					'$http',
					function(Vendors, Courses, urls, $scope, $timeout, $http) {
						$scope.saving 			= false;
						$scope.showstatusbar 	= false;
						$scope.vendorStates 	= ['Activo', 'Inactivo', 'Despedido', 'Vacaciones'];

						$scope.vendors 			= Vendors.list();
						$scope.availableCourses = Courses.list();

						// And now that we have vendors and courses, mix them
						angular.forEach($scope.vendors, function(vendor) {
							vendor.tmpAssignedCourses 	= [];
							vendor.tmpAvailableCourses 	= [];

							angular.forEach($scope.availableCourses, function(availableCourse) {
								var found = false;
								
								angular.forEach(vendor.courses, function(vendorCourse) {
									if(vendorCourse.id == availableCourse.id) {
										var course = angular.copy(availableCourse);
										vendor.tmpAssignedCourses.push(course);
										found = true;
									}
								});

								if(!found) {
									var course = angular.copy(availableCourse);
									vendor.tmpAvailableCourses.push(course);
								}

							});
						});

						$scope.nivelate = function(vendor) {
							if(!!vendor.nivelating)
								return false;

							vendor.nivelating = true;

							var maximum_opportunities_qty = 0;
							angular.forEach($scope.vendors, function(v) {
								v.sales_qty_c = parseInt(v.sales_qty_c);
								if(v.sales_qty_c > maximum_opportunities_qty) {
									maximum_opportunities_qty = v.sales_qty_c;
								}
							});
							
							var vendor_clone 			= angular.copy(vendor); 
							vendor_clone.sales_qty_c 	= maximum_opportunities_qty + 1;
							save_vendor(vendor_clone)
								.then(function(r) {
									vendor.sales_qty_c = vendor_clone.sales_qty_c;
									vendor.nivelating = false;
								});
							
//							$timeout(function() {
//								vendor.nivelating = false;
//							}, 2000);
						};

						$scope.toggleOpenedStateVendor = function(vendor) {
							vendor.opened = angular.isUndefined(vendor.opened) ? false : vendor.opened;
							vendor.opened = !vendor.opened;
						};

						$scope.changeVendorState = function(vendor, vendorState) {
							vendor.employee_status 	= vendorState;
							vendor.status 			= vendorState;

							save_vendor(vendor);
						};

						$scope.removeSelectedCourses = function(vendor) {
							angular.forEach(vendor.selectedAssignedCourses, function(selectedAssignedCourse, index) {
								vendor.tmpAvailableCourses.push(selectedAssignedCourse);
								angular.forEach(vendor.tmpAssignedCourses, function(assignedCourse, aIndex) {
									if(assignedCourse.id == selectedAssignedCourse.id) {
										vendor.tmpAssignedCourses.splice(aIndex, 1);
									}
								});
							});

							save_vendor(vendor);
						};

						$scope.addSelectedCourses = function(vendor) {
							angular.forEach(vendor.selectedAvailableCourses, function(selectedAvailableCourse, index) {
								vendor.tmpAssignedCourses.push(selectedAvailableCourse);
								angular.forEach(vendor.tmpAvailableCourses, function(availableCourse, aIndex) {
									if(availableCourse.id == selectedAvailableCourse.id) {
										vendor.tmpAvailableCourses.splice(aIndex, 1);
									}
								});
							});

							save_vendor(vendor);
						};

						$scope.setVendorReceiveOpportunities = function(vendor, value) {
							vendor.receive_sales_c = value;

							save_vendor(vendor);
						};

						function save_vendor(vendor) {
							$scope.saving 			= true;
							$scope.showstatusbar 	= true;

							return Vendors.save(vendor)
								.then(function(r) {
									// console.log('Saved: ', r.data);
									$scope.saving = false;
									$timeout(function() {
										$scope.showstatusbar = false;
									}, 1000);
								});
						}

					}
				])
			;

/**
 * Bootstrap angular app
 */
angular.element(document).ready(function() {

	angular.bootstrap(document, ['sales_vendor_app']);

});

})(window, angular);