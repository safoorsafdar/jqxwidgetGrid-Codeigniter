<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Part1_model extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->_table = "customers";
    }
    public function getAllGridData($GET){
        $defaultsortdatafield = (empty($GET['sortdatafield']) && $GET['sortdatafield'] == ""?"CustomerID":$GET['sortdatafield']);
        $defaultsortorder = (empty($GET['sortorder']) && $GET['sortorder'] == "" ?"DESC":$GET['sortorder']);
        $pagenum = $GET['pagenum'];
	$pagesize = $GET['pagesize'];
	$start = $pagenum * $pagesize;
        $query_select = "CustomerID,EmailAddress,UserName,BillingFirstName,BillingLastName,BillingPostcode,Billingtelephone,Active";
        $query_table = $this->_table;
        
        //build query
        $query = "SELECT SQL_CALC_FOUND_ROWS $query_select FROM $query_table ORDER BY" . " " . $defaultsortdatafield . " $defaultsortorder LIMIT $start, $pagesize";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$sql = "SELECT FOUND_ROWS() AS `found_rows`;";
	$rows = mysql_query($sql);
	$rows = mysql_fetch_assoc($rows);
	$total_rows = $rows['found_rows'];
	$filterquery = "";
        // filter Query data.
        if(isset($GET['filterscount'])){
           $filterscount = $GET['filterscount'];
            if ($filterscount > 0){
                $where = " WHERE (";
                $tmpdatafield = "";
                $tmpfilteroperator = "";
                for($i=0; $i < $filterscount; $i++){
                    $filtervalue = $GET["filtervalue" . $i];          // get the filter's value.
                    $filtercondition = $GET["filtercondition" . $i];    // get the filter's condition.
                    $filterdatafield = $GET["filterdatafield" . $i];    // get the filter's column.
                    $filteroperator = $GET["filteroperator" . $i];      // get the filter's operator.
                    if($tmpdatafield == ""){
                        $tmpdatafield = $filterdatafield;			
                    }else if($tmpdatafield <> $filterdatafield){
                        $where .= ")AND(";
                    }else if ($tmpdatafield == $filterdatafield){
                        if ($tmpfilteroperator == 0)$where .= " AND ";
                        else $where .= " OR ";	
                    }
                    switch($filtercondition){
                        case "NOT_EMPTY":
                        case "NOT_NULL":
                                $where .= " " . $filterdatafield . " NOT LIKE '" . "" ."'";
                                break;
                        case "EMPTY":
                        case "NULL":
                                $where .= " " . $filterdatafield . " LIKE '" . "" ."'";
                                break;
                        case "CONTAINS_CASE_SENSITIVE":
                                $where .= " BINARY  " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";
                                break;
                        case "CONTAINS":
                                $where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";
                                break;
                        case "DOES_NOT_CONTAIN_CASE_SENSITIVE":
                                $where .= " BINARY " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";
                                break;
                        case "DOES_NOT_CONTAIN":
                                $where .= " " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";
                                break;
                        case "EQUAL_CASE_SENSITIVE":
                                $where .= " BINARY " . $filterdatafield . " = '" . $filtervalue ."'";
                                break;
                        case "EQUAL":
                                $where .= " " . $filterdatafield . " = '" . $filtervalue ."'";
                                break;
                        case "NOT_EQUAL_CASE_SENSITIVE":
                                $where .= " BINARY " . $filterdatafield . " <> '" . $filtervalue ."'";
                                break;
                        case "NOT_EQUAL":
                                $where .= " " . $filterdatafield . " <> '" . $filtervalue ."'";
                                break;
                        case "GREATER_THAN":
                                $where .= " " . $filterdatafield . " > '" . $filtervalue ."'";
                                break;
                        case "LESS_THAN":
                                $where .= " " . $filterdatafield . " < '" . $filtervalue ."'";
                                break;
                        case "GREATER_THAN_OR_EQUAL":
                                $where .= " " . $filterdatafield . " >= '" . $filtervalue ."'";
                                break;
                        case "LESS_THAN_OR_EQUAL":
                                $where .= " " . $filterdatafield . " <= '" . $filtervalue ."'";
                                break;
                        case "STARTS_WITH_CASE_SENSITIVE":
                                $where .= " BINARY " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
                                break;
                        case "STARTS_WITH":
                                $where .= " " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
                                break;
                        case "ENDS_WITH_CASE_SENSITIVE":
                                $where .= " BINARY " . $filterdatafield . " LIKE '%" . $filtervalue ."'";
                                break;
                        case "ENDS_WITH":
                                $where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."'";
                                break;
                    }
                    if ($i == $filterscount - 1) $where .= ")";
                    $tmpfilteroperator = $filteroperator;
                    $tmpdatafield = $filterdatafield;			
		}
                    // build the query.
                    $query = "SELECT $query_select FROM $query_table ".$where;
                    $filterquery = $query;
                    $result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
                    $sql = "SELECT FOUND_ROWS() AS `found_rows`;";
                    $rows = mysql_query($sql);
                    $rows = mysql_fetch_assoc($rows);
                    $new_total_rows = $rows['found_rows'];		
                    $query = "SELECT $query_select FROM $query_table ".$where." LIMIT $start, $pagesize";		
                    $total_rows = $new_total_rows;
            }
        } 
        if(isset($GET['sortdatafield'])){ // sorted Query data.
            $sortfield = $GET['sortdatafield'];
            $sortorder = $GET['sortorder'];
            if($sortorder != ''){
                if ($GET['filterscount'] == 0){
                    if ($sortorder == "desc"){
                        $query = "SELECT $query_select FROM $query_table ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";
                    }else if($sortorder == "asc"){
                        $query = "SELECT $query_select FROM $query_table ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";
                    }
                }else{
                    if ($sortorder == "desc"){
                        $filterquery .= " ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";
                    }else if ($sortorder == "asc"){
                        $filterquery .= " ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";
                    }
                    $query = $filterquery;
                }		
            }
        }
        $query = $this->db->query($query);
        $customers = null;
        foreach ($query->result_array() as $row){
           $customers[] = array(
            'CustomerID' => $row['CustomerID'],
            'EmailAddress' => $row['EmailAddress'],
            'UserName' => $row['UserName'],
            'BillingFirstName' => $row['BillingFirstName'],
            'BillingLastName' => $row['BillingLastName'],
            'BillingPostcode' => $row['BillingPostcode'],
            'Billingtelephone' => $row['Billingtelephone'],
            'Active' => $row['Active'],
          );
        }
        $data[] = array(
           'TotalRows' => $total_rows,
	   	   'Rows' => $customers
		);
        return $data;
    }
}
?>
