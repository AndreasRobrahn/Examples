<?php

class CustomerController
{
	public function __construct()
	{
			$this->DBConnection =  DBConnection::getInstance();
	}
	
	public function insertNewCustomer($Customer)
	{
		$param1 = $Customer->getCompany_Name();
		$param2 = $Customer->getContact_Telefone();
		$param3 = $Customer->getContact_Email();
		$param4 = $Customer->getZip_Code();
		$param5 = $Customer->getStreet();
		$param6 = $Customer->getCity();
		$bindParams= array(&$param1,&$param2,&$param3,&$param4,&$param5,&$param6);
		$query=	"BEGIN
			IF NOT EXISTS (SELECT * FROM [LagerDatenbank].[dbo].[Customer_Directory]
				WHERE [Customer_Directory].[Company_Name] = '".$Customer->getCompany_Name()."')
				BEGIN
					INSERT INTO [LagerDatenbank].[dbo].[Customer_Directory] 
						([Customer_Directory].[Company_name],[Customer_Directory].[Contact_Telefone],[Customer_Directory].[Contact_Email],[Customer_Directory].[Zip_Code],[Customer_Directory].[Street],[Customer_Directory].[City])
					VALUES
					(?, ?, ?, ?, ?, ?)
				END
		END " ;
		$this->DBConnection->executeQueryPrepared($query,$bindParams);
	}
	public function deleteCustomerByID($ID)
	{
		$query="DELETE From [LagerDatenbank].[dbo].[Customer_Directory] WHERE Customer_ID =".$ID." ";
		$this->DBConnection->executeQuery($query);
	}
	public function ShowCustomerDirectory()
	{
		$query="Select [Customer_Directory].[Customer_ID],[Customer_Directory].[Company_name],[Customer_Directory].[Contact_Telefone],[Customer_Directory].[Contact_Email],[Customer_Directory].[Zip_Code],[Customer_Directory].[Street],[Customer_Directory].[City]
				FROM [LagerDatenbank].[dbo].[Customer_Directory]
				";
		$array= $this->DBConnection->sqlToAssocArray($query);
		return $array;
	}
}
?>