<script>
	$(document).ready(function() {
		$("#form-daftar").submit(function(e) {
		    e.preventDefault();
		    $('.smart-wrap').hide();
		    $('.info img, .homex').show();
		    var form = $(this);
		    var url = form.attr('action');
		    $.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				dataType: 'json',
				success: function(data) {
					// console.log(data);
					if (data.info !== '') {
						setTimeout(function() {
					        $('.info').html(data.info);
					    }, 1000);
					}
				}
			});
		});
	});
</script>
