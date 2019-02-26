<?php

// die LagerProdukt Klasse ist sehr simpel, da sie nur beschreibende Attribute enthält

class ItemInStock 
{
	
	private $Item_ID;
	private $Item_NR;
	private $Name;
	private $EAN;
	private $Comment;

	function __construct($Item_ID,$Item_NR,$Name,$EAN,$Comment)
	{
		$this->Item_ID = $Item_ID;
		$this->Item_NR = $Item_NR;
		$this->Name = $Name;
		$this->EAN = $EAN;
		$this->Comment= $Comment;
	}
	function getItemID()
	{
		return $this->Item_ID;
	}
	function setItemID($Item_ID)
	{
		$this->Item_ID= $Item_ID;
	}
	function getItem_NR()
	{
		return $this->Item_NR;
	}
	function setItem_NR($Item_NR)
	{
		$this->Item_NR= $Item_NR;
	}
	function getName()
	{
		return $this->Name;
	}
	function setName($Name)
	{
		$this->Name= $Name;
	}
	function getEAN()
	{
		return $this->EAN;
	}
	function setEAN($EAN)
	{
		$this->EAN= $EAN;
	}
	function getComment()
	{
		return $this->Comment;
	}
	function setComment($Comment)
	{
		$this->Comment= $Comment;
	}
}


?>