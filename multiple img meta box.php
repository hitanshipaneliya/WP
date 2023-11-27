// multiple image upload metabox
function hastag_gallery_meta_box()
{
	add_meta_box(
		'ht gallery_Description',
		// $id aa id che
		'Key Features Image',
		// $title aya title
		'hastags_gallery_callback',
		// $callback
		'product',
		// $page aa post type che
		'normal',
		// $context
		'high' // $priority
	);
}
add_action('add_meta_boxes', 'hastag_gallery_meta_box');
function hastags_gallery_callback($post)
{
	global $post;
	$postId = $post->ID;
	$hashtag_image_up = get_post_meta($postId, 'hashtag_image_up', true);
	$image_title = get_post_meta($postId, 'image_title', true);

	?>
	<style type="text/css">
		.multi_image_ul img {
			width: 100px;
			height: 100px;
			object-fit: cover;
			margin: 10px auto;
			display: flex;
		}

		ul.multi_image_ul {
			display: flex;
		}

		.galery_title {
			font-size: 20px;
			color: #000;
			font-weight: 600;
			text-transform: capitalize;
		}

		li.test22 {
			width: 21% !important;
			float: left;
			border: 1px solid #000;
			padding: 10px;
			margin: 10px 10px !important;
			display: grid;
		}

		ul.multi_image_ul {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
		}
	</style>
	<div class="galery_box">
		<div class="galery_title">
			<span>Multiple Image Upload</span>
		</div>
		<?php echo hashtag_media_upload('hashtag_image_up', $hashtag_image_up, $postId); ?>
	</div>
	<script type="text/javascript">
		jQuery(function ($) {
			$('body').on('click', '.hashtag_multi_media_btn', function (e) {
				e.preventDefault();
				// console.log("->>>>>>");
				var button = $(this),
					custom_uploader = wp.media({
						title: 'Insert image',
						button: { text: 'Use this image' },
						multiple: true
					}).on('select', function () {
						var attech_ids = '';
						attachments
						var attachments = custom_uploader.state().get('selection'),
							attachment_ids = new Array(),
							i = 0;
						attachments.each(function (attachment) {
							attachment_ids[i] = attachment['id'];
							attech_ids += ',' + attachment['id'];
							if (attachment.attributes.type == 'image') {
								$(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '" class="test"><a href="' + attachment.attributes.url + '" target="_blank"></a><img class="true_pre_image" src="' + attachment.attributes.url + '" /><input type="text" placeholder="Title" name="image_title[]"><i class=" dashicons dashicons-no delete-img"></i></li>');
							} else {
								$(button).siblings('ul').append('<li data-attechment-id="' + attachment['id'] + '" class="test1"><a href="' + attachment.attributes.url + '" target="_blank"></a><img class="true_pre_image" src="' + attachment.attributes.icon + '" /><i class=" dashicons dashicons-no delete-img"></i></li>');
							}
							i++;
						});

						var ids = $(button).siblings('.attechments-ids').attr('value');
						if (ids) {
							var ids = ids + attech_ids;
							$(button).siblings('.attechments-ids').attr('value', ids);
						}
						else {
							$(button).siblings('.attechments-ids').attr('value', attachment_ids);
						}
						$(button).siblings('.hashtag_remove_image_button').show();
					})
						.open();
			});

			$('body').on('click', '.hashtag_remove_image_button', function () {
				// console.log("remove ->>>>>>");
				$(this).hide().prev().val('').prev().addClass('button').html('Add Media');
				$(this).parent().find('ul').empty();
				return false;
			});

		});

		jQuery(document).ready(function () {
			jQuery(document).on('click', '.multi_media_hashtag ul li i.delete-img', function () {

				var ids = [];
				var this_c = jQuery(this);
				var this_class_name = jQuery(this).data('name');
				console.log(" id remove ->>>>>>", this_class_name);
				jQuery(this).parent().remove();
				jQuery('.' + this_class_name + ' ul li').each(function () {
					ids.push(jQuery(this).attr('data-attechment-id'));
				});
				jQuery('.' + this_class_name + '').find('input[type="hidden"]').attr('value', ids);
			});
		});
	</script>
	<?php
}
// image function
function hashtag_media_upload($name, $value = '', $postId = 0)
{
	$image = '">Add Media';
	$image_str = '';
	$image_size = 'full';
	$display = 'none';
	$value = explode(',', $value);

	$image_title = get_post_meta($postId, 'image_title', true);

	if (!empty($value)) {
		foreach ($value as $key => $values) {

			//    echo "<pre>";
			// print_r($image_title[$key]);
			// // print_r($key);
			// echo "</pre>";

			if ($image_attributes = wp_get_attachment_image_src($values, $image_size)) {
				$image_str .= '<li data-attechment-id=' . $values . ' class="test22"><a href="' . $image_attributes[0] . '" target="_blank"><img src="' . $image_attributes[0] . '" /></a><input type="text" class="image_title" name="image_title[]" value="' . $image_title[$key] . '"><i class="dashicons dashicons-no delete-img" data-name="' . $name . '"></i></li>';
			}
		}
	}

	if ($image_str) {
		$display = 'inline-block';
	}

	return '<div class="multi_media_hashtag ' . $name . ' "  ><ul class="multi_image_ul">' . $image_str . '</ul><a href="#" class="hashtag_multi_media_btn button' . $image . '</a><input type="hidden" class="attechments-ids ' . $name . '" name="' . $name . '" id="' . $name . '" value="' . esc_attr(implode(',', $value)) . '" /><a href="#" class="hashtag_remove_image_button button img_cus_rm_btn" style="display:inline-block;display:' . $display . '">Remove media</a></div>';
}

// -----------------------------
//=============== SAVE META VALUE
add_action('save_post', 'wc_meta_box_save_hashtags');
function wc_meta_box_save_hashtags($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (!current_user_can('edit_posts')) {
		return;
	}

	// pre($_POST);
	// die;

	if (isset($_POST['hashtag_image_up'])) {
		update_post_meta($post_id, 'hashtag_image_up', $_POST['hashtag_image_up']);
	}
	if (isset($_POST['image_title'])) {
		update_post_meta($post_id, 'image_title', $_POST['image_title']);
	}
}
