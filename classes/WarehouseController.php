<?php
/*
** object oriented class to handle data input and output from the database
** its the mainclass, because the class manages almost all the information
** transfer from frontend to backend and backwards
*/

class WarehouseController implements WarehouseControllerInterface
{
	/*
	** the DBConnection works as a singleton from the DBconnection class
	*/
	private $DBConnection = Null;
	
	public function __construct()
	{
			$this->DBConnection =  DBConnection::getInstance();
	}
	/*
	** this method manipulates the stock of the item in the Warehouse_has_Item table
	*/
	public function ManipulateItemAmount($Item_ID, $Amount, $Type, $Warehouse_ID)
	{
		/*
		** all the prepared statements work the same way, you need the query where with
		** the values you want to change and the same number of parameters in an array
		*/
		$param1= $Amount;
		$param2= $Item_ID;
		$param3= $Warehouse_ID;
		$bindParams= array(&$param1,&$param2,&$param3);
		if ($Type == true)
		{
			$query="Update 
						[LagerDatenbank].[dbo].[Warehouse_has_Item]
					Set 
						[Warehouse_has_Item].[Amount] = [Warehouse_has_Item].[Amount] + ? 
					Where 
						[Warehouse_has_Item].[Item_ID] =? And [Warehouse_has_Item].[Warehouse_ID]=?";
			}
		else 
		{
			$query="Update 
						[LagerDatenbank].[dbo].[Warehouse_has_Item]
					Set 
						[Warehouse_has_Item].[Amount] = [Warehouse_has_Item].[Amount] - ?
					Where
						[Warehouse_has_Item].[Item_ID] =? And [Warehouse_has_Item].[Warehouse_ID] = ?";
		}	
		
		$this->DBConnection->executeQueryPrepared($query,$bindParams);
	}
	/*
	**this method inserts a new item into the table Item_Directory table and inserts the item into the crosstable Warehouse_has_Item with an amount of zero  
	*/
	public function InsertNewItem($Itemobject,$Warehouse_ID)
	{
		/*
		** in array $bindparams we collect all the necessary parameter ($param1,...,paramN)for the execution of the prepared statement 
		*/
		$param1= $Itemobject->getItem_NR();
		$param2= $Itemobject->getName();
		$param3= $Itemobject->getEAN();
		$param4= $Itemobject->getComment();
		$bindParams= array(&$param1,&$param2, &$param3,&$param4);
		/*
		** the query first checks if the name and the Item_NR are already in the database, if this is the case no insert command will follow
		** name & Item_NR are also a unique identifier and the item_ID isnt created yet
		*/
		$query=	"BEGIN
					IF NOT EXISTS (SELECT * FROM [LagerDatenbank].[dbo].[Item_Directory]
				WHERE 
					[Item_Directory].[Name] = '".$Itemobject->getName()."' AND [Item_Directory].[Item_NR]='".$Itemobject->getItem_NR()."')
				BEGIN
					INSERT INTO [LagerDatenbank].[dbo].[Item_Directory] 
						([Item_Directory].[Item_NR],[Item_Directory].[Name],[Item_Directory].[EAN],[Item_Directory].[Comment])
					VALUES
					(?, ?, ?, ?)
				END
		END " ;
		$this->DBConnection->executeQueryPrepared($query,$bindParams);
		/*
		** get the Item_ID from the newly created item
		*/
		$query="SELECT 
					Item_ID
				FROM [LagerDatenbank].[dbo].[Item_Directory]
		WHERE [Item_Directory].[Name] = '".$Itemobject->getName()."'";
		$getID= $this->DBConnection->sqlToAssocArray($query);
		$Itemobject->setItemID($getID[0]['Item_ID']);
		/*
		** then we add the item with an amount of zero into the warehouse_has_item table
		*/
		$newParam1 = $Warehouse_ID;
		$newParam2 = $Itemobject->getItemID();
		$newParam3 = '0';
		$bindParams2= array(&$newParam1,&$newParam2, &$newParam3);		
		$query2="INSERT INTO 
					[LagerDatenbank].[dbo].[Warehouse_has_Item]
				Values (?, ?, ?)";
		$this->DBConnection->executeQueryPrepared($query2,$bindParams2);
	}
	/*
	** this method shows the stock of an item and some additional infos about the item
	*/
	public function ShowStock($Warehouse_ID)
	{
		$query="Select 
					[Item_Directory].[Item_ID],[Item_Directory].[Item_NR], [Item_Directory].[Name],[Item_Directory].[EAN],[Warehouse_has_Item].[Amount]
				FROM
					[LagerDatenbank].[dbo].[Item_Directory]
				INNER JOIN
					[LagerDatenbank].[dbo].[Warehouse_has_Item] ON [Item_Directory].[Item_ID]=[Warehouse_has_Item].[Item_ID]
				WHERE Warehouse_ID = ".$Warehouse_ID."";
		$array= $this->DBConnection->sqlToAssocArray($query);
		return $array;
	}
	/*
	** this method deletes an item with t
	*/
	function DeleteItem($ID)
	{
		/*
		** deletes Item with the passed ID
		*/
		$query="DELETE From [LagerDatenbank].[dbo].[Item_Directory] WHERE Item_ID =".$ID." ";
		$this->DBConnection->executeQuery($query);
	}
	/*
	** this method shows all the deliverys going into or coming the specified Warehouse
	*/
	public function TrackDelivery($Warehouse_ID)
	{
		
		$query= "Select 
					[Delivery].[Deliveryreceipt] AS LieferscheinNummer, [Delivery].[Kind_of_Delivery] AS Art,[Warehouse_Directory].[Warehouse_Name] AS Lager, [Delivery].[Date] AS Datum,[Customer_Directory].[Company_Name] AS Kunde,[Delivery].[Comment] AS Bemerkung,[Delivery].[Document] AS Dokumentlink
				FROM
					[LagerDatenbank].[dbo].[Delivery]
				INNER JOIN
					[LagerDatenbank].[dbo].[Customer_Directory] ON [Delivery].[Customer_ID]=[Customer_Directory].[Customer_ID]
				INNER JOIN
					[LagerDatenbank].[dbo].[Warehouse_Directory] ON [Warehouse_Directory].[Warehouse_ID]=[Delivery].[Warehouse_ID] 
				WHERE [Delivery].[Warehouse_ID] = ".$Warehouse_ID."
				ORDER BY [Delivery].[Date] DESC
				";
		$array= $this->DBConnection->sqlToAssocArray($query);
		return $array;
	}
	public function AddDelivery($Delivery)
	{
		/*
		** first insert all the data about the delivery in the table Delivery
		*/
		$param1= $Delivery->getDeliveryreceipt();
		$param2= $Delivery->getCustomer();
		$param3= $Delivery->getWarehouse_ID();
		$param4= $Delivery->getKind_of_Delivery();
		$param5= $Delivery->getDate();
		$param6= $Delivery->getComment();
		$param7= $Delivery->getDocument();
		$bindParams= array(&$param1,&$param2, &$param3,&$param4,&$param5,&$param6,&$param7);
		$query = "	Insert Into
						[LagerDatenbank].[dbo].[Delivery]([Delivery].[Deliveryreceipt],[Delivery].[Customer_ID],[Delivery].[Warehouse_ID],[Delivery].[Kind_of_Delivery],[Delivery].[Date],[Delivery].[Comment],[Delivery].[Document])
					Values
						(?,?,?,?,?,?,?)";
		$this->DBConnection->executeQueryPrepared($query,$bindParams);
		
		/*
		** 2. step we insert the $Amount and the Item_ID into the Delivery_has_Item Datatable  
		*/
		for($i=1;$i<=(count($Delivery->getProductAndAmount()))/2; $i++)
		{
			$param1 = $Delivery->getDeliveryreceipt();
			$param2ToTrans = $Delivery->getProductAndAmount();
			$param2 = $param2ToTrans['Item'.$i];
			if($Delivery->getKind_of_Delivery() == "Eingehend")
			{
				$param3 = $Delivery->getProductAndAmount()['ItemAmount'.$i];
			}
			else
			{
				$param3 = ($Delivery->getProductAndAmount()['ItemAmount'.$i]) * (-1);
			}
			$bindParams= array(&$param1,&$param2, &$param3);		
			$query2 = "	Insert Into [LagerDatenbank].[dbo].[Delivery_has_Item]
							([Delivery_has_Item].[Deliveryreceipt],[Delivery_has_Item].[Item_ID],[Delivery_has_Item].[Amount])
						Values
							(?,?,?)";
			$this->DBConnection->executeQueryPrepared($query2,$bindParams);
		}
		/*
		** 3. step if he delivery goes into the warehouse, we have to add the amount to the amount that is already in the database
		** in the opposite case we have to subtrate the amount
		*/
		if($Delivery->getKind_of_Delivery() == "Eingehend")
		{
			$Type= true;
		}
		else
		{
			$Type = false;
		}
		
		for($i=1;$i<=(count($Delivery->getProductAndAmount()))/2; $i++)
		{
			$this->ManipulateItemAmount($Delivery->getProductAndAmount()['Item'.$i],$Delivery->getProductAndAmount()['ItemAmount'.$i],$Type, $Delivery->getWarehouse_ID());
		}
	}
	/*
	** this method shows all the items contained by delivery with a deliveryreceipt
	*/
	public function ShowItemsByDeliveryreceipt($Deliveryreceipt)
	{
		$query= "Select 
					[Delivery_has_Item].[Item_ID],[Item_Directory].[Name] ,[Delivery_has_Item].[Amount] AS Menge,[Delivery].[Date], [Delivery].[Kind_of_Delivery] AS Art
				FROM
					[LagerDatenbank].[dbo].[Delivery_has_Item]
				INNER JOIN
					[LagerDatenbank].[dbo].[Delivery] ON [Delivery].[Deliveryreceipt]=[Delivery_has_Item].[Deliveryreceipt]
				INNER JOIN
					[LagerDatenbank].[dbo].[Item_Directory] ON [Delivery_has_Item].[Item_ID]=[Item_Directory].[Item_ID]
				WHERE [Delivery].[Deliveryreceipt]= ".$Deliveryreceipt."
				";
		$array= $this->DBConnection->sqlToAssocArray($query);
		return $array;
	}
}
?>
