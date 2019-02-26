<?php

interface Warehouse
{
	
	public function ShowStock();
	public function DeleteItem($artikelBezeichnung);
	public function InsertNewItem($productobjekt);
	public function ManipulateItemAmount($artikel,$menge, $Art);
	public function AddDelivery($deliveryobject);
	public function HistoriePflegen();
	public function HistorieAnzeigen();
	public function TrackDelivery();
}
?>