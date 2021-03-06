<head>
	<meta charset="utf-8" />
	<title><?php echo isset ( $title ) ? $title : 'Panel'; ?></title>

	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php echo $assets ?>css/sales_panel/styles.css" />
	<link rel="stylesheet" href="<?php echo $assets ?>vendor/bootstrap/css/bootstrap.min.css" />

</head>
<body data-ng-controller="SalesPanelController">
	
	<!-- Navbar -->
	<div class="salespanel_navbar navbar navbar-inverse" role="navigation">
	  <div class="container">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#"><strong>Informe:</strong> Dashoard de Administraci&oacute;n de Ejecutivos</a>
	    </div>
	    <div class="navbar-collapse collapse">
	      <form class="navbar-form navbar-right" role="form">
	        <a href="//<?php echo $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']; ?>" class="btn btn-success">UDD CRM Inicio</a>
	      </form>
	    </div><!--/.navbar-collapse -->
	  </div>
	</div>
	<!--/ Navbar -->

	<!-- Status Bar -->
	<div data-ng-if="showstatusbar" data-ng-class="{'bg-success': !saving, 'text-success': !saving, 'bg-info': saving,  'text-info': saving}" class="salespanel_statusbar text-center">
		<p data-ng-if="saving">
			<span><strong>Guardando...</strong> </span>
			<span class="glyphicon glyphicon-floppy-save"></span>
		</p>
		<p data-ng-if="!saving">
			<span><strong>Guardado con &eacute;xito </strong></span>
			<span class="glyphicon glyphicon-floppy-saved"></span>
		</p>
	</div>
	<!-- Status Bar -->
	
	<!-- Table -->
	<div class="container">
		
		<div class="row">
			<div class="col-md-12">

				<table class="table table-hover">
					
					<thead>
						<tr>
							<td>Cursos</td>
							<td>Nombre</td>
							<td>Estado</td>
							<td>Recibe Cotizaci&oacute;n</td>
							<td>N&uacute;mero de Oportunidades</td>
							<td>Nivelar</td>
						</tr>
					</thead>
					
					<tbody data-ng-repeat="vendor in vendors">
					<!-- Vendor -->
						
						<!-- Vendor Info -->
						<tr data-ng-class="{active: vendor.opened}">
							
							<!-- Vendor Open/Close button -->
							<td>
								<button type="button" class="btn btn-danger" data-ng-click="toggleOpenedStateVendor(vendor)">
									<span data-ng-if="vendor.opened" class="glyphicon glyphicon-circle-arrow-up"></span>
									<span data-ng-if="!vendor.opened" class="glyphicon glyphicon-circle-arrow-down"></span>
								</button>
							</td>
							<!--/ Vendor Open/Close button -->

							<!-- Vendor Name -->
							<td>{{vendor.name}}</td>
							<!--/ Vendor Name -->
							
							<!-- Vendor State -->
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										{{vendor.status}} <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li data-ng-repeat="state in vendorStates">
											<a href="#" data-ng-click="changeVendorState(vendor, state)">{{state.name}}</a>
										</li>
									</ul>
								</div>
							</td>
							<!--/ Vendor State -->

							<!-- Vendor Receive Oppoertunities -->
							<td>
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default" data-ng-click="setVendorReceiveOpportunities(vendor, 1)" data-ng-class="{active: vendor.receive_sales_c == 1}">
										<input type="radio" name="vop_{{vendor.id}}" data-ng-model="vendor.receiveOpportunities" value="1"> <span>Si</span>
									</label>
									<label class="btn btn-default" data-ng-click="setVendorReceiveOpportunities(vendor, 0)" data-ng-class="{active: !vendor..receive_sales_c == 0}">
										<input type="radio" name="vop_{{vendor.id}}" data-ng-model="vendor.receiveOpportunities" value="0"> <span>No</span>
									</label>
								</div>
							</td>
							<!--/ Vendor Receive Oppoertunities -->

							<!-- Vendor Opportunities Quantity -->
							<td>{{vendor.sales_qty_c}}</td>
							<!--/ Vendor Opportunities Quantity -->
							
							<!-- Vendor Nivelate Button -->
							<td>
								<button type="button" class="btn btn-info" data-ng-click="nivelate(vendor)">
									<span data-ng-if="!vendor.nivelating">Nivelar</span>
									<span data-ng-if="vendor.nivelating">Nivelando...</span>
								</button>
							</td>
							<!--/ Vendor Nivelate Button -->
						</tr>
						<!--/ Vendor Info -->

						<!-- Vendor Courses Assign -->
						<tr class="active" data-ng-if="vendor.opened">
							<td class="vendor_courses_label">Asignaci&oacute;n de Cursos</td>
							
							
							<td colspan="2">
								
								<div class="panel panel-default">
									<div class="panel-heading">Cursos Asignados</div>
									<div class="panel-body">
										
										<select size="10" class="vendor_courses_select" multiple data-ng-model="vendor.selectedAssignedCourses" data-ng-options="course.label group by course.sede for course in vendor.tmpAssignedCourses"></select>

									</div>
								</div>

							</td>
							
							<!-- Vendor Courses Arrows -->
							<td class="vendor_courses_arrows">
								<div>
									<a href="#" class="btn bnt-link" data-ng-click="removeSelectedCourses(vendor)">
										<span class="glyphicon glyphicon-arrow-right"></span>
									</a>
								</div>
								<div>
									<a href="#" class="btn bnt-link" data-ng-click="addSelectedCourses(vendor)">
										<span class="glyphicon glyphicon-arrow-left"></span>
									</a>
								</div>
							</td>
							<!--/ Vendor Courses Arrows -->

							<td colspan="2">
								
								<div class="panel panel-default">
									<div class="panel-heading">Cursos Disponibles</div>
									<div class="panel-body">
										
										<select size="10" class="vendor_courses_select" multiple data-ng-model="vendor.selectedAvailableCourses" data-ng-options="course.label group by course.sede for course in vendor.tmpAvailableCourses"></select>

									</div>
								</div>

							</td>
						</tr>
						<!--/ Vendor Courses Assign -->

					<!--/ Vendor -->
					</tbody>

				</table>

			</div>
		</div>

	</div>
	<!--/ Table -->

	<!-- Scripts -->
	<script src="<?php echo $assets ?>vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo $assets ?>vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $assets ?>vendor/angular/angular.js"></script>
	<script>
		(function(window, angular, undefined) {
			angular.module('Globals', [])
				
				.constant('sedes', <?php echo json_encode($app_list_strings['user_sede_c']); ?>)
				
				.constant('user_states', <?php echo json_encode($app_list_strings['user_status_dom']); ?>)
				
				.constant('urls', {
					assets: <?php echo '\'' . $assets . '\''; ?>,
					base: 	<?php echo '\'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '?entryPoint=administracion\''; ?>
				})

				.service('Vendors', [
					'$http',
					'urls',
					function($http, urls) {

						this.list = function() {
							var vendors = <?php echo json_encode($vendors); ?>;
							return vendors;
						};


						this.get = function(vendor_id, data) {
							data = data || {};
							if (!vendor_id) {
								data.action = 'list_vendors';
							} else {
								data.action = 'get_vendor';
							}

							return $http.post(
								urls.base,
								data
							);
						};

						this.save = function(data) {
							var obj = {
								action: 	'save_vendor',
								vendor: 	data
							};

							return $http.post(
								urls.base,
								obj
							);
						}

					}
				])

				.service('Courses', [
					'$http',
					'urls',
					'sedes',
					function($http, urls, sedes) {

						this.list = function() {
							var courses = <?php echo json_encode($courses); ?>;
							
							angular.forEach(courses, function(course) {
								course.sede 	= sedes[course.sede_c];
								course.label 	= '(' + course.codigo_c + ') ' + course.name;
							});
							
							return courses;
						};

						this.get = function() {
							return $http.post(
								urls.base,
								{
									action: 'list_courses'
								}
							);
						};

					}
				])
				;

		})(window, angular);
	</script>
	<script src="<?php echo $assets ?>js/sales_panel/app.js"></script>

</body>