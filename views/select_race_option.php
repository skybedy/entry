<?php
   class Select_Race_Option extends Model{
	public function __construct(){
	    parent::__construct();
	}
	  
	public function race_listing(){
	    $select = false; 
	    $select .= "<select class=\"form-control vyber-zavodu\" id=\"race_id\" onchange=\"window.location = '".URL."race/raceoption/'+this.options[this.selectedIndex].value+'';\">";
	    $select .= '<option value="">VÝBĚR ZÁVODU</option>';
	    $sql = "SELECT id_zavodu AS race_id, nazev_zavodu AS race_name FROM zavody_".YEAR." WHERE prihlasky > 0 ORDER BY nazev_zavodu";
	    $sth =  $this->db->prepare($sql);
	    $sth->setFetchMode(PDO::FETCH_ASSOC);
	    $sth->execute();
	    $data =  $sth->fetchAll();
	    $option = false;
	    foreach($data as $val){
		$option .= '<option value="'.$val['race_id'].'"';
		if (Session::get('race_id') == TRUE){
		    if(Session::get('race_id') == $val['race_id']){
			$option .= ' selected="selected"'; 
		    }
		}
	       $option .= '>'.$val['race_name'].'</option>';
	    }
	    $select .= $option;
	    $select.= '</select>';
	    return $select;
	}
    }
?>