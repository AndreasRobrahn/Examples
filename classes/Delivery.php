<?php
// die klasse leiferung soll eine Sammlung von Objekten der Klasse Lagerartikel plus eine Angabe zum Kunden sein

class Delivery
{
	//die Variable $LiefersscheinNummer enthält den Lieferschein oder die RMA Nummer, beides einmalige, identifizierbare integer 
	private $Deliveryreceipt;
	// die variable Art Beschreibt ob die Lieferung eingehend oder ausgehend ist
	private $Kind_of_Delivery;
	//Datum gibt den Tag an an dem die Lieferung ein oder ausgeht
	private $Date;
	// der Kunde gibt den Empfänger oder Absender an
	private $Customer;
	//der Beleg soll, sofern vorhanden, ein Dokument wie ein Lieferschein aus einer email oder sowas sein
	private $Document="";
	private $Comment;
	private $Warehouse_ID;
	// der Array  
	private $ProductAndAmount=array();
	//der Array alleProdukte enthält alle Objekte der Klasse LagerProdukt und bringt diese in Verbindung mit der Menge aus dem Array $_POST
	function __construct($Deliveryreceipt, $Kind_of_Delivery, $Date, $Customer,$Warehouse_ID, $Comment,$Document,$ProductAndAmount)
	{
		$this->Deliveryreceipt = $Deliveryreceipt;
		$this->Kind_of_Delivery= $Kind_of_Delivery;
		$this->Date = $Date;
		$this->Customer = $Customer;
		$this->Warehouse_ID= $Warehouse_ID;
		$this->Comment=$Comment;
		$this->ProductAndAmount = $ProductAndAmount;
		//$this->MengenInformationen = $MengenInformationen;
		$this->Document= $Document;
		
	}
	public function getDeliveryreceipt()
	{
		return $this->Deliveryreceipt;
	}
	public function setDeliveryreceipt($Deliveryreceipt)
	{
		$this->Deliveryreceipt= $Deliveryreceipt;
	}
	public function getKind_of_Delivery()
	{
		return $this->Kind_of_Delivery;
	}
	public function setKind_of_Delivery($Kind_of_Delivery)
	{
		$this->Kind_of_Delivery= $Kind_of_Delivery;
	}
	public function getDate()
	{
		return $this->Date;
	}
	public function setDate($Date)
	{
		$this->Date= $Date;
	}
	public function getCustomer()
	{
		return $this->Customer;
	}
	public function setCustomer($Customer)
	{
		$this->Customer= $Customer;
	}
	public function getDocument()
	{
		return $this->Document;
	}
	public function setDocument($Document)
	{
		$this->Document= $Document;
	}
	public function getWarehouse_ID()
	{
		return $this->Warehouse_ID;
	}
	public function setWarehouse_ID($Warehouse_ID)
	{
		$this->Warehouse_ID= $Warehouse_ID;
	}
	public function getProductAndAmount()
	{
		return $this->ProductAndAmount;
	}
	public function setProductAndAmount($ProductAndAmount)
	{
		$this->ProductAndAmount= $ProductAndAmount;
	}
	public function getComment()
	{
		return $this->Comment;
	}
	public function setComment($Comment)
	{
		$this->Comment= $Comment;
	}
	
}
?>