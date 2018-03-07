<?php

namespace muller;

/**
 * Intialise the theme
 *
 * All classes and hook are intiaded to let the wordpress funciton with the theme.
 *
 */
class userhelper {

	public function __construct($theme){

		$this->theme = $theme;

		//actions
        add_action( 'wp_ajax_offerteaanvraag', array($this, 'offerteaanvraag'));
        add_action( 'wp_ajax_nopriv_offerteaanvraag', array($this, 'offerteaanvraag'));
        add_action( 'wp_ajax_getuser', array($this, 'getuserajx'));
        add_action( 'wp_ajax_nopriv_getuser', array($this, 'getuserajx'));
        add_action( 'wp_ajax_saveuser', array($this, 'saveuser'));
        add_action( 'wp_ajax_nopriv_saveuser', array($this, 'saveuser'));
       	add_action( 'um_submit_form_errors_hook_', array($this, 'um_custom_validate_username'), 999, 1);
        
        add_action( 'um_after_account_general', array($this, 'show_extra_fields'), 100);
        add_action( 'um_admin_user_action_hook', array($this, 'um_after_user_is_approved'));
        add_action( 'um_after_register_fields', array($this,'add_a_hidden_field_to_register'));

        add_filter('um_get_option_filter__welcome_email_sub', array($this, 'um_text'));
        add_filter('um_get_option_filter__welcome_email', array($this, 'um_text'));
        add_filter('um_get_option_filter__checkmail_email_sub', array($this, 'um_text'));
        add_filter('um_get_option_filter__checkmail_email', array($this, 'um_text'));
        add_filter('um_get_option_filter__pending_email_sub', array($this, 'um_text'));
        add_filter('um_get_option_filter__pending_email', array($this, 'um_text'));
        add_filter('um_get_option_filter__approved_email_sub', array($this, 'um_text'));
        add_filter('um_get_option_filter__approved_email', array($this, 'um_text'));
        add_filter('um_get_option_filter__rejected_email_sub', array($this, 'um_text'));
        add_filter('um_get_option_filter__rejected_email', array($this, 'um_text'));
        add_filter('um_get_option_filter__inactive_email_sub', array($this, 'um_text'));
        add_filter('um_get_option_filter__inactive_email', array($this, 'um_text'));
        add_filter('um_get_option_filter__deletion_email_sub', array($this, 'um_text'));
        add_filter('um_get_option_filter__deletion_email', array($this, 'um_text'));
        add_filter('um_get_option_filter__resetpw_email_sub', array($this, 'um_text'));
        add_filter('um_get_option_filter__resetpw_email', array($this, 'um_text'));
        add_filter('um_get_option_filter__changedpw_email_sub', array($this, 'um_text'));
        add_filter('um_get_option_filter__changedpw_email', array($this, 'um_text'));
        add_filter('wpbe_tags', array($this, 'add_my_tags'));
        add_filter('um_get_core_page_filter', array($this, 'um_get_core_page_filter'));
        add_filter('lostpassword_url', array($this, 'lostpassword_url'));
	}

	
	public function loginbar(){

		$bar = '';

		if(is_user_logged_in()):

			$currentuser = wp_get_current_user();

			$bar = '<span class="loginbar">'.__('Logged in as: ', 'muller').$currentuser->data->user_nicename.' </span>';

		endif;

		return $bar;
	}

	public function getuserajx(){

		$user = $this->getuser();

		return wp_send_json($user);
	}

