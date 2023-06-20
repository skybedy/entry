<?php
		
	function Radkovani($i){
		(fmod($i,2) == 0) ? ($radek = "sudy") : ($radek = "lichy");
		return $radek;
	}	 
	$platba = Array("uhrazeno" => 'Uhrazeno',"neuhrazeno" => 'Neuhrazeno');
	
	$tricka = Array();
   $tricka['Bez trička'] = 'bez';
	$tricka['S-pánské'] = 'S-male';
   $tricka['M-pánské'] = 'M-male';
   $tricka['L-pánské'] = 'L-male';
   $tricka['XL-pánské'] = 'XL-male';
   $tricka['XXL-pánské'] = 'XXL-male';
   $tricka['S-dámské'] = 'S-female';
   $tricka['M-dámské'] = 'M-female';
   $tricka['L-dámské'] = 'L-female';
   $tricka['XL-dámské'] = 'XL-female';
   $tricka['104-dětské'] = '104-child';
   $tricka['116-dětské'] = '116-child';
   $tricka['128-dětské'] = '128-child';
   $tricka['140-dětské'] = '140-child';
   $tricka['152-dětské'] = '152-child';
   $tricka['165-dětské'] = '165-child';
	

	if($this->VypisPrihlasek){
		$str = false;
		echo '<table class="vypis_prihlasek">';
		echo '<tr class="hlavicka">';
		echo '<td class="align_center">#</td><td>VS</td><td>Příjmení</td><td>Jméno</td><td>Tým/Bydliště</td><td class="align_center">Country</td><td class="align_center">Narození</td><td>E-mail</td><td>Telefon1</td><td>Telefon2</td><td>Závod</td>
			<td class="align_center">Platba</td><td class="align_center">Tričko</td><td class="align_center">Kč</td><td>Změna údajů</td>';
		echo '</tr>';
		$radek = 1;
		foreach($this->VypisPrihlasek as $data){
			$str = false;
			$str .= '<tr class="'.Radkovani($radek).'">';
			$str .= '<form id="zmena_udaju" action="'.URL.'race/zmena_udaju/" method="post">';
			$str .= '<input type="hidden" name="id" value="'.$data->id.'" />';
			$str .= '<td class="align_center">'.$radek.'</td>';
			$str .= '<td>'.$data->vs.'</td>';
			$str .= '<td>'.$data->prijmeni.'</td>';
			$str .= '<td>'.$data->jmeno.'</td>';
			$str .= '<td>'.$data->prislusnost.'</td>';
			$str .= '<td class="align_center">'.$data->stat.'</td>';
			$str .= '<td class="align_center">'.$data->datum_narozeni.'</td>';
			$str .= '<td>'.$data->mail.'</td>';
			$str .= '<td>'.$data->telefon.'</td>';
			$str .= '<td>'.$data->nahradni_telefon.'</td>';
			$str .= '<td>';
			$str .= ($data->vyber_zavodu == 'dospeli') ? ('Dospělí') : ('Děti'); 
			$str .= '</td>';
			$str .= '<td>';
			$str .= '<select name="platba">';
			foreach($platba as $key => $data1){
				$str .= '<option value="'.$key.'"';
				$str .= ($key == $data->zaplaceno) ? ('selected=\"selected\"') : ('');
				$str .= ' >'.$data1.'</option>'; 
			}
			$str .= '</select>';
			$str .= '</td>';
			$str .= '<td><select name="tricko">';
			foreach($tricka as $key => $data2){
				$str .= '<option value="'.$data2.'"';
				$str .= ($data2 == $data->velikost_tricka) ? ('selected=\"selected\"') : ('');
				$str .= ' >'.$key.'</option>'; 
			}
			$str .= '</select></td>';
			$str .= '<td><input  class="align_center" size="2" name="startovne" value="'.$data->startovne.'" /></td>';
			$str .= '<td><input class="submit" type="submit" value="Změnit" /></td>';
			
			$str .= '</form>';
			$str .= '</tr>';
			echo $str;
			$radek++;
		}
		echo '</table>';
			
	}

?>

<div id="listInserts"></div>