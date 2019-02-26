<?php
/*
object oriented  class to get data into a database
its the mainclass, because the class manages almost all the information transfer from frontend to backend and backwards

*/

interface WarehouseControllerInterface 
{
	
	public function ManipulateItemAmount($Item_ID, $Amount, $Type,$Warehouse_ID);
	public function InsertNewItem($Itemobject,$Warehouse_ID);
	public function ShowStock($Warehouse_ID);
	public function DeleteItem($ID);
	public function TrackDelivery($Warehouse_ID);
	public function AddDelivery($Delivery);
	public function ShowItemsByDeliveryreceipt($Deliveryreceipt);
	
}
?>
