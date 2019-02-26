<?php

class Customer
{
	/*
	** every individual customer has a appointed ID
	** the $Company_name is self explainatory, likewise $Contact_Telefone and $Contact_Email
	** the adress is splitted into $Zip_Code f.e "24939", street f.E. "Ritterstraße 17" and the $City
	*/
	private $Customer_ID;
	private $Company_Name;
	private $Contact_Telefone;
	private $Contact_Email;
	private $Zip_Code;
	private $Street;
	private $City;
	
	public function __construct($Company_Name="",$Contact_Telefone="",$Contact_Email="",$Zip_Code="",$Street="",$City="",$Customer_ID = NULL)
	{
		$this->Customer_ID = $Customer_ID;
		$this->Company_Name = $Company_Name;
		$this->Contact_Telefone = $Contact_Telefone;
		$this->Contact_Email = $Contact_Email;
		$this->Zip_Code = $Zip_Code;
		$this->Street = $Street;
		$this->City = $City;
	}
	
	public function getCustomer_ID()
	{
		return $this->Customer_ID;
	}
	public function setCustomer_ID($Customer_ID)
	{
		$this->Customer_ID= $Customer_ID;
	}
	public function getCompany_Name()
	{
		return $this->Company_Name;
	}
	public function setCompany_Name($Company_Name)
	{
		$this->Company_Name= $Company_Name;
	}
	public function getContact_Telefone()
	{
		return $this->Contact_Telefone;
	}
	public function setContact_Telefone($Contact_Telefone)
	{
		$this->Contact_Telefone= $Contact_Telefone;
	}
	public function getContact_Email()
	{
		return $this->Contact_Email;
	}
	public function setContact_Email($Contact_Email)
	{
		$this->Contact_Email= $Contact_Email;
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
	public function setStreet($Street)
	{
		$this->Street= $Street;
	}
	public function getCity()
	{
		return $this->City;
	}
	public function setCity($Street)
	{
		$this->City= $City;
	}
	
	
}
?>