	public function getuser(){
		$currentUser = wp_get_current_user();

		$user = array();
		$user['ID'] = $currentUser->ID;
		$user['voornaam'] = $currentUser->user_firstname;
		$user['achternaam'] = $currentUser->user_lastname;
		$user['email'] = $currentUser->user_email;
		$user['bedrijf'] = $currentUser->user_login;
		$user['functie'] = get_user_meta($currentUser->ID, 'functie', true);
		$user['telefoon'] = get_user_meta($currentUser->ID, 'phone_number', true);
		$user['mobiel'] = get_user_meta($currentUser->ID, 'mobile_number', true);
		$user['straat'] = get_user_meta($currentUser->ID, 'straat', true);
		$user['postcode'] = get_user_meta($currentUser->ID, 'postcode', true);
		$user['gemeente'] = get_user_meta($currentUser->ID, 'Gemeente', true);
		$user['land'] = get_user_meta($currentUser->ID, 'land', true);
		$user['muller_klantnummer'] = get_user_meta($currentUser->ID, 'muller_klantnummer', true);
		$user['Aanspreking'] = get_user_meta($currentUser->ID, 'Aanspreking', true);

		// foreach (acf_get_fields_by_id(16219) as $key => $ACF) {
		// 	$user[$ACF['name']] = get_field($ACF['name'], 'user_'.$currentUser->ID);	
		// }



		return $user;
	}

	public function saveuser(){

		$data =  json_decode(stripslashes($_POST['user']));
		
		$userdata = array(
			'ID' => $data->ID, 
			'first_name' => $data->firstname,
			'last_name' => $data->lastname,
			'user_email' => $data->email,
			'nickname' => $data->email
		);

		wp_update_user($userdata);

		$passerror = false;

		if($data->password != '' || $data->password_confirmation != ''){
			if($data->password == ""){
				$passerror = "passnotmatch";

			} elseif ($data->password == $data->password_confirmation){			
				
				wp_set_password( $data->password, $data->ID );
				$passerror = 'success';

			} else {
				
				$passerror = "passnotmatch";
			}
		}

		foreach (acf_get_fields_by_id(16219) as $key => $ACF) {
			update_field($ACF['name'], $data->{$ACF['name']}, 'user_'.$data->ID);
		}

		wp_send_json(['userinfo' => true, 'userpass' => $passerror]);
	}

