document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, {});
    
    var elems2 = document.querySelectorAll('select');
    var instances2 = M.FormSelect.init(elems2, {});
});
