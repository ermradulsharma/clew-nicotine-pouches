// Load my custom jquery
var appUrl = $('meta[name="csrf-token"]').attr("app-url");
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$("#login_submit").click(function () {
    var user_name = $("#user_name").val();
    var user_pass = $("#user_pass").val();

    if (user_name == "") {
        $("#errorMsg").html("Please enter Username");
        $("#user_name").focus();
        return false;
    } else if (user_pass == "") {
        $("#errorMsg").html("Please enter Password");
        $("#user_pass").focus();
        return false;
    }
});

$("#bannerForm").on("change", 'input[type="radio"]', function () {
    var bannerType = $(this).val();
    if (bannerType == "image") {
        $("#bannerForm").find("#imageRow").css("display", "block");
        $("#bannerForm").find("#videoRow").css("display", "none");
    } else {
        $("#bannerForm").find("#videoRow").css("display", "block");
        $("#bannerForm").find("#imageRow").css("display", "none");
    }
});

$("#bannerInsert").click(function () {
    removeError();
    var title = $.trim($("#title").val());
    var bannerType = $("input[name='bannerType']:checked").val();
    var thumb = $.trim($("#thumb").val());
    var image = $.trim($("#image").val());
    var poster = $.trim($("#poster").val());
    var video = $.trim($("#video").val());
    var redirect_url = $.trim($("#redirect_url").val());
    var url_validate =
        /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    var flag = true;
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (bannerType == "image") {
        if (thumb == "") {
            $("#thumb").parents(".form-group").addClass("has-error");
            $("[for=thumb] span.error").html("Please select mobile banner");
            flag = false;
        }
        if (image == "") {
            $("#image").parents(".form-group").addClass("has-error");
            $("[for=image] span.error").html("Please select desktop banner");
            flag = false;
        }
        if (redirect_url != "") {
            if (!url_validate.test(redirect_url)) {
                $("#redirect_url").parents(".form-group").addClass("has-error");
                $("[for=redirect_url] span.error").html(
                    "Please enter valid redirect url"
                );
                flag = false;
            }
        }
    } else {
        if (poster == "") {
            $("#poster").parents(".form-group").addClass("has-error");
            $("[for=poster] span.error").html("Please select poster");
            flag = false;
        }
        if (video == "") {
            $("#video").parents(".form-group").addClass("has-error");
            $("[for=video] span.error").html("Please select video");
            flag = false;
        }
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/banner",
            data: new FormData($("#bannerForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#bannerInsert", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#bannerInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#bannerForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#bannerInsert", false);
                    notify(obj.res, obj.msg);
                } else if (obj.res == "error") {
                    dataSaving("#bannerInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#bannerInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#bannerUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var bannerType = $("input[name='bannerType']:checked").val();
    var thumb = $.trim($("#thumb").val());
    var image = $.trim($("#image").val());
    var thumbOld = $.trim($("#thumbOld").val());
    var imageOld = $.trim($("#imageOld").val());
    var video = $.trim($("#video").val());
    var redirect_url = $.trim($("#redirect_url").val());
    var url_validate =
        /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (bannerType == "image") {
        if (thumb == "" && thumbOld == "") {
            $("#thumb").parents(".form-group").addClass("has-error");
            $("[for=thumb] span.error").html("Please select mobile banner");
            flag = false;
        }
        if (image == "" && imageOld == "") {
            $("#image").parents(".form-group").addClass("has-error");
            $("[for=image] span.error").html("Please select desktop banner");
            flag = false;
        }
        if (redirect_url != "") {
            if (!url_validate.test(redirect_url)) {
                $("#redirect_url").parents(".form-group").addClass("has-error");
                $("[for=redirect_url] span.error").html(
                    "Please enter valid redirect url"
                );
                flag = false;
            }
        }
    } else {
        if (video == "") {
            $("#video").parents(".form-group").addClass("has-error");
            $("[for=video] span.error").html("Please enter video code");
            flag = false;
        }
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/banner/" + $.trim($("#id").val()),
            data: new FormData($("#bannerForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#bannerUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#bannerUpdate", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#bannerUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    dataSaving("#bannerUpdate", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#bannerUpdate", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#socialInsert").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var icon = $.trim($("#icon").val());
    var url = $.trim($("#url").val());
    var url_validate =
        /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (icon == "") {
        $("#icon").parents(".form-group").addClass("has-error");
        $("[for=icon] span.error").html("Please enter icon");
        flag = false;
    }
    if (!url_validate.test(url)) {
        $("#url").parents(".form-group").addClass("has-error");
        $("[for=url] span.error").html("Please enter valid url");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/social",
            data: new FormData($("#socialForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#socialInsert", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#socialInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#socialForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#socialInsert", false);
                    notify(obj.res, obj.msg);
                } else if (obj.res == "error") {
                    dataSaving("#socialInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#socialInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#promiseInsert").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var image = $.trim($("#image").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (image == "") {
        $("#image").parents(".form-group").addClass("has-error");
        $("[for=image] span.error").html("Please select image");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/promise",
            data: new FormData($("#promiseForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#promiseInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#promiseInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#promiseForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#promiseInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "error") {
                    dataSaving("#promiseInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#promiseInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#promiseUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var image = $.trim($("#image").val());
    var imageOld = $.trim($("#imageOld").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (image == "" && imageOld == "") {
        $("#image").parents(".form-group").addClass("has-error");
        $("[for=image] span.error").html("Please select image");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/promise/" + $.trim($("#id").val()),
            data: new FormData($("#promiseForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#promiseUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#promiseUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#promiseUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#promiseUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#promiseUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#tickerInsert").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/ticker",
            data: new FormData($("#tickerForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#tickerInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#tickerInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#tickerForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#tickerInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "error") {
                    dataSaving("#tickerInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#tickerInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#tickerUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/ticker/" + $.trim($("#id").val()),
            data: new FormData($("#tickerForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#tickerUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#tickerUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#tickerUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#tickerUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#tickerUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#processInsert").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var image = $.trim($("#image").val());
    var tagline = $.trim($("#tagline").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (image == "") {
        $("#image").parents(".form-group").addClass("has-error");
        $("[for=image] span.error").html("Please select image");
        flag = false;
    }
    if (tagline == "") {
        $("#tagline").parents(".form-group").addClass("has-error");
        $("[for=tagline] span.error").html("Please enter tagline");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/process",
            data: new FormData($("#processForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#processInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#processInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#processForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#processInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "error") {
                    dataSaving("#processInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#processInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#processUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var image = $.trim($("#image").val());
    var imageOld = $.trim($("#imageOld").val());
    var tagline = $.trim($("#tagline").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (image == "" && imageOld == "") {
        $("#image").parents(".form-group").addClass("has-error");
        $("[for=image] span.error").html("Please select image");
        flag = false;
    }
    if (tagline == "") {
        $("#tagline").parents(".form-group").addClass("has-error");
        $("[for=tagline] span.error").html("Please enter tagline");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/process/" + $.trim($("#id").val()),
            data: new FormData($("#processForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#processUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#processUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#processUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#processUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#processUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#awardInsert").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var image = $.trim($("#image").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (image == "") {
        $("#image").parents(".form-group").addClass("has-error");
        $("[for=image] span.error").html("Please select image");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/award",
            data: new FormData($("#awardForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#awardInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#awardInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#awardForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#awardInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "error") {
                    dataSaving("#awardInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#awardInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#awardUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var image = $.trim($("#image").val());
    var imageOld = $.trim($("#imageOld").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (image == "" && imageOld == "") {
        $("#image").parents(".form-group").addClass("has-error");
        $("[for=image] span.error").html("Please select image");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/award/" + $.trim($("#id").val()),
            data: new FormData($("#awardForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#awardUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#awardUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#awardUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#awardUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#awardUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#countryInsert").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var image = $.trim($("#image").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (image == "") {
        $("#image").parents(".form-group").addClass("has-error");
        $("[for=image] span.error").html("Please select image");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/country",
            data: new FormData($("#countryForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#countryInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#countryInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#countryForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#countryInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "error") {
                    dataSaving("#countryInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#countryInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#countryUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var image = $.trim($("#image").val());
    var imageOld = $.trim($("#imageOld").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (image == "" && imageOld == "") {
        $("#image").parents(".form-group").addClass("has-error");
        $("[for=image] span.error").html("Please select image");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/country/" + $.trim($("#id").val()),
            data: new FormData($("#countryForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#countryUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#countryUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#countryUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#countryUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#countryUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#stateInsert").click(function () {
    removeError();
    var flag = true;
    var country_id = $.trim($("#country_id").val());
    var title = $.trim($("#title").val());
    if (country_id == "") {
        $("#country_id").parents(".form-group").addClass("has-error");
        $("[for=country_id] span.error").html("Please select country");
        flag = false;
    }
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/state",
            data: new FormData($("#stateForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#stateInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#stateInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#stateForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#stateInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "error") {
                    dataSaving("#stateInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#stateInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#stateUpdate").click(function () {
    removeError();
    var flag = true;
    var country_id = $.trim($("#country_id").val());
    var title = $.trim($("#title").val());
    if (country_id == "") {
        $("#country_id").parents(".form-group").addClass("has-error");
        $("[for=country_id] span.error").html("Please select country");
        flag = false;
    }
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/state/" + $.trim($("#id").val()),
            data: new FormData($("#stateForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#stateUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#stateUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#stateUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#stateUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#stateUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#socialUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var icon = $.trim($("#icon").val());
    var url = $.trim($("#url").val());
    var url_validate =
        /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (icon == "") {
        $("#icon").parents(".form-group").addClass("has-error");
        $("[for=icon] span.error").html("Please enter icon");
        flag = false;
    }
    if (!url_validate.test(url)) {
        $("#url").parents(".form-group").addClass("has-error");
        $("[for=url] span.error").html("Please enter valid url");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/social/" + $.trim($("#id").val()),
            data: new FormData($("#socialForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#socialUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#socialUpdate", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#socialUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    dataSaving("#socialUpdate", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#socialUpdate", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#ingredientInsert").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var image = $.trim($("#image").val());
    var description = $.trim($("#description").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (image == "") {
        $("#image").parents(".form-group").addClass("has-error");
        $("[for=image] span.error").html("Please select image");
        flag = false;
    }
    if (description == "") {
        $("#description").parents(".form-group").addClass("has-error");
        $("[for=description] span.error").html("Please enter description");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/ingredient",
            data: new FormData($("#ingredientForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#ingredientInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#ingredientInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#ingredientForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#ingredientInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "error") {
                    dataSaving("#ingredientInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#ingredientInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#ingredientUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var description = $.trim($("#description").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (description == "") {
        $("#description").parents(".form-group").addClass("has-error");
        $("[for=description] span.error").html("Please enter description");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/ingredient/" + $.trim($("#id").val()),
            data: new FormData($("#ingredientForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#ingredientUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#ingredientUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#ingredientUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#ingredientUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#ingredientUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#categoryInsert").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var image = $.trim($("#image").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (image == "") {
        $("#image").parents(".form-group").addClass("has-error");
        $("[for=image] span.error").html("Please select image");
        flag = false;
    }
    if (flag) {
        var formData = new FormData($("#categoryForm")[0]);
        formData.append(
            "description",
            CKEDITOR.instances.description.getData()
        );
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/category",
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#categoryInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#categoryInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#categoryForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#categoryInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "error") {
                    dataSaving("#categoryInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#categoryInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#categoryUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        var formData = new FormData($("#categoryForm")[0]);
        formData.append(
            "description",
            CKEDITOR.instances.description.getData()
        );
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/category/" + $.trim($("#id").val()),
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#categoryUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#categoryUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#categoryUpdate", false);
                    setTimeout(function () {
                        window.location = obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#categoryUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#categoryUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#flavourInsert").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/flavour",
            data: new FormData($("#flavourForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#flavourInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#flavourInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#flavourForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#flavourInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "error") {
                    dataSaving("#flavourInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#flavourInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#flavourUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/flavour/" + $.trim($("#id").val()),
            data: new FormData($("#flavourForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#flavourUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#flavourUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#flavourUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#flavourUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#flavourUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#strengthInsert").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/strength",
            data: new FormData($("#strengthForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#strengthInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#strengthInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#strengthForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#strengthInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "error") {
                    dataSaving("#strengthInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#strengthInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#strengthUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/strength/" + $.trim($("#id").val()),
            data: new FormData($("#strengthForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#strengthUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#strengthUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#strengthUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#strengthUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#strengthUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#labelInsert").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/label",
            data: new FormData($("#labelForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#labelInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#labelInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#labelForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#labelInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "error") {
                    dataSaving("#labelInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#labelInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#labelUpdate").click(function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/label/" + $.trim($("#id").val()),
            data: new FormData($("#labelForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#labelUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#labelUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#labelUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#labelUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#labelUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#productInsert").click(function () {
    removeError();
    var flag = true;
    var category_id = $.trim($("#category_id").val());
    var title = $.trim($("#title").val());
    var flavour_id = $.trim($("#flavour_id").val());
    var sku_code = $.trim($("#sku_code").val());
    // var mrp = $.trim($("#mrp").val());
    var price = $.trim($("#price").val());
    var base_discount = $.trim($("#base_discount").val());
    var incremental_discount = $.trim($("#incremental_discount").val());
    var max_discount = $.trim($("#max_discount").val());
    if (category_id == "") {
        $("#category_id").parents(".form-group").addClass("has-error");
        $("[for=category_id] span.error").html("Please select category");
        flag = false;
    }
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flavour_id == "") {
        $("#flavour_id").parents(".form-group").addClass("has-error");
        $("[for=flavour_id] span.error").html("Please select flavour");
        flag = false;
    }
    if (sku_code == "") {
        $("#sku_code").parents(".form-group").addClass("has-error");
        $("[for=sku_code] span.error").html("Please enter sku_code");
        flag = false;
    }
    // if(mrp=='')
    // {
    //     $("#mrp").parents(".form-group").addClass("has-error");
    //     $("[for=mrp] span.error").html('Please enter mrp');
    //     flag = false;
    // }
    if (price == "") {
        $("#price").parents(".form-group").addClass("has-error");
        $("[for=price] span.error").html("Please enter price");
        flag = false;
    }
    if (base_discount == "") {
        $("#base_discount").parents(".form-group").addClass("has-error");
        $("[for=base_discount] span.error").html("Please enter base discount");
        flag = false;
    }
    if (incremental_discount == "") {
        $("#incremental_discount").parents(".form-group").addClass("has-error");
        $("[for=incremental_discount] span.error").html(
            "Please enter incremental discount"
        );
        flag = false;
    }
    if (max_discount == "") {
        $("#max_discount").parents(".form-group").addClass("has-error");
        $("[for=max_discount] span.error").html("Please enter max discount");
        flag = false;
    }
    if (flag) {
        var formData = new FormData($("#productForm")[0]);
        // formData.append('short_description', CKEDITOR.instances.short_description.getData());
        formData.append(
            "description",
            CKEDITOR.instances.description.getData()
        );
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/product",
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#productInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#productInsert", false);
                } else if (obj.res == "success") {
                    $("#productForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#productInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "failed") {
                    notify(obj.res, obj.msg);
                    dataSaving("#productInsert", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#productInsert", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#productUpdate").click(function () {
    removeError();
    var flag = true;
    var category_id = $.trim($("#category_id").val());
    var title = $.trim($("#title").val());
    var flavour_id = $.trim($("#flavour_id").val());
    var sku_code = $.trim($("#sku_code").val());
    // var mrp = $.trim($("#mrp").val());
    // var price = $.trim($("#price").val());
    var base_discount = $.trim($("#base_discount").val());
    var incremental_discount = $.trim($("#incremental_discount").val());
    var max_discount = $.trim($("#max_discount").val());
    if (category_id == "") {
        $("#category_id").parents(".form-group").addClass("has-error");
        $("[for=category_id] span.error").html("Please select category");
        flag = false;
    }
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flavour_id == "") {
        $("#flavour_id").parents(".form-group").addClass("has-error");
        $("[for=flavour_id] span.error").html("Please select flavour");
        flag = false;
    }
    if (sku_code == "") {
        $("#sku_code").parents(".form-group").addClass("has-error");
        $("[for=sku_code] span.error").html("Please enter sku_code");
        flag = false;
    }
    // if(mrp=='')
    // {
    //     $("#mrp").parents(".form-group").addClass("has-error");
    //     $("[for=mrp] span.error").html('Please enter mrp');
    //     flag = false;
    // }
    // if(price=='')
    // {
    //     $("#price").parents(".form-group").addClass("has-error");
    //     $("[for=price] span.error").html('Please enter price');
    //     flag = false;
    // }
    if (base_discount == "") {
        $("#base_discount").parents(".form-group").addClass("has-error");
        $("[for=base_discount] span.error").html("Please enter base discount");
        flag = false;
    }
    if (incremental_discount == "") {
        $("#incremental_discount").parents(".form-group").addClass("has-error");
        $("[for=incremental_discount] span.error").html(
            "Please enter incremental discount"
        );
        flag = false;
    }
    if (max_discount == "") {
        $("#max_discount").parents(".form-group").addClass("has-error");
        $("[for=max_discount] span.error").html("Please enter max discount");
        flag = false;
    }
    if (flag) {
        var formData = new FormData($("#productForm")[0]);
        // formData.append('short_description', CKEDITOR.instances.short_description.getData());
        formData.append(
            "description",
            CKEDITOR.instances.description.getData()
        );
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/product/" + $.trim($("#id").val()),
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#productUpdate", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#productUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#productUpdate", false);
                    setTimeout(function () {
                        window.location = obj.url;
                    }, 50);
                } else if (arr[0].res == "failed") {
                    notify(obj.res, obj.msg);
                    dataSaving("#productUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#productUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$(".productImageAdd").click(function () {
    var product_id = $(this).attr("product_id");
    $.ajax({
        type: "GET",
        url: appUrl + "/admin/product/" + product_id + "/images/create",
        success: function (data) {
            $("#productImageAddModal div.modal-body").html(data);
            $("#productImageAddModal").modal("show");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

$("#productImageAddModal").on("click", "#productImageInsert", function () {
    removeError();
    var flag = true;
    var title = $.trim($("#productImageAddModal input#title").val());
    var variant_id = $.trim($("#productImageAddModal select#variant_id").val());
    var image = $.trim($("#productImageAddModal input#image").val());
    if (title == "") {
        $("#productImageAddModal input#title")
            .parents(".form-group")
            .addClass("has-error");
        $("#productImageAddModal [for=title] span.error").html(
            "Please enter title"
        );
        flag = false;
    }
    if (variant_id == "") {
        $("#productImageAddModal select#variant_id")
            .parents(".form-group")
            .addClass("has-error");
        $("#productImageAddModal [for=strength_id] span.error").html(
            "Please select variant"
        );
        flag = false;
    }
    if (image == "") {
        $("#productImageAddModal input#image")
            .parents(".form-group")
            .addClass("has-error");
        $("#productImageAddModal [for=image] span.error").html(
            "Please select image"
        );
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url:
                appUrl +
                "/admin/product/" +
                $.trim($("#product_id").val()) +
                "/images",
            data: new FormData($("#productImageAddModal #productImageForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#productImageAddModal #productImageInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#productImageAddModal input#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $(
                            "#productImageAddModal [for=" + key + "] span.error"
                        ).html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#productImageInsert", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving(
                        "#productImageAddModal #productImageInsert",
                        false
                    );
                    location.reload();
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving(
                        "#productImageAddModal #productImageInsert",
                        false
                    );
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving(
                        "#productImageAddModal #productImageInsert",
                        false
                    );
                }
            },
        });
    } else return false;
});

$(".productImageEdit").click(function () {
    var id = $(this).attr("data-id");
    var product_id = $(this).attr("data-product_id");
    $.ajax({
        type: "GET",
        url:
            appUrl + "/admin/product/" + product_id + "/images/" + id + "/edit",
        success: function (data) {
            $("#productImageEditModal div.modal-body").html(data);
            $("#productImageEditModal").modal("show");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

$("#productImageEditModal").on("click", "#productImageUpdate", function () {
    removeError();
    var flag = true;
    var id = $.trim($("#productImageEditModal input#id").val());
    var product_id = $.trim($("#productImageEditModal input#product_id").val());
    var title = $.trim($("#productImageEditModal input#title").val());
    var variant_id = $.trim(
        $("#productImageEditModal select#variant_id").val()
    );
    if (title == "") {
        $("#productImageEditModal input#title")
            .parents(".form-group")
            .addClass("has-error");
        $("#productImageEditModal [for=title] span.error").html(
            "Please enter title"
        );
        flag = false;
    }
    if (variant_id == "") {
        $("#productImageEditModal select#variant_id")
            .parents(".form-group")
            .addClass("has-error");
        $("#productImageEditModal [for=variant_id] span.error").html(
            "Please select variant"
        );
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/product/" + product_id + "/images/" + id,
            data: new FormData(
                $("#productImageEditModal #productImageForm")[0]
            ),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#productImageEditModal #productImageUpdate", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#productImageEditModal input#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $(
                            "#productImageEditModal [for=" +
                                key +
                                "] span.error"
                        ).html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#productImageUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving(
                        "#productImageEditModal #productImageUpdate",
                        false
                    );
                    location.reload();
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving(
                        "#productImageEditModal #productImageUpdate",
                        false
                    );
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving(
                        "#productImageEditModal #productImageUpdate",
                        false
                    );
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$(".productVariantAdd").click(function () {
    var product_id = $(this).attr("product_id");
    $.ajax({
        type: "GET",
        url: appUrl + "/admin/product/" + product_id + "/variants/create",
        success: function (data) {
            // console.log(data);
            $("#productVariantAddModal div.modal-body").html(data);
            $("#productVariantAddModal").modal("show");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

$("#productVariantAddModal").on("click", "#productVariantInsert", function () {
    removeError();
    var flag = true;
    var strength_id = $.trim(
        $("#productVariantAddModal select#strength_id").val()
    );
    // var qty = $.trim($("#productVariantAddModal input#qty").val());
    // var mrp = $.trim($("#productVariantAddModal input#mrp").val());
    var price = $.trim($("#productVariantAddModal input#price").val());
    var image = $.trim($("#productVariantAddModal input#image").val());
    if (strength_id == "") {
        $("#productVariantAddModal select#strength_id")
            .parents(".form-group")
            .addClass("has-error");
        $("#productVariantAddModal [for=strength_id] span.error").html(
            "Please select strength"
        );
        flag = false;
    }
    // if(qty=='')
    // {
    //     $("#productVariantAddModal input#qty").parents(".form-group").addClass("has-error");
    //     $("#productVariantAddModal [for=qty] span.error").html('Please enter qty');
    //     flag = false;
    // }
    // if(mrp=='')
    // {
    //     $("#productVariantAddModal input#mrp").parents(".form-group").addClass("has-error");
    //     $("#productVariantAddModal [for=mrp] span.error").html('Please enter mrp');
    //     flag = false;
    // }
    if (price == "") {
        $("#productVariantAddModal input#price")
            .parents(".form-group")
            .addClass("has-error");
        $("#productVariantAddModal [for=price] span.error").html(
            "Please enter price"
        );
        flag = false;
    }
    if (image == "") {
        $("#productVariantAddModal input#image")
            .parents(".form-group")
            .addClass("has-error");
        $("#productVariantAddModal [for=image] span.error").html(
            "Please select image"
        );
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url:
                appUrl +
                "/admin/product/" +
                $.trim($("#product_id").val()) +
                "/variants",
            data: new FormData(
                $("#productVariantAddModal #productVariantForm")[0]
            ),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving(
                    "#productVariantAddModal #productVariantUpdate",
                    true
                );
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#productVariantAddModal input#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $(
                            "#productVariantAddModal [for=" +
                                key +
                                "] span.error"
                        ).html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#productVariantInsert", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving(
                        "#productVariantAddModal #productVariantInsert",
                        false
                    );
                    location.reload();
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving(
                        "#productVariantAddModal #productVariantInsert",
                        false
                    );
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving(
                        "#productVariantAddModal #productVariantInsert",
                        false
                    );
                }
            },
        });
    } else return false;
});

$(".productVariantEdit").click(function () {
    var id = $(this).attr("data-id");
    var product_id = $(this).attr("data-product_id");
    $.ajax({
        type: "GET",
        url:
            appUrl +
            "/admin/product/" +
            product_id +
            "/variants/" +
            id +
            "/edit",
        success: function (data) {
            $("#productVariantEditModal div.modal-body").html(data);
            $("#productVariantEditModal").modal("show");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

$("#productVariantEditModal").on("click", "#productVariantUpdate", function () {
    removeError();
    var flag = true;
    var id = $.trim($("#productVariantEditModal input#id").val());
    var product_id = $.trim(
        $("#productVariantEditModal input#product_id").val()
    );
    var strength_id = $.trim(
        $("#productVariantEditModal select#strength_id").val()
    );
    // var qty = $.trim($("#productVariantEditModal input#qty").val());
    // var mrp = $.trim($("#productVariantEditModal input#mrp").val());
    var price = $.trim($("#productVariantEditModal input#price").val());
    if (strength_id == "") {
        $("#productVariantEditModal select#strength_id")
            .parents(".form-group")
            .addClass("has-error");
        $("#productVariantEditModal [for=strength_id] span.error").html(
            "Please select strength"
        );
        flag = false;
    }
    // if(qty=='')
    // {
    //     $("#productVariantEditModal input#qty").parents(".form-group").addClass("has-error");
    //     $("#productVariantEditModal [for=qty] span.error").html('Please enter qty');
    //     flag = false;
    // }
    // if(mrp=='')
    // {
    //     $("#productVariantEditModal input#mrp").parents(".form-group").addClass("has-error");
    //     $("#productVariantEditModal [for=mrp] span.error").html('Please enter mrp');
    //     flag = false;
    // }
    if (price == "") {
        $("#productVariantEditModal input#price")
            .parents(".form-group")
            .addClass("has-error");
        $("#productVariantEditModal [for=price] span.error").html(
            "Please enter price"
        );
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/product/" + product_id + "/variants/" + id,
            data: new FormData(
                $("#productVariantEditModal #productVariantForm")[0]
            ),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving(
                    "#productVariantEditModal #productVariantUpdate",
                    true
                );
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#productVariantEditModal input#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $(
                            "#productVariantEditModal [for=" +
                                key +
                                "] span.error"
                        ).html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#productVariantUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving(
                        "#productVariantEditModal #productVariantUpdate",
                        false
                    );
                    location.reload();
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving(
                        "#productVariantEditModal #productVariantUpdate",
                        false
                    );
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving(
                        "#productVariantEditModal #productVariantUpdate",
                        false
                    );
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#productSimilarForm").on("click", ".similars", function () {
    var id = $(this).attr("data-id");
    if ($("#similarDiv-" + id).hasClass("border-selected")) {
        $("#similarDiv-" + id)
            .removeClass("border-selected")
            .addClass("border-default");
        $("#similar-" + id).attr("checked", false);
    } else {
        $("#similarDiv-" + id)
            .removeClass("border-default")
            .addClass("border-selected");
        $("#similar-" + id).attr("checked", true);
    }
});

$("#productSimilarForm").on("click", "#productSimilarInsert", function () {
    $.ajax({
        type: "POST",
        url: appUrl + "/admin/product/" + $.trim($("#id").val()) + "/similar",
        data: new FormData($("#productSimilarForm")[0]),
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            dataSaving("#productSimilarInsert", true);
        },
        success: function (data) {
            console.log(data);
            var obj = JSON.parse(data);
            if (obj.res == "error") {
                notify(obj.res, obj.msg);
                dataSaving("#productSimilarInsert", false);
            } else if (obj.res == "success") {
                notify(obj.res, obj.msg);
                dataSaving("#productSimilarInsert", false);
                // setTimeout(function(){ window.location = appUrl+obj.url; }, 50);
                location.reload();
            } else {
                notify("error", "Something wrong, try later.");
                dataSaving("#productSimilarInsert", false);
            }
        },
    });
    return false;
});

$(".logoSearch").on("keyup", "#search", function () {
    var search = $(this).val().toLowerCase();
    $(".similars").filter(function () {
        $(this).toggle(
            $(this).attr("title").toLowerCase().indexOf(search) > -1
        );
    });
});

$("#couponForm").on("keypress", "#code", function (evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode == 32) {
        notify("error", "You can not use space in code.");
        return false;
    }
});

$("#couponForm").on("click", "#couponInsert", function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var code = $.trim($("#code").val());
    var discount_type = $.trim($("#discount_type").val());
    var discount = $.trim($("#discount").val());
    var units = $.trim($("#units").val());
    var start_date = $.trim($("#start_date").val());
    var end_date = $.trim($("#end_date").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (code == "") {
        $("#code").parents(".form-group").addClass("has-error");
        $("[for=code] span.error").html("Please enter code");
        flag = false;
    }
    if (discount_type == "") {
        $("#discount_type").parents(".form-group").addClass("has-error");
        $("[for=discount_type] span.error").html("Please enter discount type");
        flag = false;
    }
    if (discount == "") {
        $("#discount").parents(".form-group").addClass("has-error");
        $("[for=discount] span.error").html("Please enter discount");
        flag = false;
    }
    if (units == "") {
        $("#units").parents(".form-group").addClass("has-error");
        $("[for=units] span.error").html("Please enter units");
        flag = false;
    }
    // if($('input.products:checked').length <= 0) {
    //     $("#products").parents(".form-group").addClass("has-error");
    //     $("[for=products] span.error").html('Please select products');
    //     flag = false;
    // }
    if (start_date == "") {
        $("#start_date").parents(".form-group").addClass("has-error");
        $("[for=start_date] span.error").html("Please enter start date");
        flag = false;
    }
    if (end_date == "") {
        $("#end_date").parents(".form-group").addClass("has-error");
        $("[for=end_date] span.error").html("Please enter end date");
        flag = false;
    }
    if (new Date(start_date) > new Date(end_date)) {
        $("#end_date").parents(".form-group").addClass("has-error");
        $("[for=end_date] span.error").html(
            "Start date must be smaller than end date"
        );
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/coupon",
            data: new FormData($("#couponForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#couponInsert", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key).parents(".form-group").addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#couponInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#couponInsert", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#couponInsert", false);
                    location.reload();
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#couponInsert", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#couponForm").on("click", "#couponUpdate", function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var discount_type = $.trim($("#discount_type").val());
    var discount = $.trim($("#discount").val());
    var units = $.trim($("#units").val());
    var start_date = $.trim($("#start_date").val());
    var end_date = $.trim($("#end_date").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (discount_type == "") {
        $("#discount_type").parents(".form-group").addClass("has-error");
        $("[for=discount_type] span.error").html("Please enter discount type");
        flag = false;
    }
    if (discount == "") {
        $("#discount").parents(".form-group").addClass("has-error");
        $("[for=discount] span.error").html("Please enter discount");
        flag = false;
    }
    if (units == "") {
        $("#units").parents(".form-group").addClass("has-error");
        $("[for=units] span.error").html("Please enter units");
        flag = false;
    }
    // if($('input.products:checked').length <= 0) {
    //     $("#products").parents(".form-group").addClass("has-error");
    //     $("[for=products] span.error").html('Please select products');
    //     flag = false;
    // }
    if (start_date == "") {
        $("#start_date").parents(".form-group").addClass("has-error");
        $("[for=start_date] span.error").html("Please enter start date");
        flag = false;
    }
    if (end_date == "") {
        $("#end_date").parents(".form-group").addClass("has-error");
        $("[for=end_date] span.error").html("Please enter end date");
        flag = false;
    }
    if (new Date(start_date) > new Date(end_date)) {
        $("#end_date").parents(".form-group").addClass("has-error");
        $("[for=end_date] span.error").html(
            "Start date must be smaller than end date"
        );
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/coupon/" + $.trim($("#id").val()),
            data: new FormData($("#couponForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#couponUpdate", true);
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#couponUpdate", false);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#couponUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#couponUpdate", false);
                    setTimeout(function () {
                        window.location = appUrl + obj.url;
                    }, 50);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#couponUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#pageForm").on("click", "#pageInsert", function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var pageTitle = $.trim($("#pageTitle").val());
    var pageDescription = $.trim($("#pageDescription").val());
    var pageKeywords = $.trim($("#pageKeywords").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (pageTitle == "") {
        $("#pageTitle").parents(".form-group").addClass("has-error");
        $("[for=pageTitle] span.error").html("Please enter page title");
        flag = false;
    }
    if (pageDescription == "") {
        $("#pageDescription").parents(".form-group").addClass("has-error");
        $("[for=pageDescription] span.error").html(
            "Please enter page description"
        );
        flag = false;
    }
    if (pageKeywords == "") {
        $("#pageKeywords").parents(".form-group").addClass("has-error");
        $("[for=pageKeywords] span.error").html("Please enter page keywords");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/page",
            data: new FormData($("#pageForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#pageInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#pageInsert", false);
                } else if (obj.res == "success") {
                    $("#pageForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#pageInsert", false);
                    notify(obj.res, obj.msg);
                    location.reload();
                } else if (obj.res == "failed") {
                    notify(obj.res, obj.msg);
                    dataSaving("#pageInsert", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#pageInsert", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#pageForm").on("click", "#pageUpdate", function () {
    removeError();
    var flag = true;
    var title = $.trim($("#title").val());
    var pageTitle = $.trim($("#pageTitle").val());
    var pageDescription = $.trim($("#pageDescription").val());
    var pageKeywords = $.trim($("#pageKeywords").val());
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (pageTitle == "") {
        $("#pageTitle").parents(".form-group").addClass("has-error");
        $("[for=pageTitle] span.error").html("Please enter page title");
        flag = false;
    }
    if (pageDescription == "") {
        $("#pageDescription").parents(".form-group").addClass("has-error");
        $("[for=pageDescription] span.error").html(
            "Please enter page description"
        );
        flag = false;
    }
    if (pageKeywords == "") {
        $("#pageKeywords").parents(".form-group").addClass("has-error");
        $("[for=pageKeywords] span.error").html("Please enter page keywords");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/page/" + $.trim($("#id").val()),
            data: new FormData($("#pageForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#pageUpdate", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#pageUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#pageUpdate", false);
                    setTimeout(function () {
                        window.location = obj.url;
                    }, 50);
                } else if (arr[0].res == "failed") {
                    notify(obj.res, obj.msg);
                    dataSaving("#pageUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#pageUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$(".pageBannerAdd").click(function () {
    var page_id = $(this).attr("page_id");
    $.ajax({
        type: "GET",
        url: appUrl + "/admin/page/" + page_id + "/banners/create",
        success: function (data) {
            $("#pageBannerAddModal div.modal-body").html(data);
            $("#pageBannerAddModal").modal("show");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

$("#pageBannerAddModal").on("click", "#pageBannerInsert", function () {
    removeError();
    var flag = true;
    var title = $.trim($("#pageBannerAddModal input#title").val());
    var mobile = $.trim($("#pageBannerAddModal input#mobile").val());
    var desktop = $.trim($("#pageBannerAddModal input#desktop").val());
    if (title == "") {
        $("#pageBannerAddModal input#title")
            .parents(".form-group")
            .addClass("has-error");
        $("#pageBannerAddModal [for=title] span.error").html(
            "Please enter title"
        );
        flag = false;
    }
    if (mobile == "") {
        $("#pageBannerAddModal input#mobile")
            .parents(".form-group")
            .addClass("has-error");
        $("#pageBannerAddModal [for=mobile] span.error").html(
            "Please select mobile banner"
        );
        flag = false;
    }
    if (desktop == "") {
        $("#pageBannerAddModal input#desktop")
            .parents(".form-group")
            .addClass("has-error");
        $("#pageBannerAddModal [for=desktop] span.error").html(
            "Please select desktop banner"
        );
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url:
                appUrl +
                "/admin/page/" +
                $.trim($("#page_id").val()) +
                "/banners",
            data: new FormData($("#pageBannerAddModal #pageBannerForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#pageBannerAddModal #pageBannerInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#pageBannerAddModal input#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $(
                            "#pageBannerAddModal [for=" + key + "] span.error"
                        ).html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#pageBannerInsert", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#pageBannerAddModal #pageBannerInsert", false);
                    location.reload();
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#pageBannerAddModal #pageBannerInsert", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#pageBannerAddModal #pageBannerInsert", false);
                }
            },
        });
    } else return false;
});

$(".pageBannerEdit").click(function () {
    var id = $(this).attr("data-id");
    var page_id = $(this).attr("data-page_id");
    $.ajax({
        type: "GET",
        url: appUrl + "/admin/page/" + page_id + "/banners/" + id + "/edit",
        success: function (data) {
            $("#pageBannerEditModal div.modal-body").html(data);
            $("#pageBannerEditModal").modal("show");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

$("#pageBannerEditModal").on("click", "#pageBannerUpdate", function () {
    removeError();
    var flag = true;
    var id = $.trim($("#pageBannerEditModal input#id").val());
    var title = $.trim($("#pageBannerEditModal input#title").val());
    if (title == "") {
        $("#pageBannerEditModal input#title")
            .parents(".form-group")
            .addClass("has-error");
        $("#pageBannerEditModal [for=title] span.error").html(
            "Please enter title"
        );
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/page/" + page_id + "/banners/" + id,
            data: new FormData($("#pageBannerEditModal #pageBannerForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#pageBannerEditModal #pageBannerUpdate", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#pageBannerEditModal input#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $(
                            "#pageBannerEditModal [for=" + key + "] span.error"
                        ).html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#pageBannerUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#pageBannerEditModal #pageBannerUpdate", false);
                    location.reload();
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#pageBannerEditModal #pageBannerUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#pageBannerEditModal #pageBannerUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$(".logoutNow").on("click", function () {
    bootbox.confirm("Are you sure, you want to logout?", function (result) {
        if (result) $("#logout-form").submit();
        else $(".bootbox").modal("hide");
    });
});

$("input[type='password']").keypress(function (evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (evt.charCode == 32) {
        toggleSnackbar("You can not use space in password.");
        return false;
    }
});

$("#changePasswordUpdate").click(function () {
    removeError();
    var flag = true;
    var oldPassword = $.trim($("#oldPassword").val());
    var newPassword = $.trim($("#newPassword").val());
    var confirmPassword = $.trim($("#confirmPassword").val());
    if (oldPassword == "") {
        $("#oldPassword").parents(".form-group").addClass("has-error");
        $("[for=oldPassword] span.error").html("Please enter old password.");
        flag = false;
    }
    if (newPassword == "") {
        $("#newPassword").parents(".form-group").addClass("has-error");
        $("[for=newPassword] span.error").html("Please enter new password.");
        flag = false;
    }
    if (newPassword != "" && newPassword.length < 6) {
        $("#newPassword").parents(".form-group").addClass("has-error");
        $("[for=newPassword] span.error").html(
            "Please enter minimum 6 characters."
        );
        flag = false;
    }
    if (confirmPassword == "") {
        $("#confirmPassword").parents(".form-group").addClass("has-error");
        $("[for=confirmPassword] span.error").html(
            "Please enter confirm password."
        );
        flag = false;
    }
    if (
        newPassword != "" &&
        confirmPassword != "" &&
        confirmPassword != newPassword
    ) {
        $("#confirmPassword").parents(".form-group").addClass("has-error");
        $("[for=confirmPassword] span.error").html(
            "Confirm password and new password must match."
        );
        flag = false;
    }
    if (flag == true) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/change-password",
            data: new FormData($("#changePasswordForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#changePasswordUpdate", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#changePasswordUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    $("#changePasswordForm").trigger("reset");
                    dataSaving("#changePasswordUpdate", false);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#changePasswordUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#changePasswordUpdate", false);
                }
            },
        });
    }
    return false;
});

$("#from_date").datepicker({
    format: "yyyy-mm-dd",
    startDate: "",
    endDate: "yes",
    autoclose: true,
});

$("#to_date").datepicker({
    format: "yyyy-mm-dd",
    startDate: "",
    endDate: "yes",
    autoclose: true,
});

$("#start_date").datepicker({
    format: "yyyy-mm-dd",
    startDate: "yes",
    endDate: "",
    autoclose: true,
});

$("#end_date").datepicker({
    format: "yyyy-mm-dd",
    startDate: "yes",
    endDate: "",
    autoclose: true,
});

$("#websiteForm").on("click", "#websiteUpdate", function () {
    removeError();
    var flag = true;
    var title = $("#title").val();
    if (title == "") {
        $("#title").parents(".form-group").addClass("has-error");
        $("[for=title] span.error").html("Please enter title");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/website/" + $.trim($("#id").val()),
            data: new FormData($("#websiteForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#websiteUpdate", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#websiteUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#websiteUpdate", false);
                    setTimeout(function () {
                        window.location = obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#websiteUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#websiteUpdate", false);
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#subadminInsert").click(function () {
    removeError();
    var name = $.trim($("#name").val());
    var email = $.trim($("#email").val());
    var emailExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var role_id = $.trim($("#role_id").val());
    var password = $.trim($("#password").val());
    var confirmPassword = $.trim($("#confirmPassword").val());
    var flag = true;
    if (name == "") {
        $("#name").parents(".form-group").addClass("has-error");
        $("[for=name] span.error").html("Please enter name");
        flag = false;
    }
    if (email == "") {
        $("#email").parents(".form-group").addClass("has-error");
        $("[for=email] span.error").html("Please select email");
        flag = false;
    }
    if (email == "") {
        $("#email").parents(".form-group").addClass("has-error");
        $("[for=email] span.error").html("Please enter a valid email");
        flag = false;
    }
    if (!email.match(emailExp)) {
        $("#email").parents(".form-group").addClass("has-error");
        $("[for=email] span.error").html("Please enter a valid email");
        flag = false;
    }
    if (role_id == "") {
        $("#role_id").parents(".form-group").addClass("has-error");
        $("[for=role_id] span.error").html("Please select role");
        flag = false;
    }
    if (password == "") {
        $("#password").parents(".form-group").addClass("has-error");
        $("[for=password] span.error").html("Please enter password.");
        flag = false;
    }
    if (password != "" && password.length < 6) {
        $("#password").parents(".form-group").addClass("has-error");
        $("[for=password] span.error").html(
            "Please enter minimum 6 characters."
        );
        flag = false;
    }
    if (confirmPassword == "") {
        $("#confirmPassword").parents(".form-group").addClass("has-error");
        $("[for=confirmPassword] span.error").html(
            "Please enter confirm password."
        );
        flag = false;
    }
    if (
        password != "" &&
        confirmPassword != "" &&
        confirmPassword != password
    ) {
        $("#confirmPassword").parents(".form-group").addClass("has-error");
        $("[for=confirmPassword] span.error").html(
            "Confirm password and new password must match."
        );
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/subadmin",
            data: new FormData($("#subadminForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#subadminInsert", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#subadminInsert", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    $("#subadminForm").trigger("reset");
                    $(".form-group").removeClass("has-error");
                    $("span.error").html("");
                    dataSaving("#subadminInsert", false);
                    notify(obj.res, obj.msg);
                } else if (obj.res == "error") {
                    dataSaving("#subadminInsert", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#subadminInsert", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#subadminUpdate").click(function () {
    removeError();
    var flag = true;
    var name = $.trim($("#name").val());
    var email = $.trim($("#email").val());
    var emailExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var role_id = $.trim($("#role_id").val());
    if (name == "") {
        $("#name").parents(".form-group").addClass("has-error");
        $("[for=name] span.error").html("Please enter name");
        flag = false;
    }
    if (email == "") {
        $("#email").parents(".form-group").addClass("has-error");
        $("[for=email] span.error").html("Please enter a valid email");
        flag = false;
    }
    if (!email.match(emailExp)) {
        $("#email").parents(".form-group").addClass("has-error");
        $("[for=email] span.error").html("Please enter a valid email");
        flag = false;
    }
    if (role_id == "") {
        $("#role_id").parents(".form-group").addClass("has-error");
        $("[for=role_id] span.error").html("Please select role");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/subadmin/" + $.trim($("#id").val()),
            data: new FormData($("#subadminForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#subadminUpdate", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    dataSaving("#subadminUpdate", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#subadminUpdate", false);
                    setTimeout(function () {
                        window.location = obj.url;
                    }, 50);
                } else if (obj.res == "error") {
                    dataSaving("#subadminUpdate", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#subadminUpdate", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});
function restrictSpace(evt) {
    if (evt.keyCode == 32) {
        notify("error", "Space is not allowed");
        return false;
    }
}

$(".resetPassword").click(function () {
    removeError();
    var id = $(this).attr("data-id");
    $("#resetPasswordModal #id").val(id);
    $("#resetPasswordForm").trigger("reset");
    $("#resetPasswordModal").modal("show");
});

$("#resetPasswordUpdate").click(function () {
    removeError();
    var flag = true;
    var id = $("#resetPasswordModal #id").val();
    var newPassword = $.trim($("#newPassword").val());
    var confirmPassword = $.trim($("#confirmPassword").val());
    if (newPassword == "") {
        $("#newPassword").parents(".form-group").addClass("has-error");
        $("[for=newPassword] span.error").html("Please enter new password.");
        flag = false;
    }
    if (newPassword != "" && newPassword.length < 6) {
        $("#newPassword").parents(".form-group").addClass("has-error");
        $("[for=newPassword] span.error").html(
            "Please enter minimum 6 characters."
        );
        flag = false;
    }
    if (confirmPassword == "") {
        $("#confirmPassword").parents(".form-group").addClass("has-error");
        $("[for=confirmPassword] span.error").html(
            "Please enter confirm password."
        );
        flag = false;
    }
    if (
        newPassword != "" &&
        confirmPassword != "" &&
        confirmPassword != newPassword
    ) {
        $("#confirmPassword").parents(".form-group").addClass("has-error");
        $("[for=confirmPassword] span.error").html(
            "Confirm password and new password must match."
        );
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/reset-password",
            data: new FormData($("#resetPasswordForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#resetPasswordUpdate", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parents(".form-group")
                            .addClass("has-error");
                        $("[for=" + key + "] span.error").html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#resetPasswordUpdate", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    $("#resetPasswordForm").trigger("reset");
                    dataSaving("#resetPasswordUpdate", false);
                    $("#resetPasswordModal").modal("hide");
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#resetPasswordUpdate", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#resetPasswordUpdate", false);
                }
            },
        });
    }
    return false;
});

$(".preferredData").click(function () {
    var id = $(this).attr("data-id");
    var alias = $(this).attr("data-alias");
    $.ajax({
        type: "POST",
        url: appUrl + "/admin/dashboard/preferredData",
        data: { id: id, alias: alias },
        success: function (data) {
            if (data.res == "failed") notify("error", data.msg);
            else if (data.res == "success") preferredData(id);
            else notify("error", "Something wrong, try later.");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

function preferredData(id) {
    $(".preferredData i")
        .addClass("glyphicon-star-empty")
        .removeClass("glyphicon-star");
    $("#preferredData-" + id + " i")
        .addClass("glyphicon-star")
        .removeClass("glyphicon-star-empty");
    notify("success", "Data updated successfully.");
}

$(".positionData").click(function () {
    var id = $(this).attr("data-id");
    var alias = $(this).attr("data-alias");
    var position = $.trim($("#position-" + id).val());
    if (position == "") {
        notify("error", "Please enter postion.");
        $("#position-" + id).focus();
        return false;
    } else {
        $.ajax({
            type: "POST",
            url: appUrl + "/admin/dashboard/positionData",
            data: { id: id, alias: alias, position: position },
            success: function (data) {
                if (data) notify(data.res, data.msg);
                else notify("error", "Something wrong, try later.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                notify("error", "Something wrong, try later.");
            },
        });
    }
    return false;
});

$(".preferredStarData").click(function () {
    var id = $(this).attr("data-id");
    var alias = $(this).attr("data-alias");
    $.ajax({
        type: "POST",
        url: appUrl + "/admin/dashboard/preferredStarData",
        data: { id: id, alias: alias },
        success: function (data) {
            if (data.res == "failed") notify("error", data.msg);
            else if (data.res == "success") preferredStarData(id, data.status);
            else notify("error", "Something wrong, try later.");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

function preferredStarData(id, status) {
    if (status) {
        $("#preferredStarData-" + id)
            .addClass("text-danger")
            .removeClass("text-mute");
        $("#preferredStarData-" + id + " i")
            .addClass("fa-heart")
            .removeClass("fa-heart-o");
    } else {
        $("#preferredStarData-" + id)
            .addClass("text-mute")
            .removeClass("text-danger");
        $("#preferredStarData-" + id + " i")
            .addClass("fa-heart-o")
            .removeClass("fa-heart");
    }
    notify("success", "Preference updated successfully.");
}

$(".showOnCart").click(function () {
    var id = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        url: appUrl + "/admin/product/showOnCart",
        data: { id: id },
        success: function (data) {
            if (data.res == "failed") notify("error", data.msg);
            else if (data.res == "success") showOnCart(id);
            else notify("error", "Something wrong, try later.");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

function showOnCart(id) {
    $(".showOnCart i").addClass("fa-bell-o").removeClass("fa-bell");
    $("#showOnCart-" + id + " i")
        .addClass("fa-bell")
        .removeClass("fa-bell-o");
    notify("success", "This product will be displayed in the cart.");
}

$(".featuredData").click(function () {
    var id = $(this).attr("data-id");
    var alias = $(this).attr("data-alias");
    $.ajax({
        type: "POST",
        url: appUrl + "/admin/dashboard/featuredData",
        data: { id: id, alias: alias },
        success: function (data) {
            if (data.res == "success") featuredData(id, data.status);
            else notify("error", "Something wrong, try later.");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

function featuredData(id, status) {
    if (status)
        $("#featuredData-" + id + " i")
            .addClass("glyphicon-star")
            .removeClass("glyphicon-star-empty");
    else
        $("#featuredData-" + id + " i")
            .addClass("glyphicon-star-empty")
            .removeClass("glyphicon-star");
    notify("success", "Featured updated successfully.");
}

$(".publishData").click(function () {
    var id = $(this).attr("data-id");
    var alias = $(this).attr("data-alias");
    $.ajax({
        type: "POST",
        url: appUrl + "/admin/dashboard/publishData",
        data: { id: id, alias: alias },
        success: function (data) {
            if (data.res == "failed") notify("error", data.msg);
            else if (data.res == "success") publishData(id, data.status);
            else notify("error", "Something wrong, try later.");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

function publishData(id, status) {
    if (status) {
        $("#publishData-" + id)
            .addClass("text-success")
            .removeClass("text-warning");
        $("#publishData-" + id + " i")
            .addClass("fa-check-circle")
            .removeClass("fa-times-circle");
    } else {
        $("#publishData-" + id)
            .addClass("text-warning")
            .removeClass("text-success");
        $("#publishData-" + id + " i")
            .addClass("fa-times-circle")
            .removeClass("fa-check-circle");
    }
    notify("success", "Status updated successfully.");
}

$(".deleteImage").click(function () {
    var id = $(this).attr("data-id");
    var alias = $(this).attr("data-alias");
    bootbox.confirm(
        "Are you sure, you want to delete this image?",
        function (result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: appUrl + "/admin/dashboard/deleteImage",
                    data: { id: id, alias: alias },
                    success: function (data) {
                        var obj = parseJson(data);
                        if (obj.res == "failed") notify("error", obj.msg);
                        else if (obj.res == "success") {
                            notify("success", "Image deleted successfully.");
                            location.reload();
                        } else notify("error", "Something wrong, try later.");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        notify("error", "Something wrong, try later.");
                    },
                });
            }
        }
    );
    return false;
});

$(".deleteData").click(function () {
    var id = $(this).attr("data-id");
    var alias = $(this).attr("data-alias");
    bootbox.confirm(
        "Are you sure, you want to delete this?",
        function (result) {
            if (result) {
                $.ajax({
                    type: "POST",
                    url: appUrl + "/admin/dashboard/deleteData",
                    data: { id: id, alias: alias },
                    success: function (data) {
                        var obj = parseJson(data);
                        if (obj.res == "failed") notify("error", obj.msg);
                        else if (obj.res == "success") deleteData(id);
                        else notify("error", "Something wrong, try later.");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        notify("error", "Something wrong, try later.");
                    },
                });
            }
        }
    );
    return false;
});

function deleteData(id) {
    $("#row-" + id).fadeOut(300, function () {
        $("#row-" + id).hide();
    });
    notify("success", "Data deleted successfully.");
}

function dataResponse(id = false, data) {
    if (data.res == "invalid") notify("error", data.msg);
    else if (data.res == "success") notify("success", data.msg);
    else if (data.res == "empty") notify("error", data.msg);
    else if (data.res == "exist") notify("error", data.msg);
    else if (data.res == "failed") notify("error", data.msg);
    else notify("error", data.msg);
    if (id) dataSaving(id, false);
    if (data.loc)
        setTimeout(function () {
            window.location = data.loc;
        }, 1000);
}

function dataSaving(id, status) {
    if (status)
        $(id)
            .attr("disabled", true)
            .html('<i class="fa fa-refresh fa-spin"></i> Saving...');
    else $(id).attr("disabled", false).html("Save");
}

function dataSubmit(id, text, status) {
    if (status)
        $(id)
            .attr("disabled", true)
            .html('<i class="fa fa-refresh fa-spin"></i> ' + text);
    else $(id).attr("disabled", false).html(text);
}

function removeError() {
    $(".form-group").removeClass("has-error");
    $(".cke_chrome").css("border-color", "#d1d1d1");
    $("span.error").html("");
}

function parseJson(data) {
    return JSON.parse(JSON.stringify(data));
}

$(".notify").click(function () {
    notify("error", "Can not update.");
    loader("#cmsInsert", "Saving...", true);
    setTimeout(function () {
        loader("#cmsInsert", "Save", false);
    }, 5000);
});

$(".search-form #searchNow").click(function () {
    var flag = false;
    $("[mandatory]").each(function () {
        if ($(this).val() != "") flag = true;
    });
    if (!flag) notify("error", "Enter your search criteria!");
    return flag;
});

$(document).ready(function () {
    $("body").tooltip({ selector: "[data-toggle=tooltip]" });
});

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});

function loader(id, text, status = false) {
    if (status) {
        $(id).html('<i class="fa fa-spinner fa-spin"></i> ' + text);
        $(id).attr("disabled", "disabled");
    } else if (!status) {
        $(id).html(text);
        $(id).removeAttr("disabled");
    }
}

function notify(context = "info", message = "info") {
    toastr.options = {
        timeOut: "5000",
        closeButton: true,
    };
    toastr.remove();
    toastr[context](message, "", { positionClass: "toast-bottom-center" });
}

function numbersonly(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
}

function decimalsonly(txt, evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode == 46) {
        //Check if the text already contains the . character
        if (txt.value.indexOf(".") === -1) {
            return true;
        } else {
            return false;
        }
    } else {
        if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
    }
    return true;
}
