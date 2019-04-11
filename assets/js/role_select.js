
function render_user_select(){

    "use strict"; // Start of use strict

    $('#user_roles').multiselect({
        numberDisplayed: 10
    });

}

module.exports = {
    render_user_select
};