	public function offerteaanvraag(){
		$cart = $_POST['products'];
		$offerteNaam = json_decode(stripslashes($_POST['naam']));
		$opmerking = json_decode(stripslashes($_POST['opmerking']));
		$currentuser = $this->getuser();
		$usermeta = get_userdata($currentuser['ID']);
	   	$display_name = $usermeta->data->display_name;

	   	$date = date('Y-m-d');

		global $wpdb;
		$sqlinsert = "
			INSERT INTO mll_orders (order_title, order_note, user_id, cart, date)
			VALUES ('".$offerteNaam."','".$opmerking."','".$currentuser['ID']."','".$cart."', '".date('Y-m-d')."');
		";
	   	$wpdb->query($sqlinsert);
	   	$offerteId = $wpdb->insert_id;

	   	if ($offerteNaam) {
			$fullRef = $date.'-'.$display_name.'-'.$offerteId.' Offerte: '.$offerteNaam;
	   	} else{
	   		$fullRef = $date.'-'.$display_name.'-'.$offerteId;
	   	}

	   	// ------------------------------------------------------
	   	// EXCEL
		//$uploadName = '/offerte/muller_order_'.$offerteId.'.xls';
		$fileOfferteNaam = $offerteNaam ? '-'.$offerteNaam : '';
		$uploadName = 'Web_offerteaanvraag_'.$date.'-'.$display_name.'-'.$offerteId.$fileOfferteNaam.'.xls';
		$uploadDir = $this->theme->getUploadDir().'/offerte/muller_order_'.$offerteId.'.xls';
		$excel = [];
		$excel[] = [$fullRef];
		$excel[] = [$offerteNaam];
		$excel[] = [];

		foreach ($currentuser as $key => $value) {
			$excel[] = [$key,$value];
		}
	

		$excel[] = [];

		$excel[] = ['opmerking:'];
		$excel[] = [$opmerking];

		$excel[] = [];

		$excel[] = [
			'ArtikelNr' => 'ArtikelNr',
			'Titel' => 'Titel', 
			'Aantal' => 'Aantal'
		];



		$cart = json_decode(stripcslashes($_POST['products']));
		foreach ($cart as $key => $product) {
			$excel[] = [
				'ArtikelNr' => $this->theme->product->formatnr($product->intern_artikelnr),
				'Titel' => $product->post_title, 
				'Aantal' => $product->count
			];
		}

		$excel[] = [];

		require_once('lib/PHPExcel.php');
		$doc = new \PHPExcel();
		$doc->setActiveSheetIndex(0);
		$doc->getActiveSheet()->fromArray($excel, null, 'A1');
		$doc->getActiveSheet()->getStyle('A19:C19')->applyFromArray(
	            array(
	                'font' => array(
	                    'bold' => true
	                )
	            )
	    );

	    foreach(range('A','G') as $columnID) {
	    	$doc->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	    }
	    $doc->getActiveSheet()->getStyle('A1:A100')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	    $doc->getActiveSheet()->getStyle('B1:B100')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	    $doc->getActiveSheet()->getStyle('C1:C100')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="your_name.xls"');
		header('Cache-Control: max-age=0');

		$writer = \PHPExcel_IOFactory::createWriter($doc, 'Excel5');
		$writer->save($uploadDir);

		// ------------------------------------------------------
		// MAIL SETTINGS-----------------------------------------
		$sendmails = true;
		$to = $currentuser['email'];
		$subject = __('Web quotation request ').$fullRef;

		global $sitepress;
		$lang = $sitepress->get_current_language();
		$sitepress->switch_lang($lang);

	   	// ------------------------------------------------------
		// CLIENT TEMPLATE
		$template = '';
		$template .= '<tbody>';
			$template .= '<tr>';
				$template .= '<td align="center" class="container" valign="top" style="background-color: #ffffff;">';
					$template .= '<table class="full-width" style="margin: 0px auto; width: 600px; min-width: 600px; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0" align="center">';
						$template .= '<tbody>';
							$template .= '<tr>';
								$template .= '<td valign="top">';
									$template .= '<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="center">';
										$template .= '<tbody>';
											$template .= '<tr>';
												$template .= '<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<h2 style="font-size: 20px; line-height: 24px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= __('Dear ', 'muller');
														$template .= $currentuser['Aanspreking'];
														$template .= ' ';
														$template .= $currentuser['achternaam'];
														$template .= ',';
													$template .= '</h2>';
												$template .= '</td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td height="20" valign="top" style="line-height: 1px; font-size: 1px;"></td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<p style="font-size: 16px; line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= __('Below an overview of your quotation request on muller-nv.be', 'muller');
													$template .= '</p>';
												$template .= '</td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<p style="font-size: 16px; line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= __('Reference: ') . $fullRef;
													$template .= '</p>';
												$template .= '</td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<p style="font-size: 16px; line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= __('Quote name: ') . $offerteNaam;
													$template .= '</p>';
												$template .= '</td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<p style="font-size: 16px; line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= __('Quote note: ') . $opmerking;
													$template .= '</p>';
												$template .= '</td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>';
											$template .= '</tr>';
										$template .= '</tbody>';
									$template .= '</table>';
								$template .= '</td>';
							$template .= '</tr>';
						$template .= '</tbody>';
					$template .= '</table>';
				$template .= '</td>';
			$template .= '</tr>';
		$template .= '</tbody>';

		// TABLE
		$template .= '<tbody>';
			$template .= '<tr>';
				$template .= '<td align="center" class="container" valign="top" style="background-color: #ffffff;">';
					$template .= '<table  class="full-width" style="margin: 0px auto; width: 600px; max-width: 600px; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0" align="center">';
						$template .= '<tbody style="line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
							$template .= '<tr style="font-size: 16px;">';
								$template .= '<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">';
									$template .= __('Item number', 'muller');
								$template .= '</td>';
								$template .= '<td valign="top" width="350" style="margin: 0px auto; width: 350px; min-width: 350px;">';
									$template .= __('Title', 'muller');
								$template .= '</td>';
								$template .= '<td width="50" style="width: 50px; min-width:50px"></td>';
								$template .= '<td valign="top" width="50" style="margin: 0px auto; width: 50px; min-width: 50px;">';
									$template .= __('Number', 'muller');
								$template .= '</td>';
							$template .= '</tr>';
							$template .= '<tr>';
								$template .= '<td valign="top" height="20" style="line-height: 1px; margin: 0px auto;"></td>';
								$template .= '<td valign="top" height="20" style="line-height: 1px; margin: 0px auto;"></td>';
								$template .= '<td valign="top" height="20" style="line-height: 1px; margin: 0px auto;"></td>';
							$template .= '</tr>';

							foreach ($cart as $key => $product) {
								$template .= '<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>';
								$template .= '<tr style="font-size: 16px;">';
									$template .= '<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">';
										$template .= $this->theme->product->formatnr($product->intern_artikelnr);
									$template .= '</td>';
									$template .= '<td valign="top" width="350" style="margin: 0px auto; width: 350px; min-width: 350px;">';
										$template .= get_the_title($product->ID);
									$template .= '</td>';
									$template .= '<td width="50" style="width: 50px; min-width:50px"></td>';
									$template .= '<td valign="top" width="50" style="margin: 0px auto; width: 50px; min-width: 50px;">';
										$template .= $product->count;
									$template .= '</td>';
								$template .= '</tr>';
								$template .= '<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>';
							}

							$template .= '<tr>';
								$template .= '<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>';
								$template .= '<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>';
								$template .= '<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>';
							$template .= '</tr>';
						$template .= '</tbody>';
					$template .= '</table>';
				$template .= '</td>';
			$template .= '</tr>';
		$template .= '</tbody>';

		$template .= '<tbody>';
			$template .= '<tr>';
				$template .= '<td align="center" class="container" valign="top" style="background-color: #ffffff;">';
					$template .= '<table class="full-width" style="margin: 0px auto; width: 600px; min-width: 600px; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0" align="center">';
						$template .= '<tbody>';
							$template .= '<tr>';
								$template .= '<td valign="top">';
									$template .= '<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="center">';
										$template .= '<tbody>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<p style="font-size: 16px; line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= __('Thank you for your request. We will contact you shortly.', 'muller');
													$template .= '</p>';
												$template .= '</td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<p style="font-size: 16px; line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= __('Regards,<br>', 'muller');
														$template .= __('The Muller-team.', 'muller');
													$template .= '</p>';
												$template .= '</td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>';
											$template .= '</tr>';
										$template .= '</tbody>';
									$template .= '</table>';
								$template .= '</td>';
							$template .= '</tr>';
						$template .= '</tbody>';
					$template .= '</table>';
				$template .= '</td>';
			$template .= '</tr>';
		$template .= '</tbody>';

		$mail_attachment = file_get_contents($uploadDir);
		$mail_attachment = base64_encode($mail_attachment);

		require_once('lib/Mandrill.php');
		$mandrill = new \Mandrill('SbRlFIIAlLZ4Lm8nBwlSyA');
		$template_name = 'Muller-NV';
	    $template_content = array(
	        array(
	            'name' => 'main',
	            'content' => $template
	        )
	    );
	    $params = array(
	        "from_email" => 'info@muller-nv.be',
	        "from_name" => 'Muller kitchen and tableware',
	        "subject" => $subject,
	        "to" => array(array('email' => $to)),
	        "track_opens" => false,
	        "track_clicks" => false,
	        "auto_text" => false
	    );
	    if ($sendmails == true) {
		    $mandrill->messages->sendTemplate($template_name, $template_content, $params, true);
		}
	    
	    // USER
	    // {"ID":1,
	    // "firstname":"Jeroen","
	    // lastname":"Wotuers",
	    // "email":"web@volta.be",
	    // "bedrijf":"Volta",
	    // "functie":"Web dev",
	    // "telefoon":"03 217 00 23",
	    // "mobiel":"03 217 00 23",
	    // "straat_en_nummer":"Congresstraat 42",
	    // "postcode":"2060",
	    // "gemeente":"Antwerpen",
	    // "geslacht":"Meneer"}

	    // PRODUCT
	    // 24{"ID":14834,
	    //"post_author":"1",
	    //"post_date":"2017-07-12 11:59:21",
	    //"post_date_gmt":"2017-07-12 09:59:21",
	    //"post_content":"Dubbelwandige roestvrijstalen thermosbeker met antislip coating, handig om mee te nemen onderweg of in de auto. Door de vacu\u00fcm isolatie blijven je dranken langer warm of koel. Met de drukaflaatknop bovenop het deksel van de isoleerbeker, open en sluit je de drinktuit veilig af.\r\n
		
		// ADMIN TEMPLATE
		$template = '';
		$template .= '<tbody>';
			$template .= '<tr>';
				$template .= '<td align="center" class="container" valign="top" style="background-color: #ffffff;">';
					$template .= '<table class="full-width" style="margin: 0px auto; width: 600px; min-width: 600px; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0" align="center">';
						$template .= '<tbody>';
							$template .= '<tr>';
								$template .= '<td valign="top">';
									$template .= '<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="center">';
										$template .= '<tbody>';
											$template .= '<tr>';
												$template .= '<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<h2 style="font-size: 20px; line-height: 24px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= 'Offerteaanvraag: ' . $currentuser['bedrijf'];
													$template .= '</h2>';
												$template .= '</td>';
											$template .= '</tr>';
											
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<h2 style="font-size: 20px; line-height: 24px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= 'Beste beheerder,';
													$template .= '</h2>';
												$template .= '</td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td height="20" valign="top" style="line-height: 1px; font-size: 1px;"></td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<p style="font-size: 16px; line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= 'Volgende offerte aanvraag is zonet ontvangen. Zie de bijlage voor meer details.';
													$template .= '</p>';
												$template .= '</td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<p style="font-size: 16px; line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= 'Referentie: ' . $fullRef;
													$template .= '</p>';
												$template .= '</td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<p style="font-size: 16px; line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= 'Offerte naam: ' . $offerteNaam;
													$template .= '</p>';
												$template .= '</td>';
											$template .= '</tr>';
											$template .= '<tr>';
												$template .= '<td align="left" valign="top">';
													$template .= '<p style="font-size: 16px; line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
														$template .= 'Offerte opmerking: ' . $opmerking;
													$template .= '</p>';
												$template .= '</td>';
											$template .= '</tr>';

											$template .= '<tr>';
												$template .= '<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>';
											$template .= '</tr>';
										$template .= '</tbody>';
									$template .= '</table>';
								$template .= '</td>';
							$template .= '</tr>';
						$template .= '</tbody>';
					$template .= '</table>';
				$template .= '</td>';
			$template .= '</tr>';
		$template .= '</tbody>';

		// TABLE 1
		$template .= '<tbody>';
			$template .= '<tr>';
				$template .= '<td align="center" class="container" valign="top" style="background-color: #ffffff;">';
					$template .= '<table  class="full-width" style="margin: 0px auto; width: 600px; max-width: 600px; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0" align="center">';
						$template .= '<tbody style="line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
							foreach ($currentuser as $key => $row) {
								if ($key == 'straat') {
									$key = 'adres';
								}
								$key = ucfirst($key);
								
								$template .= '<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>';
								$template .= '<tr style="font-size: 16px;">';
									$template .= '<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">';
										$template .= $key;
									$template .= '</td>';
									$template .= '<td valign="top" width="350" style="margin: 0px auto; width: 350px; min-width: 350px;">';
										$template .= $row;
									$template .= '</td>';
								$template .= '</tr>';
								$template .= '<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>';
							}

							$template .= '<tr>';
								$template .= '<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>';
								$template .= '<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>';
								$template .= '<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>';
							$template .= '</tr>';
						$template .= '</tbody>';
					$template .= '</table>';
				$template .= '</td>';
			$template .= '</tr>';
		$template .= '</tbody>';
		// TABLE 2
		$template .= '<tbody>';
			$template .= '<tr>';
				$template .= '<td align="center" class="container" valign="top" style="background-color: #ffffff;">';
					$template .= '<table  class="full-width" style="margin: 0px auto; width: 600px; max-width: 600px; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0" align="center">';
						$template .= '<tbody style="line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">';
							$template .= '<tr style="font-size: 16px;">';
								$template .= '<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">';
									$template .= 'Artikelnummer';
								$template .= '</td>';
								$template .= '<td valign="top" width="350" style="margin: 0px auto; width: 350px; min-width: 350px;">';
									$template .= 'Titel';
								$template .= '</td>';
								$template .= '<td width="50" style="width: 50px; min-width:50px"></td>';
								$template .= '<td valign="top" width="50" style="margin: 0px auto; width: 50px; min-width: 50px;">';
									$template .= 'Aantal';
								$template .= '</td>';
							$template .= '</tr>';
							$template .= '<tr>';
								$template .= '<td valign="top" height="20" style="line-height: 1px; margin: 0px auto;"></td>';
								$template .= '<td valign="top" height="20" style="line-height: 1px; margin: 0px auto;"></td>';
								$template .= '<td valign="top" height="20" style="line-height: 1px; margin: 0px auto;"></td>';
							$template .= '</tr>';

							foreach ($cart as $key => $product) {
								$template .= '<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>';
								$template .= '<tr style="font-size: 16px;">';
									$template .= '<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">';
										$template .= $this->theme->product->formatnr($product->intern_artikelnr);
									$template .= '</td>';
									$template .= '<td valign="top" width="350" style="margin: 0px auto; width: 350px; min-width: 350px;">';
										$template .= $product->post_title;
									$template .= '</td>';
									$template .= '<td width="50" style="width: 50px; min-width:50px"></td>';
									$template .= '<td valign="top" width="50" style="margin: 0px auto; width: 50px; min-width: 50px;">';
										$template .= $product->count;
									$template .= '</td>';
								$template .= '</tr>';
								$template .= '<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>';
							}

							$template .= '<tr>';
								$template .= '<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>';
								$template .= '<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>';
								$template .= '<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>';
							$template .= '</tr>';
						$template .= '</tbody>';
					$template .= '</table>';
				$template .= '</td>';
			$template .= '</tr>';
		$template .= '</tbody>';
		
		$template_content = array(
		    array(
		        'name' => 'main',
		        'content' => $template
		    )
		);
		$admin_email = get_option('admin_email');
	    $params = array(
	        "from_email" => 'info@muller-nv.be',
	        "from_name" => 'Muller kitchen and tableware',
	        "subject" => $subject,
	        "to" => array(array('email' => $admin_email)),
	        "track_opens" => false,
	        "track_clicks" => false,
	        "auto_text" => false,
	        "attachments" => array(
	            array(
                    'content' => $mail_attachment,
                    'type' => 'application/vnd-xls',
                    'name' => $uploadName,
                )
	        )
	    );
	    if ($sendmails == true) {
	    	$mandrill->messages->sendTemplate($template_name, $template_content, $params, true);
	    }

	}

