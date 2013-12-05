/**
 * Creates a user data table with the name linking to the acl user resource edit screen.
 * User: kevin
 * Date: 11/16/13
 * Time: 2:59 PM
 */
$(
    function(){
        user.dataTable({
            'userNameLink': basePath+'/acl/user-resource/edit/'
        });
    }
);