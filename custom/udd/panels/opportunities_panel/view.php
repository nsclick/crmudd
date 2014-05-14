<head>
	<meta charset="utf-8" />
	<title><?php echo isset ( $title ) ? $title : 'Panel'; ?></title>

	<!-- Meta -->
	<meta name="viewport" content="width=device-width, intial-scale=1" />

	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php echo $assets ?>css/sales_panel/styles.css" />
	<link rel="stylesheet" href="<?php echo $assets ?>vendor/bootstrap/css/bootstrap.min.css" />


</head>
<body data-ng-controller="ExecutivesPanelController">
	
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
	      <a class="navbar-brand" href="#"><strong>Informe:</strong> Dashoard de Ingreso de Oportunidades</a>
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
	
	<!-- Main Content -->
	<div class="container">
		
		<div class="row">
			<div class="col-md-12">
				
				<form role="form">
					
					<div class="form-group">
						<label for="first_name">Nombres</label>
						<input type="text" name="name" id="first_name" data-ng-model="first_name" class="form-control" required placeholder="Nombres" />
					</div>
					
					<div class="form-group">
						<label for="last_name">Apellidos</label>
						<input type="text" name="last_name" id="last_name" data-ng-model="last_name" class="form-control" required placeholder="Apellidos" />
					</div>
					
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" data-ng-model="email" class="form-control" required placeholder="Correo electr&oacute;nico" />
					</div>
					
					<div class="form-group">
						<label for="phone">Tel&eacute;fono</label>
						<input type="phone" name="phone" class="form-control" id="phone" data-ng-model="phone" required placeholder="Tel&eacute;fono" />
					</div>
					
					<div class="form-group">
						<label for="sede">Sede</label>
						<select class="form-control" data-ng-model="sede" id="sede" data-ng-options="sede.name for sede in sedes" required></select>
					</div>
					
					<div class="form-group">
						<label for="course">Curso</label>
						<select class="form-control" data-ng-model="course" id="course" data-ng-options="course.label group by course.sede for course in courses" required></select>
					</div>
					
					<!--
					<div class="form-group">
						<label for="">Ejecutivo</label>
						<input type="text" class="form-control" id="" placeholder="" />
					</div>
					-->
					
					<div class="form-group">
						<button type="button" class="btn default-btn" data-ng-disabled="isDisabled" data-ng-click="send_form()">Enviar</div>
					</div>
					
				</form>
		
			</div>
		</div>
	</div>
	<!-- Main Content -->
	
	
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
					base:	<?php echo '\'http:\/\/' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] .'\''; ?>,
					workflow: 	<?php echo '\'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'] . '?entryPoint=webForm2\''; ?>
				})
				
				/**
				 * Vendors
				 */
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
				
				/**
				 * Quotes
				 */
				.service('Quotes', [
					'$http',
					'urls',
					function($http, urls) {
					
						this.save = function(data) {
							console.log(urls.workflow);
							console.log(data);
							var query_url = urls.workflow;
								query_url += '&product_id=' + data.course.codigo_c;
								query_url += '&first_name=' + data.first_name;
								query_url += '&last_name=' + data.last_name;
								query_url += '&email=' + data.email;
								query_url += '&phone=' + data.phone;
								query_url += '&sede=' + data.sede.value;
							console.log(query_url);
							
							return $http.get(query_url);
						}
					
					}
				])
								
				/**
				 * Courses
				 */
				.service('Courses', [
					'$http',
					'urls',
					'sedes',
					function($http, urls, sedes) {
						
						this.list = function() {
							var courses = <?php echo json_encode ( $courses ); ?>;
							
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
				
				/**
				 * Sedes
				 */
				.service('Sedes', [
					'$http',
					'urls',
					function($http, urls) {

						this.list = function() {
							var sedes = <?php echo json_encode($sedes); ?>;
							return sedes;
						};

						this.get = function() {
							return $http.post(
								urls.base,
								{
									action: 'list_sedes'
								}
							);
						};

					}
				])
				
				;
		})(window, angular);
	</script>
	<script src="<?php echo $assets ?>js/executivepanel/app.js"></script>
	
</body>
