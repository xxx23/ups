<?
	// create by: q110185
	// create date : 20091001
	// function : use to divide the data from database to pages .
	
	class Pager{
		private $page;
		private $perpage;
		private $data_cnt;
		private $data_offset;
		private $page_cnt;
		
		//[constructor ]
		//INPUT:array(
		//			page => 1,      //current Page Number
		//          per_page =>10 ,  //how much data to display in one page.
		//          data_cnt => 100,   // total data number
		function Pager($metadata)
		{
			if(!$metadata['page'])$metadata['page']=1;
			$this->setPage($metadata['page']);
			$this->setPerPage($metadata['per_page']);
			$this->setDataCnt($metadata['data_cnt']);
			$this->countPage();
		}

		function setPage ($p)
		{
			if($p >= 1)
				$this->page = (int)$p;
			else 
				$this->page = 1 ;
		}
		
		function setPerPage($p)
		{
			if($p >= 1)
				$this->perpage = (int)$p;
			else 
				$this->perpage = 1;
		}

		function setDataCnt($cnt)
		{
			if($cnt >= 0)
				$this->data_cnt=(int)$cnt;
			else 
				$this->data_cnt = 0;
		}

		function countPage()
		{
			
			   
			$this->page_cnt=(int)( $this->data_cnt / $this->perpage);
			if(   $this->data_cnt > $this->perpage
			   && $this->data_cnt % $this->perpage !=0) $this->page_cnt +=1;
		}
		
		function getPageCnt()
		{
			return $this->page_cnt;
		}
		
		function getSqlLimit()
		{
			$pageT = ($this->page >= 1)? $this->page : 1;
			$start = ($pageT-1) * $this->perpage;
			return " LIMIT {$start},{$this->perpage} ";
		}
		
		//for Smarty template
		// {html_options values=$page_ids names=$page_names selected=$page_sel}
		function getSmartyHtmlOptions()
		{		
			for($i=1; $i <= $this->getPageCnt() ;$i++){
				$pagerOpt['page_ids'][] = $i;
				$pagerOpt['page_names'][] =$i;
			}
			$pagerOpt['page_sel'] = $this->page;
			return $pagerOpt;
		}
		
		function getOffset()
		{
			$pageT = ($this->page >= 1)? $this->page : 1;
			$start = ($pageT-1) * $this->perpage;
			return $start;
		}
		
		function getPerpage()
		{
			return $this->perpage;
		}
		function thisPage()
		{
			return $this->page;
		}
		
		function nextPage()
		{
			$pageT = $this->page + 1;
			return ( $pageT < $this->getPageCnt())? $pageT :$this->page_cnt;
		}
		
		function previousPage()
		{
			$pageT = $this->page - 1;
			return ($pageT > 1) ? $pageT : 1;
		}
	}
?>