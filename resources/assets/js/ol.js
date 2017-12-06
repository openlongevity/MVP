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
         * Save user markers to server.
         */
        this.saveUserMarkers = function() {
            var self = this;
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

        /**
         * Save user profile to server.
         */
        this.saveUserMarker = function() {
            var self = this;
	    $("#edit_marker_btn").button('loading');
            $.ajax({
		url: '/markers/edit', 
		type: 'post',
		data: $('#edit_marker_form').serialize(),
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},	
		success: function(result) {
		    $("#edit_marker_btn").button('reset');
		    location.href = '/my_markers';	    
		},
	    });
            return false;
        };

        /**
         * Save user profile to server.
         */
        this.deleteMarker = function() {
            var self = this;
            $.ajax({
		url: '/markers/delete', 
		type: 'post',
		data: {id: $('#id').val()},
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},	
		success: function(result) {
		    location.href = '/my_markers';	    
		},
	    });
            return false;
        };

        /**
         * Save panel info.
         */
        this.savePanelInfo = function() {
            var self = this;
	    $("#save_panel_btn").button('loading');
            $.ajax({
		url: '/admin/panel/save', 
		type: 'post',
		data: $('#panel-form').serialize(),
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},	
		success: function(result) {
		    $("#save_panel_btn").button('reset');
		    $.notify("Данные сохранены успешно!", "success");
		},
	    });
            return false;
        };

 
        /**
         * Save user markers to server.
         */
        this.saveUserPanelMarkers = function(panel_id) {
            var self = this;
	    $("#save_panel_markers_btn").button('loading');
            $.ajax({
		url: '/panel/markers/save', 
		type: 'post',
		data: $('#add_markers_form').serialize(),
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},	
		success: function(result) {
		    $("#save_panel_markers_btn").button('reset');
		    location.href = '/panel/markers/' + panel_id; 
		},
	    });
            return false;
        };

        /**
         * Save marker info.
         */
        this.saveMarkerInfo = function() {
            var self = this;
	    $("#save_marker_btn").button('loading');
            $.ajax({
		url: '/admin/marker/save', 
		type: 'post',
		data: $('#marker-form').serialize(),
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},	
		success: function(result) {
		    $("#save_marker_btn").button('reset');
		    $.notify("Данные сохранены успешно!", "success");
		},
	    });
            return false;
        };

 
};
