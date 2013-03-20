
$(document).ready(function() {
    
    $("#login-btn").live('click',function(e) {
        
        var href = $(this).attr('href');
        e.preventDefault();
        top.location.href = href; 
    });
})