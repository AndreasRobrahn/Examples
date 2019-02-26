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
** backToStart is a metatag that sends you back to index.php after the every request
**
*/
$backToStart='<meta http-equiv="refresh" content="0 URL=index.php">';
switch($_POST)
{
	
	case(!isset($_POST)):
	break;
	case(isset($_POST['Deliveryreceipt'])):
	/*
	** frist step, we separate the information of $_POST into to separate arrays, one for Item ID and Amount(aka ProductInformation) and one for Information about the delivery(self explainatory)
	*/
		$arrayOfConditions= array_keys($_POST);
		for($i=0;$i <=(count($_POST)-1); $i++)
		{
			if ((stristr($arrayOfConditions[$i], 'Item') === false) )
			{
				$DeliveryInformation[$arrayOfConditions[$i]]=$_POST[$arrayOfConditions[$i]];
			}	
			else
			{
				$ProductInformation[$arrayOfConditions[$i]]= $_POST[$arrayOfConditions[$i]];
			}
		}
		if (!isset($_FILES))
			{
				$document = NULL;
			}	
		else
			{
				$document = $_FILES['Document']['tmp_name'];
				$newFilename= $_FILES['Document']['name'];
			}
		$dir ="Belege/";
		$nextDelivery= new Delivery($DeliveryInformation['Deliveryreceipt'],$DeliveryInformation['Kind_of_Delivery'],$DeliveryInformation['Date'], $DeliveryInformation['Customer_ID'],$DeliveryInformation['Warehouse_ID'],$DeliveryInformation['Comment'],$newFilename,$ProductInformation);
		$WarehouseController->addDelivery($nextDelivery);
		$upload = move_uploaded_file($document,$dir.$newFilename);
		if (($document!= NULL) && (!$upload))
		{
			echo(' Datei konnte nicht eingefügt werden');
		}
	break;
	/**
	** case to insert a new item to the warehouse
	*/
	case (isset($_POST['Name']) && isset($_POST['Artikel_NR']) && isset($_POST['EAN'])&& isset($_POST['Bemerkung'])):
		$Item = new ItemInStock(NULL,$_POST['Artikel_NR'],$_POST['Name'], $_POST['EAN'],$_POST['Bemerkung']);
		$WarehouseController->InsertNewItem($Item, $WarehouseFlensburg->getWarehouse_ID());
	break;
	/*
	** case to delete an Item from the warehouse
	**
	*/
	case(isset($_POST['ID_Manipulate'])):
		if ($_POST['type'] === 'add')
		{
			$type= true;
		}
		else
		{
			$type=false;
		}
		$WarehouseController->ManipulateItemAmount($_POST['ID_Manipulate'],$_POST['Amount'],$type,$WarehouseFlensburg->getWarehouse_ID());
	break;
	case(isset($_POST['Item_ID'])):
		$WarehouseController->DeleteItem($_POST['Item_ID'],$WarehouseFlensburg->getWarehouse_ID() );
	break;
	/*
	** in this section we instantiate a Customer Class and insert it into the database via the insertCustomer method_exists
	*/
	case(isset($_POST['Company_Name'])):
		$newCustomer = new Customer($_POST['Company_Name'],$_POST['Contact_Telefone'],$_POST['Contact_Email'],$_POST['Zip_Code'],$_POST['Straße'],$_POST['City']);
		$CustomerController->insertNewCustomer($newCustomer);
	break;
	case(isset($_POST['Delete_Customer_ID'])):
		$CustomerController->deleteCustomerByID($_POST['Delete_Customer_ID']);
	break;
	
}
echo $backToStart;

?>