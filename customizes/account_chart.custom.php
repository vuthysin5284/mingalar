<?php
	class account_chart_custom extends account_chart{
		
		function Get_Combobox_account_chart($account_type,$account_type1=0,$account_type2 = 0){
			global $db;
			$sql = "select a.account_id , a.account_code , a.account_description_en +'  ' as account_description_en from account_chart a inner join account_type t on a.account_type_id = t.account_type_id where a.account_type_id in($account_type,$account_type1,$account_type2) and (account_leader is null or account_leader = 0 ) ";
			$dr = $db->Execute($sql); 
			return $dr;
		}
		
		function GetComboboxAccountChats(){
			global $db;
			$sql = "select * from account_chart where account_leader in( null,0)";
			$rs = $db->Execute($sql);
			$option = "<option value='0'> </option>";
			while($dr = $rs->FetchRow()){
				$option .= "<option value='".$dr["account_id"]."'>".$dr["account_code"].' - '. $dr["account_description_en"] ."</option>"	;
			}
			return $option;
		}
		
		function GetAllAccount(){
			global $db;
			$sql = "select * from account_chart where account_leader is null or account_leader = 0";
			$dr = $db->Execute($sql); 
			return $dr;
		}
		
		function Get_Combobox_account_chart_sub($account_id){
			global $db;
			$sql = "select * from account_chart where account_leader=$account_id";
			$dr = $db->Execute($sql); 
			return $dr;
		}
		function Insert_sub_account($objInfo){ 		
			global $db;
			$detector = false;
			$sql = "INSERT INTO account_chart" .
						"(account_code," . 
							"account_description_en," . 
							"account_type_id," . 
							"account_leader)" . 
						" VALUES" . 
						"(	'".$objInfo->account_code."'," . 
							"'".$objInfo->account_description_en."'," . 
							"'".$objInfo->account_type_id."'," . 
							"'".$objInfo->account_leader."')";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		
		function get_Subaccount_leader($obj){
			global $db;
			
			$sql = "select * from account_chart where account_id = '".$obj->account_id."' limit 1 ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}
		
		function getAccountChatByAccountTypeId($account_type_id){
			global $db;
			$sql = "select * from account_chart where account_type_id = '".$account_type_id."'";
			$dr = $db->Execute($sql); 
			return $dr;
		}
		
		function Get_Combobox_account_chart1(){
			global $db;
			$sql = "select * from account_chart inner join account_type on account_chart.account_type_id=account_type.account_type_id 
where account_chart.account_type_id=2 or account_chart.account_id=51 or account_type_name_en='Income' ";
			$dr = $db->Execute($sql); 
			return $dr;
		}
		
		function Get_Combobox_account_chart23(){
			global $db;
			$sql = "select * from account_chart inner join account_type on account_chart.account_type_id=account_type.account_type_id 
where account_chart.account_type_id=3 or account_type_name_en='Accounts Receivable' or account_chart.account_type_id=4 or account_type_name_en='Current Asset'";
			$dr = $db->Execute($sql); 
			return $dr;
		}
		
		function Get_Combobox_account_chart3(){
			global $db;
			$sql = "select * from account_chart inner join account_type on account_chart.account_type_id=account_type.account_type_id 
where account_chart.account_type_id=4 or account_type_name_en='Current Asset'";
			$dr = $db->Execute($sql); 
			return $dr;
		}
		
		
		function GetBalanceAsset($account_id){
			
			global $db;
			$sql = "select (sum(a.debit) - (sum(a.credit) +(select coalesce(sum(amount_usd),0) from purchase where account_id = a.account_id) )) balance from account_transaction a where account_id =?";
			$dr = $db->Execute($sql, array($account_id)); 
			$rs =  $dr->FetchRow();
			return $rs["balance"];
			
		}
		
		function GetBalanceLiab($account_id){
			global $db;
			$sql = "select (sum(credit) - sum(debit)) balance from account_transaction  where account_id = ?";
			$dr = $db->Execute($sql, array($account_id)); 
			$rs =  $dr->FetchRow();
			
			return $rs["balance"];
		}
		
		
		function GetDepositAmount($start_date , $end_date){
			global $db;
			
			$sql = "SELECT sum(debit)  as amount FROM account_transaction t 
INNER JOIN account_chart c ON t.account_id=c.account_id where  debit > 0 and t.trans_type = 'DEP' 
and  date_format(t.trans_date,'%Y-%m-%d') = '".$start_date."' and '".$end_date."' ";
			$dr = $db->Execute($sql); 
			$rs =  $dr->FetchRow();
			return $rs["amount"];
		}
		
		function GetDepositAmountByDate($date){
			global $db;
			
			$sql = "SELECT sum(debit)  as amount FROM account_transaction t 
INNER JOIN account_chart c ON t.account_id=c.account_id where  debit > 0 and t.trans_type = 'DEP' 
and  date_format(t.trans_date,'%Y-%m-%d') = '".$date."' ";
			$dr = $db->Execute($sql); 
			$rs =  $dr->FetchRow();
			
			return $rs["amount"];
		}
		
	}
	
?>