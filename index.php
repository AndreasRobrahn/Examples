<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Webbasierter Support für das Lager</title>
	<!-- Bootstrap core CSS-->
	<link href="csss/startbootstrap-sb-admin-gh-pages/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom fonts for this template-->
	<link href="csss/startbootstrap-sb-admin-gh-pages/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Page level plugin CSS -->
	<link href="csss/startbootstrap-sb-admin-gh-pages/vendor/datatables/daraTables.bottstrap4.css" rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="csss/startbootstrap-sb-admin-gh-pages/css/sb-admin.css" rel="stylesheet">
	<!-- Javascript functions-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/java.js"></script>
</head>
<body id ="page-top" class="fixed-nav sticky-footer bg-dark">
 <nav id="mainNav" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">Contevis GmbH - Lagerverwaltung</a>
	<div id="navbarResponsive" class="collapse navbar-collapse">
		<ul id="exampleAccordion" class="navbar-nav navbar-sidenav">
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Lagerverwaltung">
				<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
					<span class="nav-link-text">Lagerverwaltung</span>
				</a>
				<ul class="sidenav-second-level collapse" id="collapseMulti">
					<li>
						<a class="nav-link" href="index.php?Lagereinsicht">Lager einsehen </a>
					</li>
					<li>
						<a href="index.php?Artikel_anlegen">Neuen Artikel einpflegen </a>
					</li>
					<li>
						<a href="index.php?Artikel_löschen">Artikel löschen </a>
					</li>
					<li>
						<a class="nav-link" href="index.php?ArtikelMenge_ändern">Menge einzelner Artikel ändern </a>
					</li>
				</ul>
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Lieferungsverwaltung">
				<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti2" data-parent="#exampleAccordion" aria-expanded="true">Lieferungsverwaltung </a>
				<ul class="sidenav-second-level collapse" id="collapseMulti2">
					<li>
						<a href="index.php?Lieferung_verfolgen"> Lieferungen verfolgen</a>
					</li>
					<li>
						<a href="index.php?Lieferung_anlegen"> Lieferung anlegen</a>
					<li>
						<a href="index.php?Lieferscheinnummer=0"> Artikel einer Lieferung einsehen nach ID</a>
					</li>
					</li>
				</ul>
			</li>
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Kunde">
				<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti3" data-parent="#exampleAccordion" aria-expanded="true">Kunde</a>
				<ul class="sidenav-second-level collapse" id="collapseMulti3">
					<li>
						<a href="index.php?Kundenverzeichnis">Kundenverzeichnis</a>
					</li>
					<li>
						<a href="index.php?Kunden_anlegen">Kunden anlegen</a>
					</li>
					<li>
						<a href="index.php?Kunden_löschen">Kunden löschen</a>
					</li>
				</ul>
			</li>
		</ul>	
	</div>
