var userList = (function(userList){
    if (this.userList) {
        var userList = this.userList;

        var $dom = $('#userListModule');
        var $tbody = $dom.find('tbody');
        var template = $dom.find('#userList-template').html();

        var data = {"users": userList};

        $tbody.html(Mustache.render(template, data));
    }
})();