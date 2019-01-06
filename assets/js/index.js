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
                        $("#problem .mainbox_content a button").show();
                    }
                    else {
                        $("#problem .mainbox_content a button").hide();
                    }
                    set_problem();

                    $("#explain .make_problem").hide();
                    $("#explain .show_problem").show();
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
                        success: function() {
                            set_group();
                        },
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

var index = 0;
function get_problem() {
    $("#problem li").click(function() {
        index = $(this).index();
        var object = problems[index];
        $("#explain .mainbox_content h3").text(object['title']);
        $("#explain .mainbox_content p").html(object['content']);
        upload_answer();
    });
}

function upload_answer() {
    $("#upload .input-group-append").click(function() {
        if ($("#upload input").val() == "") {
            alert("Upload file!");
        }
        else {
            var group_name = $("#group .selected").text().trim();
            var data = new FormData($("#upload form")[0]);
            $.ajax({
                url: "/problem/enrollment/" + problems[index].id,
                type: "post",
                data: data,
                success: function(data) {
                    $("#result ol").html("");
                    do_result();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
}

var get_compile = function(p_id) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: "/problem/try/" + p_id,
            data: {"compile": true},
            type: "get",
            success: function(result) {
                if (result != "1") reject("Fail to compile");
                else resolve("Success");
            }
        });
    });
}

var get_result = function(p_id) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: "/problem/try/" + p_id,
            type: "get",
            success: function(result) {
                console.log(result);
                resolve(result);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
                reject([jqXHR, textStatus, errorThrown]);
            }
        });
    });
}

function do_result() {
    get_compile(problems[index].id)
    .then(function () {
        $("#result ol").append("<li>Compile : <span class='text-success'>Success</span></li>");
        return get_result(problems[index].id);
    }, function() {
        $("#result ol").append("<li>Compile : <span class='text-danger'>Fail</span></li>");
        throw new Error("Stop");
    })
    .then(function(result) {
        var all = true;
        for (var i = 1; i <= Object.keys(result).length; i++) {
            if (result[i.toString()] == 1)
                $("#result ol").append("<li>Run " + i + " : <span class='text-success'>Success</span></li>");
            else {
                $("#result ol").append("<li>Run " + i + " : <span class='text-danger'>Fail</span></li>");
                all = false;
            }
        }
        if (all == true)
            $("#result ol").append("<li><span class='text-success'>Clear!</span></li>");
    })
    .catch(function(e) {});
}