//SEARCH
//search for table 1
$(document).ready(function(){
    $("#search_1").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_1 tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
//serach for table 2
$(document).ready(function(){
    $("#search_2").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_2 tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
//serach for table 3
$(document).ready(function(){
    $("#search_3").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_3 tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
//serach for table 4
$(document).ready(function(){
    $("#search_4").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_4 tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
//serach for table 5
$(document).ready(function(){
    $("#search_5").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_5 tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
//serach for table 6
$(document).ready(function(){
    $("#search_6").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_6 tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
//serach for table 7
$(document).ready(function(){
    $("#search_7").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_7 tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
//serach for table 8
$(document).ready(function(){
    $("#search_8").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_8 tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
//serach for table 9
$(document).ready(function(){
    $("#search_9").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_9 tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});