	public function orderhistory(){
		$currentuser = $this->getuser();
		$postperpage = 5;

		if(!$_GET['pg']){
			$page = 0;
		}else{
			$page = $_GET['pg'];
		}

		$page = $page*$postperpage;

		global $wpdb;
		$sqlselect = "
			SELECT * FROM mll_orders WHERE user_id = ".$currentuser['ID']." ORDER BY id DESC LIMIT ".$postperpage." OFFSET ".$page.";
		";
		$orders = $wpdb->get_results($sqlselect);

		$sqlselect = "
			SELECT * FROM mll_orders WHERE user_id = ".$currentuser['ID']." ORDER BY id DESC 
		";
		$count = count($wpdb->get_results($sqlselect));

		foreach($orders as $order):
			$cartdata = $order->cart;
		endforeach;

		return ['orders' => $orders, 'count' => $count, 'pages' => ceil($count/$postperpage)];
	}		

	public function checkpost(){
		if(isset($_GET['cartvalue'])){

			$cartvalue = $_GET['cartvalue'];
			$currentuser = $this->getuser();

			global $wpdb;
			$sqlselect = "
				SELECT * FROM mll_orders WHERE user_id =".$currentuser['ID']."
			";
			$orders = $wpdb->get_results($sqlselect)[0];

			$compressedJSON = json_encode($cookie);

			return $orders;
		}
	}

