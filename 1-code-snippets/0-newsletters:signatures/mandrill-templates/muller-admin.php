<?php

// GOES INTO BODY VIA MANDRILL
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
												$template .= 'Beste beheerder,';
											$template .= '</h2>';
										$template .= '</td>';
									$template .= '</tr>';
									$template .= '<tr>';
										$template .= '<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>';
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
						if ($key == 'straat_en_nummer') {
							$key = 'adres';
						}
						$key = ucfirst($key);
						
						$template .= '<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>';
						$template .= '<tr style="font-size: 16px;">';
							$template .= '<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">';
								$template .= $key;
							$template .= '</td>';
							$template .= '<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">';
								$template .= $row;
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
						$template .= '<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">';
							$template .= 'Titel';
						$template .= '</td>';
						$template .= '<td valign="top" style="margin: 0px auto; width: 50px; min-width: 50px;">';
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
								$template .= $product->intern_artikelnr;
							$template .= '</td>';
							$template .= '<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">';
								$template .= $product->post_title;
							$template .= '</td>';
							$template .= '<td valign="top" style="margin: 0px auto; width: 50px; min-width: 50px;">';
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

// $to = $currentuser['email'];
$to = 'wout@volta.be';
$subject = 'Offerteaanvraag';
$body = $template;
$headers = array('Content-Type: text/html; charset=UTF-8');
wp_mail( $to, $subject, $body, $headers );

// or
$to = 'wout@volta.be';
$subject = 'Offerteaanvraag';

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
    "from_email" => 'web@volta.be',
    "from_name" => 'Muller-NV',
    "subject" => $subject,
    "to" => array(array('email' => $to)),
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
$mandrill->messages->sendTemplate($template_name, $template_content, $params, true);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="initial-scale=1.0"/>
	<meta name="format-detection" content="telephone=no"/>
	<title>Muller-NV</title>
<!--[if mso]>
<style type="text/css">
td,span,a{font-family: Arial, sans-serif !important;}
</style>
<![endif]-->
<style type="text/css">


