var ol = ol || {};

/**
 * 
 */
ol.manager = function () {
    	var $=jQuery;

        /**
         * Save user profile to server.
         */
        this.saveProfile = function() {
            var self = this;
	    $("#save_profile_btn").button('loading');
	    console.log('from save profile:' + $('meta[name="csrf-token"]').attr('content'));
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
			return;
		    }
	
		    location.href = '/profile';	    
		},
	    });
            return false;
        };

 
};