	function show_extra_fields() {

	  global $ultimatemember;
	  $id = um_user('ID');
	  $output = '';

	  $names = ["Aanspreking", "functie", "phone_number","mobile_number","straat", 'postcode', 'gemeente', 'country', 'muller_klantnummer'];

	  $fields = [];
	  foreach( $names as $name )
	    $fields[ $name ] = $ultimatemember->builtin->get_specific_field( $name );
		global $ultimatemember; $id = um_user('ID');
	  $fields = apply_filters( 'um_account_secure_fields', $fields, $id );

	  foreach( $fields as $key => $data )
	    $output .= $ultimatemember->fields->edit_field( $key, $data );

	  echo $output;
	}

	
	function um_custom_validate_username( $args ) {
		global $ultimatemember;
	
		if (  username_exists($args['username']) ) {
			$ultimatemember->form->add_error( 'username', 'Dit bedrijf heeft al een account.' );
		}
	}

	public function um_after_user_is_approved($ID){
		global $ultimatemember;
		$ID = $ultimatemember->user->id;
		$lang = get_user_meta($ID, 'submitted',true)['field_language'];
		
		global $sitepress;
		$sitepress->switch_lang($lang);
		
	}


	public function um_text($text){

		$um_option_key = str_replace('um_get_option_filter__', '', current_filter());
		global $sitepress;
		$lang = $sitepress->get_current_language();
		
		if(isset($this->theme->config['um-email'][$um_option_key][$lang])){
			$transText = $this->theme->config['um-email'][$um_option_key][$lang];
		}else{
			$transText = $text;
		}

		return $transText;
	}
	
