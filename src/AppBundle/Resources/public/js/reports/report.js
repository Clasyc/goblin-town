
$(document).ready(function(){
    var beginDate = new Date();
    var endDate = new Date();
    beginDate.setMonth(beginDate.getMonth() - 3);
    document.getElementById('beginDate').valueAsDate = beginDate;
    document.getElementById('endDate').valueAsDate = endDate;
});


