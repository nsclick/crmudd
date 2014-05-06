(function(window, angular, undefined) {
	
var app = angular.module('executive_app', ['Globals'])
	
	.controller('ExecutivesPanelController', [ 
			'Vendors',
			'Courses',
			'Sedes',
			'Quotes',
			'urls',
			'$scope',
			'$timeout',
			'$http',
			function(Vendors, Courses, Sedes, Quotes, urls, $scope, $timeout, $http) {
				$scope.saving 			= false;
				$scope.showstatusbar 	= false;
				$scope.sedes 			= [];
				$scope.isDisabled 		= false;
				$scope.vendors 			= Vendors.list();
				$scope.courses 			= Courses.list();
				
				angular.forEach($scope.courses, function(course) {
					course.label = ' (' + course.codigo_c + ') - ' + course.name;
				});
				
				console.log($scope);
				
				// Debugging
//				$scope.first_name = 'Luis Carlos';
//				$scope.last_name = 'Osorio Jayk';
//				$scope.phone = '123123';
//				$scope.email = 'ljayk@nsclick.cl';
				
				// Set sedes list
				angular.forEach(Sedes.list(), function(name, value) {
					$scope.sedes.push({
						name: 	name,
						value:	value
					});
				});
				
				$scope.send_form = function() {
					var q = {
							first_name: $scope.first_name,
							last_name: $scope.last_name,
							email: $scope.email,
							phone: $scope.phone,
							sede: $scope.sede,
							course: $scope.course
					};
					
					console.log(q);
					console.log(urls.base);
					if(true) {
						$scope.saving 			= true;
						$scope.showstatusbar	= true;
						
						return Quotes.save(q)
							.then(function(r) {
								console.log('Saved: ', r.data);
								$scope.saving = false;
								$timeout(function() {
									$scope.showstatusbar = false;
								}, 1000);
							});
					}
					
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
		angular.bootstrap(document, ['executive_app']);
	});

})(window, angular);