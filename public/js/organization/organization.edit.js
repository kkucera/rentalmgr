/**
 * Created with JetBrains PhpStorm.
 * User: kevin
 * Date: 11/26/13
 * Time: 7:52 PM
 * To change this template use File | Settings | File Templates.
 */
var organization = organization||{};

organization.edit = {

    submit: null,

    saveSuccess: function(response){
        base.inlineMessage('Organization has been saved.');
    },

    init: function(){
        this.submit = new base.submitButton({
            container: 'organization-submit',
            success: this.saveSuccess,
            url: basePath+'/organization/service/save.json'
        });
    }

};
$(
    function(){
        organization.edit.init();
    }
);