	public function add_a_hidden_field_to_register( $args ) {
		echo '<input type="hidden" name="field_language" id="field_language" value="'.ICL_LANGUAGE_CODE.'" />';
	}

	public function add_my_tags( $tags ) {

		$cookielink = get_page_link(apply_filters( 'wpml_object_id', 61416, 'page' ));
		$privacylink = get_page_link(apply_filters( 'wpml_object_id', 61401, 'page' ));

		$tags['privacylinks'] = '
		<table border="0" cellspacing="0" cellpadding="0" align="center">
		  <tbody>
		    <tr style="width: 100%; height: 1px; border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt; text-align: center;">
			<td style="font-size: 14px; line-height: 24px; color: #959398; font-weight: normal; text-align: center; font-family: Arial, Helvetica, sans-serif; word-break: break-word;" align="center"><span style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;"> <a style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;" href="#">Muller-NV</a> - <a style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;" href="'.$privacylink.'">Privacy Policy</a> - <a style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;" href="'.$cookielink.'">Cookie Policy</a> </span></td>
		    </tr>
		  </tbody>
		</table>';	

	    return $tags;
	}

	public function um_get_core_page_filter($url){
		
		if( strpos($url, 'nl/password-reset/') && isset($_GET['lang'])){

			$url = str_replace('nl/password-reset/', $_GET['lang'].'/password-reset/', $url);
		}

		return $url;
	}

	public function lostpassword_url($url){

		$url = $url.'&lang='.ICL_LANGUAGE_CODE;

		return $url;
	}

}