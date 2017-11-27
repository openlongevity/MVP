var ol = ol || {};

/**
 * 
 */
ol.manager = function () {
    	var $=jQuery;

	/**
	 * Count rows for user adding markers.
	 */ 
	this.countRows = 0;

        /**
         * Save user profile to server.
         */
        this.saveProfile = function() {
            var self = this;
	    $("#save_profile_btn").button('loading');
            $.ajax({
		url: '/profile/save', 
		type: 'post',
		data: $('#user-profile-form').serialize(),
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},	
		success: function(result) {
		    $("#save_profile_btn").button('reset');
		    if (result.error == 1) {
			$("#name-error").html('Введите Ваши фамилию, имя и отчество');
			return;
		    }
		    if (result.error == 2) {
			$("#height-error").html('Неверное значение роста');
			return;
		    }
	
		    location.href = '/profile';	    
		},
	    });
            return false;
        };

        /**
         * Creates row with marker.
         */
        this.createRowWithMarker = function() {
	    var marker_id = $('#marker_chooser').val();
	    if (marker_id == 0) {
		return false;
	    }
	    this.countRows++;
	    $('#count_rows').val(this.countRows);
	    var number = this.countRows;
            $.ajax({
		url: '/markers/row', 
		type: 'post',
		data: {marker_id: marker_id, number: number},
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},	
		success: function(result) {
		    if (result.html) {
			// Insert new table row before last row in table.
			$("#user_markers_table tr:last").before(result.html);	
			// Calendar for date.
			$('.date').datetimepicker({format: 'YYYY-MM-DD', defaultDate: moment(), ignoreReadonly: true});
			// Select for marker chooser.
			$('#marker_id_' + number).select2({
			    dropdownParent: $('#add-markers-modal')
			});
			$(document).on("click", "#remove_" + number, function(e) {
			    $('#marker_row_' + number).remove();
			    return false;
			});

			// Set default value (0) for last chooser.
			$("#marker_chooser").val(0).change();

		    }
		},
	    });
	    return false;
	};
 
        /**
         * Save user profile to server.
         */
        this.saveUserMarkers = function() {
            var self = this;
	    console.log('form:' + $('#add_markers_form').serialize());
	    $("#save_markers_btn").button('loading');
            $.ajax({
		url: '/markers/save', 
		type: 'post',
		data: $('#add_markers_form').serialize(),
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},	
		success: function(result) {
		    $("#save_markers_btn").button('reset');
		    location.href = '/my_markers';	    
		},
	    });
            return false;
        };

};
