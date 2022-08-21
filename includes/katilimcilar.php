<style>
	a.hepsini_goster {
		display: block!important;
		text-align: center;
		background: #0073aa99;
		color: #f1f1f1;
		text-decoration: none!important;
		padding: 5px;
	} 
	a.hepsini_goster:hover {
		background: #0073aa;
		text-decoration: none!important;
	}
	.satirr {
		display: none;
	}
	.acik {
		display: table-row;;
	}
	.katilanlar_wrap {
		width: 100%;
		max-width: 400px;
		margin-top: 20px;
	}
	.katilanlar_wrap table {
		width: 100%;
		max-width: 400px;
	}
	.katilanlar_wrap th {
		padding: 10px 20px;
		background: black;
		color: #fff;
	}
	.katilanlar_wrap td {
		padding: 10px 20px;
		background: #e4e4e4;
	}
	.katilanlar_wrap th:nth-child(1),
	.katilanlar_wrap th:nth-child(4),
	.katilanlar_wrap tr td:nth-child(1),
	.katilanlar_wrap tr td:nth-child(4) {
		text-align: center;
	}
</style>

<h1>Katılımcılar</h1>

<select name="sinav_sec">
	<option value="0">Sınav seçin...</option>
	<?php
	global $wpdb;
	$table_name = $wpdb->prefix . 'doq_quiz';
	$quizzez = $wpdb->get_results( 'SELECT * FROM '.$table_name, ARRAY_A );
	
	$i = 1;
			
	if (!empty($quizzez)){
		foreach ($quizzez as $quiz) {
			?>
			<option value="<?php echo $quiz['ID']; ?>"><?php echo (strlen($quiz['name'])>50) ? mb_substr($quiz['name'],0,50).'...' : $quiz['name']; ?></option>
			<?php
			$i++;
		}
	}
	?>
</select>

<div class="katilanlar_wrap"></div>

<script>
jQuery(function ($){
	$('select[name="sinav_sec"]').on('change', function(){
		var sid = $(this).val();
		var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
		if( sid != 0 ){
			var data = {
				action: 'katilanlari_cek',
				sid: sid,
			}
			$.post( ajaxurl, data, function(response){
				$('.katilanlar_wrap').html(response);
			});
		}else{
			$('.katilanlar_wrap').html('');
		}
	});
});
</script>