</nav>
<div class="content-wrapper">
	<div class="container-fluid">
		<div class="card-body">
			<div class="table-responsive">
				<div id="dataTable-wrapper" class="dataTAbles_wrapper container-fluid dt-bootstrap4">
				</div>	
			<?php
				defined('BASEPATH') or define('BASEPATH', realpath(dirname(__FILE__)));
				// Require autoloader
				require_once(BASEPATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
				function getConfig()
				{
					return require(BASEPATH . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php");
				}
				$WarehouseFlensburg= new WarehouseRefurbishment();
				$WarehouseController = new WarehouseController();
				$CustomerController = new CustomerController();
				/*
				** the standartbootstraptable gives us an preseleceted html-table, with an associative array
				** the closing part of he table is cut off, 
				*/
				function standartBootstrapTable($array)
				{
					/*
					** $output is the string we attach every following html
					**
					*/
					$output="";
					$output.= 
						'<div class="table-responsive">
							<table class="table table-hover table-striped tablesorter">
								<thead>
							<tr>';
							for($i=0;$i<=(count(array_keys($array[0]))-1);$i++)
							{
								$output.= '<th class="header">'.(array_keys($array[0])[$i]).'</th>';
							}
							$output.= '</tr></thead></tbody>';
							for ($i=0; $i<=(count($array)-1);$i++)
							{
								$output.= '<tr>';
								$firstDimension= $array[$i];
								$associativeKeys= array_keys($firstDimension);
								for($j=0; $j <= (count($firstDimension)-1);$j++)
								{
									$output.= '<td>'.$firstDimension[$associativeKeys[$j]].'</td>';
								}
								
							}
					$output.= '</tr>';
					$output.= '</tbody></table></div>';
					return $output;
				}
				/*
				** the switch generates the view, dependant on the Get Index
				*/
				switch ($_GET)
				{		
					default:
						echo 'default';
					break;
					case(!isset($_GET)):
					break;
					// sektion: shows the inventory off the current storage
					case(isset($_GET["Lagereinsicht"])):
						
						$result = $WarehouseController->showStock($WarehouseFlensburg->getWarehouse_ID());
						$output = '<h2> Lagereinsicht </h2>';
						$output.= standartBootstrapTable($result);
						echo $output;
						//der zweite switch wird eingebaut damit wir auf der Lagersektion(index.php?Lager) bleiben aber trotzdem weiterhin Daten über $_POST einpflegen können						
					break;
					//sektion: this section holds the formular for the input of a new storage product
					case(isset($_GET['Artikel_anlegen'])):
					$sectionform= 
					'
					<div class="container">
								<div class="card card-columns">
									<div class="card-header">Einen Neuen Artikel anlegen
									</div>
									<div class="card-body">
										<form action="logic.php"  method="POST">
											<div class="form-group">
												<div class="form-row">
													<div class="col-md-6">
														<label> Artikel Name </label>
														<input class="form-control" placeholder="Artikel Name" "text" name="Name" required>
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-6">
														<label> Artikel Nummer </label>
														<input class="form-control" placeholder="Artikelnummer" "text" name="Artikel_NR">
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-6">
														<label> EAN</label>
														<input class="form-control" type="text" name="EAN" required>  
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-6">
														<label> Bemerkung</label>
														<input class="form-control" type="text" name="Bemerkung">  
													</div>
												</div>
											</div>
										<button class="btn btn-primary" type="submit"> Okay</button>
										</form>
									</div>
								</div>
							</div>';
					echo $sectionform ;	
					break;
					//sektion 1.3 this sektion is supposed to the give the formular to delete an article from the storage unit completly
					case (isset($_GET['Artikel_löschen'])):
					$sectionform='
						<div class="container">
							<div class="card card-columns">
								<div class="card-header">Artikel löschen
								</div>
								<div class="card-body">
									<form action="logic.php"  method="POST">
										<div class="form-group">
											<div class="form-row" id="step0">
												<div class="col-md-6">
													<label> Artikel_ID </label>
													<input class="form-control" placeholder="bitte Artikel ID eingeben" type="text" name="Item_ID" >
												</div>
											</div>
											<button class="btn btn-primary" type="submit"> okay</button>
									</form>	
							</div>
						</div>';
					echo $sectionform;	
					break;
					/*
					** This sektion has the formular to change the  
					**
					*/
					case (isset($_GET['ArtikelMenge_ändern'])):
						$sectionform=' 
							<div class="container">
								<div class="card card-columns">
									<div class="card-header">Artikel_Menge ändern
									</div>
									<div class="card-body">
										<form action="logic.php"  method="POST">
											<div class="form-group">
												<div class="form-row" id="step0">
													<div class="col-md-6">
														<label> Artikel_ID </label>
														<input class="form-control" placeholder="Artikel_ID" type="text" name="ID_Manipulate" >
													</div>
												</div>
												<div class="form-row" id="step1">
													<div class="col-md-6">
														<label> Menge</label>
														<input class="form-control" type="number" name="Amount">  
													</div>
												</div>
											</div>
										<button class="btn btn-primary" type="submit" name="type" value="add"> Addieren</button>
										<button class="btn btn-primary" type="submit" name="type"value="minus"> Subtrahieren</button>
										</form>
									</div>
								</div>
							</div>';
						echo $sectionform;
					break;
					/*
					** In this section u can insert a new delivery, required are Deliveryreceipt, 
					*/
					case(isset($_GET['Lieferung_anlegen']) && !empty($_GET)):
						$sectionform=' 
							<div class="container">
								<div class="card card-columns">
									<div class="card-header">Eine neue Lieferung anlegen
									</div>
									<div class="card-body">
										<form action="logic.php"  method="POST" enctype="multipart/form-data">
											<div class="form-group">
												<div class="form-row" id="part1">
													<div class="col-md-6">
														<label> Lieferscheinnummer </label>
														<input class="form-control" placeholder="Lieferscheinummer" type="text" name="Deliveryreceipt" required>
													</div>
													<div id="Item_Information1" class="col-md-6">
														<label> Artikel 1 </label>
															<input id="" class="form-control" placeholder="Produkt ID z.B. 1" type="text" name="Item1" required>
														<label> Menge </label>
															<input id="" class="form-control" placeholder="Menge des Artikels" type="text" name="ItemAmount1" required>
													</div>
												</div>
												<div class="form-row" id="part2">
													<div class="col-md-6">
														<label>
															Art der Lieferung
														</label>
														<select class="form-control" name="Kind_of_Delivery">
															<option>Eingehend</option>
															<option>Ausgehend</option>
														</select>
													</div>
												</div>
												<div class="form-row" id="part3">
													<div class="col-md-6">
														<label> Kunde_ID </label>
														<input id="" class="form-control" value="1" name="Customer_ID" type="number" required>
													</div>
												</div>
												<div class="form-row" id="part4">
													<div class="col-md-6">
														<label> Lager_ID </label>
														<input id="" class="form-control" value="1" name="Warehouse_ID" type="number" required>
													</div>
												</div>
												<div class="form-row" id="part5">
													<div class="col-md-6">
														<label> Datum </label>
														<input id="" class="form-control" placeholder="" name="Date" type="date" required>
													</div>
												</div>
												<div class="form-row" id="part6">
													<div class="col-md-6">
														<label> Bemerkung </label>
														<input id="" class="form-control" placeholder="" name="Comment" type="text">
													</div>
												</div>
												<div class="form-row" id="part7">
													<div class="col-md-6">
														<label> Lieferschein Dokument </label>
														<input id="" class="form-control" placeholder="" name="Document" type="file">
													</div>
												</div>
											</div>
										</div>
										<button class="btn btn-primary" type="submit"> OK</button>
										</form>
										<button class="btn btn-default" id="additem">Weitererer Artikel </button>
									</div>
								</div>
							</div>';
						//$sectionform.= '<hr>';
						echo $sectionform;
					break;			
					case(isset($_GET['Lieferung_verfolgen'])):
					$result = $WarehouseController->TrackDelivery(1);
					$output ="";
					$output.= 
						'<div class="table-responsive">
							<table class="table table-hover table-striped tablesorter">
								<thead>
							<tr>';
							for($i=0;$i<=(count(array_keys($result[0]))-1);$i++)
							{
								$output.= '<th class="header">'.(array_keys($result[0])[$i]).'</th>';
							}
							$output.= '</tr></thead></tbody>';
							for ($i=0; $i<=(count($result)-1);$i++)
							{
								$output.= '<tr>';
								$firstDimension= $result[$i];
								$associativeKeys= array_keys($firstDimension);
								for($j=0; $j <= (count($firstDimension)-1);$j++)
								{
									if($j == (count($firstDimension)-1) && ($firstDimension[$associativeKeys[$j]]!= NULL))
									{
										$output.= '<td><a href="Belege/'.$firstDimension[$associativeKeys[$j]].'">Lieferschein</a></td>';
									}
									else
									{
										$output.= '<td>'.$firstDimension[$associativeKeys[$j]].'</td>';
									}
									
								}
							}
					$output.= '</tr>';
					$output.= '</tbody></table></div>';
					echo $output;
						//der zweite switch wird eingebaut dam
					break;
					case(isset($_GET['Lieferscheinnummer'])):
						if($_GET['Lieferscheinnummer'] == 0)
						{
							$sectionform=' 
							<div class="container">
								<div class="card card-columns">
									<div class="card-header">Bitte Lieferscheinummer eingeben
									</div>
									<div class="card-body">
										<form action="index.php"  method="GET" enctype=multipart/form-data>
											<div class="form-group">
												<div class="form-row">
													<div class="col-md-6">
														<label> Lieferscheinnummer </label>
														<input class="form-control" placeholder="Lieferscheinummer" type="text" name="Lieferscheinnummer" required>
													</div>
												</div>
											</div>
											<button class="btn btn-primary" type="submit"> OK</button>
										</form>
									</div>
								</div>
							</div>';
							echo $sectionform;
						}	
						else
						{
							$result = $WarehouseController->ShowItemsByDeliveryreceipt($_GET['Lieferscheinnummer']);
							$output =standartBootstrapTable($result);
							echo $output;
						}	
					break;
					case(isset($_GET['Kunden_anlegen'])):
						$sectionform=
							'
							<div class="container">
								<div class="card card-columns">
									<div class="card-header">Einen neuen Kunden anlegen
									</div>
									<div class="card-body">
										<form action="logic.php"  method="POST">
											<div class="form-group">
												<div class="form-row">
													<div class="col-md-6">
														<label> 
															Name des Unternehmen
														</label>
														<input class="form-control" placeholder="z.B. Max Mustermann GmbH" type="text" name="Company_Name" required>
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-6">
														<label>
															Telefonnummer des Unternehmens
														</label>
														<input class="form-control" placeholder="z.B. 0461 123456" type="text" name="Contact_Telefone">
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-6">
														<label> 
															Kontaktemailadresse
														</label>
														<input class="form-control" name="Contact_Email" placeholder="z.B. max.mustermann@musterunternehmen.de" type="text">
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-6">
														<label> 
															Postleitzahl
														</label>
														<input id="" class="form-control" placeholder="z.B. 24939" name="Zip_Code" type="text">
													</div>
												</div>
												<div class="form-row">
													<div class="col-md-6">
														<label> 
															Straße
														</label>
														<input id="" class="form-control" placeholder="z.B. Musterstraße 23" name="Straße" type="text">
													</div>
												</div>
												<div class="form-row" id="part6">
													<div class="col-md-6">
														<label>
															Stadt
														</label>
														<input class="form-control" placeholder="z.B. Flensburg" name="City" type="text">
													</div>
												</div>
											</div>
										</div>
										<button class="btn btn-primary" type="submit"> OK</button>
										</form>
									</div>
								</div>
							</div>
							';
						echo $sectionform;
					break;
					case(isset($_GET['Kundenverzeichnis'])):
						$CustomerController = new CustomerController();
						$result = $CustomerController->ShowCustomerDirectory();
						$output=standartBootstrapTable($result);
						echo $output;
					break;
					case(isset($_GET['Kunden_löschen'])):
						$sectionform='
							<div class="container">
								<div class="card card-columns">
									<div class="card-header">Kunde löschen
									</div>
									<div class="card-body">
										<form action="logic.php"  method="POST">
											<div class="form-group">
												<div class="form-row">
													<div class="col-md-6">
														<label> ID des Kunden </label>
														<input class="form-control" placeholder="bitte die ID des Kunden eingeben, z.B. 1" type="text" name="Delete_Customer_ID" >
													</div>
												</div>
												<button class="btn btn-primary" type="submit"> okay</button>
										</form>	
								</div>
							</div>';
						echo $sectionform;	
					break;
				}									
				?>
				</div>
				<footer class="sticky footer">
					
				</footer>
			</div>
		</div>
	</div>
</div>
</body>
<!-- Bootstrap core JavaScript-->
<script src="csss/startbootstrap-sb-admin-gh-pages/vendor/jquery/jquery.min.js"></script>
<script src="csss/startbootstrap-sb-admin-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="csss/startbootstrap-sb-admin-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Page level plugin JavaScript-->
<script src="csss/startbootstrap-sb-admin-gh-pages/vendor/chart.js/Chart.min.js"></script>
<script src="csss/startbootstrap-sb-admin-gh-pages/vendor/datatables/jquery.dataTables.js"></script>
<script src="csss/startbootstrap-sb-admin-gh-pages/vendor/datatables/dataTables.bootstrap4.js"></script>
<!-- Custom scripts for all pages-->
<script src="csss/startbootstrap-sb-admin-gh-pages/js/sb-admin.min.js"></script>
<!-- Custom scripts for this page-->
<script src="csss/startbootstrap-sb-admin-gh-pages/js/sb-admin-datatables.min.js"></script>
<script src="csss/startbootstrap-sb-admin-gh-pages/js/sb-admin-charts.min.js"></script>
<script>
$(document).ready(function()
{
	var i = 2;
	$('#additem').click(function()
	{
		$('#part'+i+'').append('<div id="Item_Information'+i+'" class="col-md-6"><label> Artikel'+i+' </label><input id="" class="form-control" placeholder="Produkt ID z.B. 1" type="text" name="Item'+i+'" required><label> Menge </label><input id="" class="form-control" placeholder="Menge des Artikels" type="text" name="ItemAmount'+i+'" required><button name="remove" id ="'+i+'"class="btn btn-danger btn_remove">X</button></div>');
		i++;
	});
	$(document).on('click','.btn_remove',function()
	{
		var buttonid= $(this).attr('id');
		$('#Item_Information'+buttonid+'').remove();
		i--;
	});
});
</script>
</html>