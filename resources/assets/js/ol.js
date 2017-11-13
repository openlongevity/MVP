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
	    console.log('from save profile');
	    $("#save_profile_btn").button('loading');
            $.post('/profile/save', $('#user-profile-form'), function(result) {
                $("#save_profile_btn").button('reset');
		if (result.error) {
                    return;
                }
		
            }.bind(this));
            return false;
        };

 
};