/* Resets: see reset.css for details */
.ReadMsgBody { width: 100%; background-color: #ffffff;}
.ExternalClass {width: 100%; background-color: #ffffff;}
.ExternalClass, .ExternalClass p, .ExternalClass span,
.ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
#outlook a{ padding:0;}
body{width: 100%; height: 100%; background-color: #ffffff; margin:0; padding:0;}
body{ -webkit-text-size-adjust:none; -ms-text-size-adjust:none; }
html{width:100%;}
table {mso-table-lspace:0pt; mso-table-rspace:0pt; border-spacing:0;}
table td {border-collapse:collapse;}
table p{margin:0;}
br, strong br, b br, em br, i br { line-height:100%; }
div, p, a, li, td { -webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
h1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }
span a { text-decoration: none !important;}
a{ text-decoration: none !important; }
img{height: auto !important; line-height: 100%; outline: none; text-decoration: none; display:block !important; -ms-interpolation-mode:bicubic;}
.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited,
.yshortcuts a:hover, .yshortcuts a span { text-decoration: none !important; border-bottom: none !important;}
/*mailChimp class*/
.default-edit-image{
	height:20px;
}
.tpl-repeatblock {
	padding: 0px !important;
	border: 1px dotted rgba(0,0,0,0.2);
}

@media only screen and (max-width: 640px){

	table[class="container"]{width:100%!important; max-width:100%!important; min-width:100%!important;
		padding-left:20px!important; padding-right:20px!important; text-align: center!important; clear: both;}
		td[class="container"]{width:100%!important; padding-left:20px!important; padding-right:20px!important; clear: both;}
		table[class="full-width"]{width:100%!important; max-width:100%!important; min-width:100%!important; clear: both;}
		table[class="full-width-center"] {width: 100%!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
		table[class="auto-center"] {width: auto!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
		*[class="auto-center-all"]{width: auto!important; max-width:75%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
		*[class="auto-center-all"] * {width: auto!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
		table[class="col-3"],table[class="col-3-not-full"]{width:30.35%!important; max-width:100%!important;}
		table[class="col-2"]{width:47%!important; max-width:100%!important;}
		td[class="col-top"]{display:table-header-group !important;}
		td[class="col-bottom"]{display:table-footer-group !important;}
		*[class="full-block"]{width:100% !important; display:block !important; }
		/* image */
		td[class="image-full-width"] img{width:100% !important; height:auto !important; max-width:100% !important;}
		/* helper */
		table[class="space-w-20"]{width:3.5%!important; max-width:20px!important; min-width:3.5% !important;}
		table[class="space-w-20"] td:first-child{width:3.5%!important; max-width:20px!important; min-width:3.5% !important;}
		table[class="space-w-25"]{width:4.45%!important; max-width:25px!important; min-width:4.45% !important;}
		table[class="space-w-25"] td:first-child{width:4.45%!important; max-width:25px!important; min-width:4.4% !important;}
		table[class="fix-w-20"]{width:20px!important; max-width:20px!important; min-width:20px!important;}
		table[class="fix-w-20"] td:first-child{width:20px!important; max-width:20px!important; min-width:20px !important;}
		*[class="h-10"]{display:block !important;  height:10px;}
		*[class="h-20"]{display:block !important;  height:20px;}
		*[class="h-30"]{display:block !important; height:30px;}
		*[class="h-40"]{display:block !important;  height:40px;}
		*[class="remove-640"]{display:none !important;}
		*[class="text-left"]{text-align:left !important;}
		*[class="clear-pad"]{padding:0 !important;}
	}
	@media only screen and (max-width: 479px){

		table[class="container"]{width:100%!important; max-width:100%!important; min-width:124px!important;
			padding-left:15px!important; padding-right:15px!important; text-align: center!important; clear: both;}
			td[class="container"]{width:100%!important; padding-left:15px!important; padding-right:15px!important; text-align: center!important; clear: both;}
			table[class="full-width"]{width:100%!important; max-width:100%!important; min-width:124px!important; clear: both;}
			table[class="full-width-center"] {width: 100%!important; max-width:100%!important; min-width:124px!important; text-align: center!important; clear: both; margin:0 auto; float:none;}
			*[class="auto-center-all"]{width: 100%!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
			*[class="auto-center-all"] * {width: auto!important; max-width:100%!important;  text-align: center!important; clear: both; margin:0 auto; float:none;}
			table[class="col-3"]{width:100%!important; max-width:100%!important; text-align: center!important; clear: both;}
			table[class="col-3-not-full"]{width:30.35%!important; max-width:100%!important; }
			table[class="col-2"]{width:100%!important; max-width:100%!important; text-align: center!important; clear: both;}
			*[class="full-block-479"]{display:block !important; width:100% !important; text-align: center!important; clear: both; }

			td[class="image-full-width"] img{width:100% !important; height:auto !important; max-width:100% !important; min-width:124px !important;}
			td[class="image-min-80"] img{width:100% !important; height:auto !important; max-width:100% !important; min-width:80px !important;}
			td[class="image-min-100"] img{width:100% !important; height:auto !important; max-width:100% !important; min-width:100px !important;}

			table[class="space-w-20"]{width:100%!important; max-width:100%!important; min-width:100% !important;}
			table[class="space-w-20"] td:first-child{width:100%!important; max-width:100%!important; min-width:100% !important;}
			table[class="space-w-25"]{width:100%!important; max-width:100%!important; min-width:100% !important;}
			table[class="space-w-25"] td:first-child{width:100%!important; max-width:100%!important; min-width:100% !important;}
			*[class="remove-479"]{display:none !important;}

		}
		td ul{list-style: initial; margin:0; padding-left:20px;}.default-edit-image{height:20px;} tr.tpl-repeatblock , tr.tpl-repeatblock > td{ display:block !important;} .tpl-repeatblock {padding: 0px !important;border: 1px dotted rgba(0,0,0,0.2);}</style>
	</head>
	<body  style="font-size:12px; width:100%; height:100%;">
		<table id="mainStructure" style="width: 100%; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td align="center" class="container" valign="top" style="background-color: #eaeaf1;">
						<table class="full-width" style="margin: 0px auto; width: 600px; min-width: 600px; background-color: #eaeaf1;" border="0" cellspacing="0" cellpadding="0" align="center">
							<tbody>
								<tr>
									<td height="15" valign="top" style="line-height: 1px; font-size: 1px;"></td>
								</tr>
								<tr>
									<td valign="middle">
										<table class="full-width-center" style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="center">
											<tbody>
												<tr>
													<td valign="top">
														<table class="full-width" style="width: 20px; height: 1px; border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" border="0" cellspacing="0" cellpadding="0" align="left">
															<tbody>
																<tr>
																	<td height="1" class="h-20" style="border-collapse: collapse; line-height: 1px; font-size: 1px;"></td>
																</tr>
															</tbody>
														</table>
														<!--[if (gte mso 9)|(IE)]></td><td valign="top"><![endif]-->
														<table class="full-width-center" style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="left">
															<tbody>
																<tr>
																	<td valign="top">
																		<table class="full-width-center" style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="left">
																			<tbody>
																				<tr>
																					<td align="center" valign="top">
																						<a style="font-size: inherit; text-decoration: none;" href="http://muller-nvbe.webhosting.be">
																							<img style="max-width: 150px; display: block !important;" src="http://muller-nvbe.webhosting.be/wp-content/uploads/2018/01/logo-3.jpg" alt="logo-top" width="150" border="0" hspace="0" vspace="0" />
																						</a>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>

													</td>
												</tr>
											</tbody>
										</table>
									</td>		
								</tr>
								<tr>
									<td height="15" valign="top" style="line-height: 1px; font-size: 1px;"></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>


			<tbody>
				<tr>
					<td align="center" class="container" valign="top" style="background-color: #ffffff;">
						<table class="full-width" style="margin: 0px auto; width: 600px; min-width: 600px; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0" align="center">
							<tbody>
								<tr>
									<td valign="top">
										<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="center">
											<tbody>
												<tr>
													<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>
												</tr>
												<tr>
													<td align="left" valign="top">
														<h2 style="font-size: 20px; line-height: 24px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">
															Beste beheerder,
														</h2>
													</td>
												</tr>
												<tr>
													<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>
												</tr>
												<tr>
													<td align="left" valign="top">
														<p style="font-size: 16px; line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">
															Volgende offerte aanvraag is zonet ontvangen. Zie de bijlage voor meer details.
														</p>
													</td>
												</tr>
												<tr>
													<td height="30" valign="top" style="line-height: 1px; font-size: 1px;"></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>

			<!-- <tbody>
				<tr>
					<td align="center" class="container" valign="top" style="background-color: #ffffff;">
						<table  class="full-width" style="margin: 0px auto; width: 600px; max-width: 600px; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0" align="center">
							<tbody style="line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">
								
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										ID:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										firstname:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										lastname:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										email:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										bedrijf:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										functie:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										telefoon:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										mobiel:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										adres:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										postcode:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										gemeente:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										geslacht:
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
								</tr>

								<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>

								<tr>
									<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>
									<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>
									<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody> -->

			<!-- <tbody>
				<tr>
					<td align="center" class="container" valign="top" style="background-color: #ffffff;">
						<table  class="full-width" style="margin: 0px auto; width: 600px; max-width: 600px; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0" align="center">
							<tbody style="line-height: 16px; color: #000; font-weight: normal; text-align: left; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										Artikelnummer
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Titel
									</td>
									<td valign="top" style="margin: 0px auto; width: 50px; min-width: 50px;">
										Aantal
									</td>
								</tr>
								<tr>
									<td valign="top" height="20" style="line-height: 1px; margin: 0px auto;"></td>
									<td valign="top" height="20" style="line-height: 1px; margin: 0px auto;"></td>
									<td valign="top" height="20" style="line-height: 1px; margin: 0px auto;"></td>
								</tr>
								<tr style="font-size: 16px;">
									<td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;">
										12-1345-12
									</td>
									<td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;">
										Lorem ipsum dolor sit amet
									</td>
									<td valign="top" style="margin: 0px auto; width: 50px; min-width: 50px;">
										12
									</td>
								</tr>

								<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>
								<tr style="font-size: 16px;"> <td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;"> 12-1345-12 </td> <td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;"> Lorem ipsum dolor sit amet </td> <td valign="top" style="margin: 0px auto; width: 50px; min-width: 50px;">12</td> </tr>
								<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>
								<tr style="font-size: 16px;"> <td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;"> 12-1345-12 </td> <td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;"> Lorem ipsum dolor sit amet </td> <td valign="top" style="margin: 0px auto; width: 50px; min-width: 50px;">12</td> </tr>
								<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>
								<tr style="font-size: 16px;"> <td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;"> 12-1345-12 </td> <td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;"> Lorem ipsum dolor sit amet </td> <td valign="top" style="margin: 0px auto; width: 50px; min-width: 50px;">12</td> </tr>
								<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>
								<tr style="font-size: 16px;"> <td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;"> 12-1345-12 </td> <td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;"> Lorem ipsum dolor sit amet </td> <td valign="top" style="margin: 0px auto; width: 50px; min-width: 50px;">12</td> </tr>
								<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>
								<tr style="font-size: 16px;"> <td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;"> 12-1345-12 </td> <td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;"> Lorem ipsum dolor sit amet </td> <td valign="top" style="margin: 0px auto; width: 50px; min-width: 50px;">12</td> </tr>
								<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>
								<tr style="font-size: 16px;"> <td valign="top" style="margin: 0px auto; width: 150px; min-width: 150px;"> 12-1345-12 </td> <td valign="top" style="margin: 0px auto; width: 400px; min-width: 400px;"> Lorem ipsum dolor sit amet </td> <td valign="top" style="margin: 0px auto; width: 50px; min-width: 50px;">12</td> </tr>
								<tr> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> <td valign="top" height="5" style="line-height: 1px; margin: 0px auto;"></td> </tr>
								
								<tr>
									<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>
									<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>
									<td valign="top" height="30" style="line-height: 1px; margin: 0px auto;"></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody> -->

			<!-- THE ABOVE WILL BE REPLACED BY THE BODY -->

			<span mc:edit="main">
				
			</span>

			<tbody>
				<tr>
					<td align="center" class="container" valign="top" style="background-color: #ffffff;">
						<table class="container" style="margin: 0px auto; width: 600px; min-width: 600px; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0" align="center">
							<tbody>
								<tr>
									<td height="20" valign="top" style="line-height: 1px; font-size: 1px;"></td>
								</tr>
								<tr>
									<td align="center" valign="top">
										<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0" align="center">
											<tbody>
												<tr>
													<td valign="middle">
														<table class="full-width-center" border="0" cellspacing="0" cellpadding="0" align="center">
															<tbody>
																<tr>
																	<td align="center" style="font-size: 14px; line-height: 24px; color: #959398; font-weight: normal; text-align: center; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">
																		<span style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;">
																			<a style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;" href="#">Multraco NV</a>
																			- 
																			<a style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;" href="#">Privacy Policy</a>
																			- 
																			<a style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;" href="#">Cookie Policy</a>
																		</span>
																	</td>
																</tr>
															</tbody>
														</table>
														<table class="full-width" style="width: 20px; height: 1px; border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" border="0" cellspacing="0" cellpadding="0" align="left">
															<tbody>
																<tr>
																	<td height="1" class="h-20" style="border-collapse: collapse; line-height: 1px; font-size: 1px;"></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td valign="middle">
														<table class="full-width-center" border="0" cellspacing="0" cellpadding="0" align="center">
															<tbody>
																<tr>
																	<td align="center" style="font-size: 14px; line-height: 24px; color: #959398; font-weight: normal; text-align: center; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">
																		<span style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;">
																			<a style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;" href="#">muller-nv.be</a>
																			- 
																			<a style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;" href="#">Industrieweg 19 2320 Hoogstraten </a>
																			- 
																			<a style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;" href="#">+32 3 314 72 40</a>
																		</span>
																	</td>
																</tr>
															</tbody>
														</table>
														<table class="full-width" style="width: 20px; height: 1px; border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" border="0" cellspacing="0" cellpadding="0" align="left">
															<tbody>
																<tr>
																	<td height="1" class="h-20" style="border-collapse: collapse; line-height: 1px; font-size: 1px;"></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td valign="middle">
														<table class="full-width-center" border="0" cellspacing="0" cellpadding="0" align="center">
															<tbody>
																<tr>
																	<td align="center" style="font-size: 14px; line-height: 24px; color: #959398; font-weight: normal; text-align: center; font-family: Arial, Helvetica, sans-serif; word-break: break-word;">
																		<span style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;">
																			<a style="color: #959398; font-size: 14px; text-decoration: none; line-height: 24px;" href="#">Copyright © Muller NV</a>
																		</span>
																	</td>
																</tr>
															</tbody>
														</table>
														<table class="full-width" style="width: 20px; height: 1px; border-spacing: 0; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" border="0" cellspacing="0" cellpadding="0" align="left">
															<tbody>
																<tr>
																	<td height="1" class="h-20" style="border-collapse: collapse; line-height: 1px; font-size: 1px;"></td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td height="20" valign="top" style="line-height: 1px; font-size: 1px;"></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
	</html>