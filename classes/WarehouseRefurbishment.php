<?php
class WarehouseRefurbishment
{
	private $Name="Lager Contevis GmbH - Refurbishment";
	private $Warehouse_ID= 1;
	private $Zip_Code ="24937";
	private $Street ="Rudolf-Diesel Str.3";
	private $City = "Flensburg";
	
	public function getName()
	{
		return $this->Name;
	}
	public function setName($Name)
	{
		$this->Name= $Name;
	}
	public function getWarehouse_ID()
	{
		return $this->Warehouse_ID;
	}
	public function setWarehouseID($WarehouseID)
	{
		$this->WarehouseID= $WarehouseID;
	}
	public function getZip_Code()
	{
		return $this->Zip_Code;
	}
	public function setZip_Code($Zip_Code)
	{
		$this->Zip_Code= $Zip_Code;
	}
	public function getStreet()
	{
		return $this->Street;
	}
	public function setContact_Email($Street)
	{
		$this->Street= $Street;
	}
	public function getCity()
	{
		return $this->City;
	}
	public function setCity($City)
	{
		$this->City= $City;
	}
}
?>