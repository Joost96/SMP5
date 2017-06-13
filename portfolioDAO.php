<?php
	include_once ("localBase.php");
	include_once ("portfolioItem.php");
	class portfolioDAO
	{
	
	function connect()
	{
		$dbObject = new localBase();
		$dbObject-> connect();
		
		$databaseConn = $dbObject->getConnection();
		return $databaseConn;
	}
	
	function execute($sql)
	{
		$databaseConn = $this->connect();
		$result = $databaseConn->query($sql) or die($databaseConn->error);
		$items = array();
		
		while($row = $result->fetch_assoc())
		{
			$portfolioItem = new portfolioItem($row["ID"], $row["titel"], $row["auteur"], $row["beschrijving"],
												$row["afbeelding"], $row["datum"], $row["jaar"]);
			
			$items[] = $portfolioItem;
		}
		
		return $items;		
	}
	
	function GetItemsForFilter($jaarFilters, $taalFilters)
	{
	$jaren = '';
	$talen = '';
		
		for($i = 0; $i < count($jaarFilters); i++)
		{
			$jaren .= "WHERE $jaarFilters[i], ";
		}
		
		for($i = 0; $i < count($taalFilters); i++)
		{
			$talen .= "WHERE $taalFilters[i], ";
		}
		rtrim("$jaarFilters", ", ");
		rtrim("$taalFilters", ", ");
	
	$sql = "SELECT * FROM portfolioItem $jaren";
	
	echo $sql;
	
	return $this->execute($sql);
	}
	
	function GetAllItems()
	{
	$sql = "SELECT * FROM portfolioitem";
	
	return $this->execute($sql);
	}
	}
?>	
			
	