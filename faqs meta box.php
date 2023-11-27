<?php 

// faq meta box
function faqs_meta_box() {
add_meta_box(
'faqs_Description',     // $id aa id che
'FAQS Description',     // $title aya title
'faqs_desc_callback',      // $callback
'product',                 // $page aa post type che
'normal',                  // $context
'high'                     // $priority
);
}
add_action('add_meta_boxes', 'faqs_meta_box');

function faqs_desc_callback($post){

global $post;

$postId = $post->ID;

$titlename = get_post_meta( $postId, 'titlename', true );
$descnm = get_post_meta( $postId, 'descnm', true);	
// echo "<pre>";
//  print_r($titlename);
//  print_r($descnm);
//  echo "</pre>";  
//  die;

?>
<style type="text/css">
table {
	width: 100%;
}
.faq_pro_row input.input_filed {
	width: 100% !important;
	height: 70px;
	font-size: 16px;
}
.faq_pro_row textarea.textarea_filed {
	margin: 0 !important;
	height: 70px !important;
	font-size: 16px;
	width: 100% !important;
}
.faq_pro_row div#add_filed_box {
	display: block;
	width: 100% !important;
}
.faq_pro_row tr{
	display: flex;
	gap: 10px;
	width: 100% !important;
}
.faq_pro_row tr th {
	width: 100% !important;
	font-size: 18px;
	color: #000;
	padding: 10px 0;
	background: #f5f2f7;
	margin-bottom: 15px;
	height: 30px;
	
}
.faq_pro_row tr td {
	width: 100%  !important;
}
.faq_pro_row .remove,.add_btn {
	margin: 0 auto;
	display: flex;
	background: #f5f2f7;
	width: 100%;
	height: 40px;
	align-items: center;
	justify-content: center;
	font-size: 35px !important;
	font-weight: bold;
	padding-bottom: 8px;
	cursor: pointer;
	border: none;
}
.faq_pro_row tr th:last-child,.faq_pro_row tr td:last-child {
	width: 10% !important;
	display: flex;
	justify-content: center;
	align-items: center;
}


</style>
<div class="faq_pro_row">
<table>
	<tr>
		<th>Title</th>
		<th>Description</th>
		<th class="add_btn">+</th>
		
	</tr>

	<!-- <tr>
		<td><input type="text" class="input_filed" placeholder="Enter Title" name="titlename[]" value="" readonly="" /></td>
		<td><textarea class="textarea_filed" placeholder="Enter Description" name="descnm[]" value="" readonly=""></textarea></td>
		<td><button type="button" class="add_btn pro_btn">+</button></td>
	<tr> -->

	<?php
		$count = 0;

		if(@$titlename)
		{
			foreach ($titlename as $key => $curEntry) {
				if(@$curEntry)
				{

					// $count++;
					// echo "<pre>";
					// print_r($curEntry);
					// // print_r($count);
					// echo "</pre>";	
	?>
					<tr>
						<td><input type="text" class="input_filed" placeholder="Enter Title" name="titlename[]" value="<?php echo $curEntry; ?>" /></td>
						<td><textarea class="textarea_filed" placeholder="Enter Description" name="descnm[]" value=""><?php echo $descnm[$count]; ?></textarea></td>
						<td><button type="button"  class="remove pro_btn" >-</button></td>

					</tr>
	<?php 
					$count++; 
				} 
			} 
		} 
	?>
	


</table>
</div>
<div class="faq_pro_row">
<div id="add_filed_box">
	
</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
jQuery(".add_btn").click(function(){
	var  html = '';
	
	html += '<tr>';
	html += '<td><input type="text" class="input_filed" placeholder="Enter Title" name="titlename[]" /></td>';
	html += '<td><textarea class="textarea_filed" placeholder="Enter Description" name="descnm[]"></textarea></td>';
	html += '<td><button type="button"  class="remove pro_btn" >-</button></td>';
	html += '</tr>';

	jQuery("#add_filed_box").append(html);
});

jQuery(document).on('click','.remove', function () {
	jQuery(this).closest('tr').remove();
});
});
</script>

<?php
}



// -------------------------------
//=============== SAVE META VALUE
// -------------------------------
add_action( 'save_post', 'wc_meta_box_save' );

function wc_meta_box_save( $post_id ) {
if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
return; 
}
if( !current_user_can( 'edit_posts' ) ){
return; 	
}

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// die;

if(isset($_POST['titlename'])){
update_post_meta($post_id, 'titlename',$_POST['titlename']);
}
if(isset($_POST['descnm'])){
update_post_meta($post_id, 'descnm',$_POST['descnm']);
}

}

?>