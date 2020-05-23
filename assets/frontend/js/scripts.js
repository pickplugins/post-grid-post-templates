jQuery(document).ready(function($){

	$(document).on('keyup', '.post-grid .nav-search .search', function(e)
		{
			var keyword = $(this).val();
			var grid_id = $(this).attr('grid_id');
			var key = e.which;

			if(key == 13){
				// the enter key code
				var is_reset = 'yes';

				$(this).addClass('loading');

				$('.pagination').fadeOut();

				$.ajax({
					type: 'POST',
					context: this,
					url:post_grid_ajax.post_grid_ajaxurl,
					data: {"action": "post_grid_ajax_search", "grid_id":grid_id,"keyword":keyword,"is_reset":is_reset,},
					success: function(data){

						$('#post-grid-'+grid_id+' .grid-items').html(data);
						$(this).removeClass('loading');
					}
				});

			}
			else{
				var is_reset = 'no';
				if(keyword.length>3){
					$(this).addClass('loading');

					$('.pagination').fadeOut();

					$.ajax({
						type: 'POST',
						context: this,
						url:post_grid_ajax.post_grid_ajaxurl,
						data: {"action": "post_grid_ajax_search", "grid_id":grid_id,"keyword":keyword,"is_reset":is_reset,},
						success: function(data){

							$('#post-grid-'+grid_id+' .grid-items').html(data);
							$(this).removeClass('loading');
						}
					});
				}

			}



		})





});






