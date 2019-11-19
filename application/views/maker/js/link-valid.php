<script type="text/javascript">
	$(document).ready(function(){
		$('#formValid').bootstrapValidator({
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				kode_jaminan: {
					validators: {
						notEmpty: {
							message: 'This field is required and can\'t be empty'
						}
					}
				}
			}
		});
	});
</script>