<?php 
class paging {

	var $pRecordCount;
	var $pStartFile;
	var $pRowsPerPage;
	var $pRecord;
	var $pCounter;
	var $pPageID;
	var $pShowLinkNotice;
	var $conObj;
	
	/* --------------------------
	Paging links (multi-language)*/
	var $paging_first;
	var $paging_last;
	var $paging_next;
	var $paging_previous;
	/* -------------------------- */
		
	function paging($seo=0, $first="First", $last="Last", $next="Next", $previous="Previous"){
		$this->paging_first = $first;
		$this->paging_last = $last;
		$this->paging_next = $next;
		$this->paging_previous = $previous;
		$this->seo_url = $seo;
	}
	
	function processPaging($rowsPerPage,$pageID)
	{
		       $record = $this->pRecordCount;
			   if($record >=$rowsPerPage)
			    	$record=ceil($record/$rowsPerPage);
			   else
					$record=1;
				if(empty($pageID) or $pageID==1)
				{
					$pageID=1;
					$startFile=0;
				}
				if($pageID>1)
				$startFile=($pageID-1)*$rowsPerPage;
				$this->pStartFile   = $startFile;
				$this->pRowsPerPage = $rowsPerPage;
				$this->pRecord      = $record;
				$this->pPageID      = $pageID;
				return $record;
	}
	function myRecordCount($conn, $query)
	{
		$rs      			= $this->conObj->pageExec($conn, $query);
		$rsCount 			= $this->conObj->total_rows($rs);
		$this->pRecordCount = $rsCount;
		unset($rs);
		return $rsCount;
	}
	function startPaging($query)
	{
		$count = 0;
		$query    = $query." LIMIT ".$this->pStartFile.",".$this->pRowsPerPage;	
		return $query;			
	}

	function pageLinks($url)
	{
	$link = "<div class='paging'>";
	$pid ="";
	$ltype ="";
	$catid ="";
	$cssclasses="";
	$cssclass ="add_menus";
	if(!strstr($url,"?") && $this->seo_url == 0) $url.="?";
	//$="";
	
		$this->pShowLinkNotice = "&nbsp;";
		if($this->pRecordCount>$this->pRowsPerPage)
		{		
			$this->pShowLinkNotice = "Page ".$this->pPageID. " of ".$this->pRecord;
			//Previous link
			if($this->pPageID!==1)
			{
				$prevPage = $this->pPageID - 1;
				if($this->seo_url == 0){
					$link .= "<a href=\"$url".((!strpos($url,"?"))?"?":"&")."np=1\" class=\"$cssclass\"> <strong>".$this->paging_first." </strong></a>";
					$link .= "<a href=\"$url".((!strpos($url,"?"))?"?":"&")."np=$prevPage\" class=\"$cssclass\">".$this->paging_previous."</a>";
				}
				else{
					$link .= "<a href=\"".$url."-1\" class=\"$cssclass\"> <strong>".$this->paging_first." </strong></a>";
					$link .= "<a href=\"".$url."-".$prevPage."\" class=\"$cssclass\">".$this->paging_previous."</a>";

				}
			}
			//Number links 1.2.3.4.5.
			for($ctr=1;$ctr<=$this->pRecord;$ctr++)
			{	
			
				if(abs($ctr-$this->pPageID)>5) continue;
				if($this->seo_url == 0){
					if($this->pPageID==$ctr)
					$link .=  "<a class='active'>$ctr</a>";
					else
					$link .= "<a href=\"$url&np=$ctr\" class='add_menus'>$ctr</a>";
				}
				else{
					if($this->pPageID==$ctr)
					$link .=  "<a class='active'>$ctr</a>";
					else
					$link .= "<a href=\"".$url."-".$ctr."\" class='add_menus'>$ctr</a>";
				}
			}
			//Previous Next link
			if($this->pPageID<($ctr-1))
			{
				$nextPage = $this->pPageID + 1;
				if($this->seo_url == 0){
					$link .= "<a href=\"$url".((!strpos($url,"?"))?"?":"&")."np=$nextPage\" class=\"$cssclass\"> ".$this->paging_next." </a>";	
					$link .="<a href=\"$url".((!strpos($url,"?"))?"?":"&")."np=".$this->pRecord."\" class=\"$cssclass\"> <strong>".$this->paging_last."</strong> </a>";
				}
				else{
					$link .= "<a href=\"".$url."-".$nextPage."\" class=\"$cssclass\"> ".$this->paging_next." </a>";	
					$link .="<a href=\"".$url."-".$this->pRecord."\" class=\"$cssclass\"> <strong>".$this->paging_last."</strong> </a>";
				}
			}
			return $link."</div>";
		}			
	}

}
?>