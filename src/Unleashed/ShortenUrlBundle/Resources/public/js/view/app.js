var viewApp = {
    
    reloadStats: function(){
        var data = {
            urlCode: $('#urlCode').val()
        };

        var page = Routing.generate('unleashed_view', data);
        
        setTimeout(function(){
            $('#analytics').load(page + ' .stats-wrap', data);
        }, 2000);
        
    }
    
};