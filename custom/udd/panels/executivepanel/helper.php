<?php
if ( !defined ( 'sugarEntry' ) || !sugarEntry ) die ( 'Not a valid entry point.' );

class ExecutivePanelHelper {

	protected $db;

	/**
	 * __construct
	 */
	public function __construct () {
		$this->db = DBManagerFactory::getInstance();
	}
	
	/**
	 * save_quote
	 */
	public function save_quote ( $quote ) {
		$product_id		= $quote['course']['codigo_c'];
		$first_name		= $quote['first_name'];
		$last_name		= $quote['last_name'];
		$email			= $quote['email'];
		$phone			= $quote['phone'];
		$sede 			= $quote['sede'];
		$campaign_id	= 1;
		
		$workflow_query_url = '/ref/index.php?' . http_build_query(array(
			'entryPoint'	=> 'webForm2',
			'product_id'	=> $product_id,
			'first_name'	=> $first_name,
			'last_name'		=> $last_name,
			'email'			=> $email,
			'phone'			=> $phone,
			'sede'			=> $sede,
			'campaign_id'	=> $campaign_id 
		));
		error_reporting(E_ALL);
		
		$curl_request = curl_init ();
        
        curl_setopt( $curl_request, CURLOPT_URL, $workflow_query_url );
        curl_setopt( $curl_request, CURLOPT_HTTPGET, 1 );
        curl_setopt( $curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
        curl_setopt( $curl_request, CURLOPT_HEADER, 1 );
        curl_setopt( $curl_request, CURLOPT_RETURNTRANSFER, 1 );
        
        $result = curl_exec( $curl_request );
        
        curl_close( $curl_request );
		
		var_dump ( $result );
		var_dump ( $workflow_query_url );
		return $result;
	}

	/**
	 * save_vendor
	 */
	public function save_vendor ( $vendor_data ) {
		$vendor_id 	= $vendor_data['id'];
		$vendor 	= BeanFactory::getBean ( 'Users', $vendor_id );

		$vendor->status 			= $vendor_data['employee_status'];
		$vendor->employee_status 	= $vendor_data['employee_status'];
		$vendor->receive_sales_c 	= $vendor_data['receive_sales_c'];
		$vendor->sales_qty_c 		= $vendor_data['sales_qty_c'];

		$vendor_products 			= $vendor->get_linked_beans ( 'users_aos_products_1', 'AOS_Products' );

		// Update (add/remove) products upon requested
		foreach ( $vendor_data['tmpAvailableCourses'] as $tmpAvailableCourse ) {
			$course_id = $tmpAvailableCourse['id'];
			$vendor->users_aos_products_1->delete ( $vendor->id, $course_id );
		}

		foreach ( $vendor_data['tmpAssignedCourses'] as $tmpAssignedCourse ) {
			$course_id = $tmpAssignedCourse['id'];
			$vendor->users_aos_products_1->add ( $course_id );
		}

		$vendor->save();
		return $vendor;
	}

	/**
	 * createBean
	 */
	public function createBean ( $moduleName, $data ) {
		$bean = BeanFactory::newBean ( $moduleName );

		foreach ( $data as $k => $d ) {
			$bean->$k = $d;
		}

		$bean->save();
		return $bean;
	}

	/**
	 * get_vendors
	 */
	public function get_vendors ( $user = null ) {
		if ( false && !empty ( $user ) ) { // Do not do for now
			// $current_user_security_groups = $this->get_director_security_groups_by_user_id ( '9e2a0cfd-b26f-c53a-97cb-53590224d09f' );
			$current_user_security_group = $this->get_director_security_groups_by_user_id ( $user->id );

			$sql_vendors_in_group = "Select
										su.user_id user_id

									From
										securitygroups_users su

									Where
										su.deleted = 0";
			
			$sql_vendors_in_group .= "\n AND su.securitygroup_id IN(";
			$sql_security_groups = array();
			foreach ( $current_user_security_groups as $current_user_security_group ) {
				$sql_security_groups[] = '\'' . $current_user_security_group->id . '\'';
			}
			$sql_vendors_in_group .= implode ( $sql_security_groups );
			$sql_vendors_in_group .= ')';

			$result 		= $this->query ( $sql_vendors_in_group );
			$vendors_ids 	= array();
			foreach ( $result as $vendor_id ) {
				$vendors_ids[] = '\'' . $vendor_id['user_id'] . '\'';
			}
		}

		$sql = "Select
					u.id

				From
					users u,
					acl_roles r,
					acl_roles_users ru

				Where
					u.deleted = 0
					AND ru.deleted = 0
					AND r.deleted = 0
					AND ru.user_id = u.id
					AND ru.role_id = r.id
					AND r.name IN ('Ejecutivo')";
		
		// if ( isset ( $vendors_ids ) ) {
		// 	$sql .= "\nAND u.id IN(";
		// 	$sql .= implode ( ',', $vendors_ids );
		// 	$sql .= ')';
		// }
		
		$users_ids 	= $this->query ( $sql );
		$users 		= array();
		foreach ( $users_ids as $user_id ) {
			$user 				= BeanFactory::getBean ( 'Users', $user_id['id'] );
			$user->courses 		= $user->get_linked_beans ( 'users_aos_products_1', 'AOS_Products' );
			$users[] 			= $user; 
		}
		
		return $users;
	}

	/**
	 * get_courses
	 */
	public function get_courses ( $user = null ) {
		if ( false && !empty ( $user ) ) { // Do not do while demo time
			$current_user_security_groups = $this->get_director_security_groups_by_user_id ( '9e2a0cfd-b26f-c53a-97cb-53590224d09f' );
			// $current_user_security_group = $this->get_director_security_groups_by_user_id ( $user->id );

			$sql_products_in_group = "Select
										sp.securitygroups_aos_products_1aos_products_idb product_id

									From
										securitygroups_aos_products_1_c sp

									Where
										sp.deleted = 0";

			$sql_products_in_group .= "\n AND sp.securitygroups_aos_products_1securitygroups_ida IN(";
			$sql_security_groups 	= array();
			foreach ( $current_user_security_groups as $current_user_security_group ) {
				$sql_security_groups[] = '\'' . $current_user_security_group->id . '\'';
			}
			$sql_products_in_group .= implode ( $sql_security_groups );
			$sql_products_in_group .= ')';

			$result 		= $this->query ( $sql_products_in_group );
			$products_ids 	= array();
			foreach ( $result as $product_id ) {
				$products_ids[] = '\'' . $product_id['product_id'] . '\'';
			}

			$this->debug ( $sql_products_in_group );
		}

		$sql = "Select
					p.id

				From
					aos_products p

				Where
					p.deleted = 0";

		// if ( isset ( $products_ids ) ) {
		// 	$sql .= "\nAND p.id IN(";
		// 	$sql .= implode ( ',', $products_ids );
		// 	$sql .= ')';
		// }

		$courses_ids 	= $this->query ( $sql );
		$courses 		= array();
		foreach ( $courses_ids as $course_id ) {
			$courses[] = BeanFactory::getBean ( 'AOS_Products', $course_id['id'] );
		}

		return $courses;
	}

	/**
	 * get_director_security_groups
	 */
	public function get_director_security_groups_by_user_id ( $user_id ) {
		$sql = "Select
					sud.securitygroups_users_1securitygroups_ida security_group_id

				From
					securitygroups_users_1_c sud

				Where
					sud.securitygroups_users_1users_idb = '" . $user_id . "'
					AND sud.deleted = 0";

		$result 			= $this->query ( $sql );
		$security_groups 	= array();
		foreach ( $result as $security_group_id ) {
			$security_groups[] = BeanFactory::getBean ( 'SecurityGroups', $security_group_id['security_group_id'] );
		}

		return $security_groups;
	}

	/**
	 * query
	 */
	protected function query ( $sql ) {
		$result = $this->db->query ( $sql );
		$rows 	= array();
		while ( $row = $this->db->fetchByAssoc ( $result ) ) {
			$rows[] = $row;
		}

		return $rows;
	}

	// /**
	//  * getUserRolesById
	//  */
	// function getUserRolesById ( $user_id ) {
	// 	$roles = array();
	// 	$sql =	"Select
	// 				r.id role_id,
 //                    r.name role_name,
 //                    CONCAT(IFNULL(u.first_name, ''), ' ', u.last_name) user_name
	// 			From
	// 				acl_roles r,
	// 				acl_roles_users ru,
 //                    users u
	// 			Where
	// 				r.deleted = 0
	// 				AND ru.deleted = 0
	// 				AND r.id = ru.role_id
 //                    ANd ru.user_id = u.id 
 //                    AND u.deleted = 0
	// 				AND ru.user_id = '" . $user_id ."'";

	// 	$result = $this->db->query ( $sql );
	// 	while ( $row = $this->db->fetchByAssoc ( $result ) ) {
	// 		$roles[] = $row;
	// 	}

	// 	return $roles;
	// }

	// /**
	//  * userHasRoleByName
	//  */
	// function userHasRoleByName ( $user_id, $role_name ) {
	// 	$roles = $this->getUserRolesById ( $user_id );

	// 	$has_role = false;
	// 	foreach ( $roles as $role ) {
	// 		if ( $role['role_name'] == $role_name ) {
	// 			$has_role = true;
	// 			break;	
	// 		}
	// 	}

	// 	return $has_role;
	// }

	// /**
	//  * getOpportunitiesByDate
	//  */
	// function getOpportunitiesByDate () {
	// 	$sql = "Select
	// 				o.*,
	// 			    ocstm.curso_c curso
	// 			From
	// 				opportunities o,
	// 			    opportunities_cstm ocstm
	// 			Where
	// 				ocstm.id_c = o.id
	// 				AND o.assigned_user_id IN('seed_sally_id')
	// 			    AND o.deleted = 0";
		
	// 	$result = $this->db->query ( $sql );
	// 	$opportunities = array();
	// 	while ( $row = $this->db->fetchByAssoc ( $result ) ) {
	// 		$opportunities[] = $row;
	// 	}

	// 	return $opportunities;
	// }

	/**
	 * debug
	 */
	public function debug ( $data, $title = null ) {
		echo '<pre>';
		if ( !empty ( $title ) && is_string ( $title ) ) {
			echo '<h2>' . $title . '</h2>';
		}
		if ( is_bool ( $data ) ) {
			var_dump ( $data );
		} else {
			print_r ( $data );
		}
		echo '</pre>';
	}

}

?>