function set_group() {
    $.ajax({
        url: '/group',
        type: 'post',
        success: function(data) {
            $("#group ul").html("");
            if (data != null) {
                var img_class = "";
                for (var i = 0; i < data.length; i++) {
                    if (data[i].status == 0) img_class = "fas fa-spinner";
                    else if (data[i].status == 1) img_class = "fas fa-check text-success"
                    else img_class = "fas fa-crown"
                    $("#group ul").append("<li><span class='" + img_class + "'></span>&nbsp;&nbsp;" + data[i].name + "</li>");
                }

                $("#group li").click(function() {
                    $(this).siblings().removeClass('selected g_select');
                    $(this).addClass('selected g_select');

                    if ($(this).children('span').hasClass('fa-crown')) {
                        $("#problem .list").css('height', '62vh');
                        $("#problem .mainbox_content a button").show();
                    }
                    else {
                        $("#problem .list").css('height', '68vh');
                        $("#problem .mainbox_content a button").hide();
                    }
                    set_problem();
                });
            }
        }
    });
}

function search_group() {
    $("#group .input-group button").click(function() {
        $.ajax({
            url: '/group/find?word=' + $("#group .input-group input")[0].value,
            success: function(data) {
                $("#group ul").html("");
                for (var i = 0; i < data.length; i++)
                    $("#group ul").append("<li><span class='fas fa-spinner'></span>&nbsp;&nbsp;" + data[i].name + "</li>");
                
                // Event on
                $("#group ul > li").on('click', function() {
                    $.ajax({
                        url: '/group/join?name=' + $(this).text().trim(),
                        type: 'get',
                        error: function(e) {
                            alert("Error on join group.");
                        }
                    })
                });
            }
        });
    });
}

function reset_group() {
    $("#group input").keyup(function() {
        if ($(this).val() == "") {
            $("#group ul > li").off('click');
            set_group();
        }
    });
}

var problems = null;
function set_problem() {
    var group_name = $("#group .selected").text().trim();
    $.ajax({
        url: '/problem/show/' + group_name,
        type: 'get',
        success: function(data) {
            problems = data;
            $("#problem ul").html("");
            for (var i = 0; i < data.length; i++) {
                // Is solved?
                $("#problem ul").append("<li><span class='fas fa-spinner'></span>&nbsp;&nbsp;" + data[i].title + "</li>");
            }
            get_problem();
        }
    });
}

function get_problem() {
    $("#problem li").click(function() {
        var object = problems[$(this).index()];
        $("#explain .mainbox_content h3").text(object['title']);
        $("#explain .mainbox_content p").html(object['content']);
    });
}