var appUrl = $('meta[name="csrf-token"]').attr("app-url");
var currentUrl = $('meta[name="csrf-token"]').attr("current-url");
$.ajaxSetup({
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
});

$("#legalAge").click(function () {
    $.ajax({
        type: "POST",
        url: appUrl + "/age-verification",
        success: function (obj) {
            window.location.href = obj.redirect_url;
        },
    });
});

$(".age-restricted-box").on("click", "#invalidAge", function () {
    $(".age-restricted-box").find(".invalidAge").fadeIn();
    return false;
});

$(".invalidAge").on("click", ".close", function () {
    $(".invalidAge").fadeOut();
    return false;
});

$("#loginForm").on("submit", function () {
    $("#loginForm").find("span").html("");
    flag = true;
    var email = $("#loginForm").find("#email").val();
    var emailExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var password = $("#loginForm").find("#password").val();

    if (email == "") {
        $("#loginForm")
            .find("#email")
            .parent()
            .find("span")
            .html("Please enter Email ID");
        flag = false;
    }
    if (!email.match(emailExp)) {
        $("#loginForm")
            .find("#email")
            .parent()
            .find("span")
            .html("Please enter a valid Email ID");
        flag = false;
    }
    if (password == "") {
        $("#loginForm")
            .find("#password")
            .parent()
            .find("span")
            .html("Please enter password");
        flag = false;
    }
    return flag;
});

$("#signupForm").on("submit", function () {
    $("#signupForm").find("span").html("");
    flag = true;
    var first_name = $("#signupForm").find("#first_name").val();
    var last_name = $("#signupForm").find("#last_name").val();
    var email = $("#signupForm").find("#email").val();
    var emailExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var password = $("#signupForm").find("#password").val();
    var confirm_password = $("#signupForm").find("#password-confirm").val();

    if (first_name == "") {
        $("#signupForm")
            .find("#first_name")
            .parent()
            .find("span")
            .html("Please enter First name");
        flag = false;
    }
    if (last_name == "") {
        $("#signupForm")
            .find("#last_name")
            .parent()
            .find("span")
            .html("Please enter Last name");
        flag = false;
    }
    if (email == "") {
        $("#signupForm")
            .find("#email")
            .parent()
            .find("span")
            .html("Please enter Email ID");
        flag = false;
    }
    if (!email.match(emailExp)) {
        $("#signupForm")
            .find("#email")
            .parent()
            .find("span")
            .html("Please enter a valid Email ID");
        flag = false;
    }
    if (password == "") {
        $("#signupForm")
            .find("#password")
            .parent()
            .find("span")
            .html("Please enter password");
        flag = false;
    }
    if (password.length < 12 || password.length > 20) {
        $("#signupForm")
            .find("#password")
            .parent()
            .find("span")
            .html("Password must have 12-20 characters");
        flag = false;
    }
    if (password.match(/\s/g)) {
        $("#signupForm")
            .find("#password")
            .parent()
            .find("span")
            .html("Password can not contain any space");
        flag = false;
    }
    if (confirm_password == "") {
        $("#signupForm")
            .find("#password-confirm")
            .parent()
            .find("span")
            .html("Please enter confirm password");
        flag = false;
    }
    if (password != confirm_password) {
        $("#signupForm")
            .find("#password-confirm")
            .parent()
            .find("span")
            .html("Confirm password does not match");
        flag = false;
    }
    if (!$("#signupForm").find("#tnc").is(":checked")) {
        $("#signupForm")
            .find("#responseMsg")
            .find("span")
            .html("You must accept our T&C.");
        flag = false;
    }
    return flag;
});

$("#productMultiSlider")
    .find(".productMultiSlider")
    .each(function () {
        var product_id = $(this).attr("product_id");
        var variant_id = $(this).attr("variant_id");
        $("#productMultiSlider")
            .find(".slider_" + product_id + "_" + variant_id)
            .slick({
                dots: true,
                infinite: true,
                autoplay: false,
                adaptiveHeight: true,
                slidesToShow: 1,
            });
    });

$(".product-share-button").on("click", () => {
    var product_title = $(".product-share-button").attr("product-title");
    var product_url = $(".product-share-button").attr("product-url");
    console.log(product_url);

    if (navigator.share) {
        navigator
            .share({
                title: product_title,
                //text: 'Take a look at this spec!',
                url: product_url,
            })
            .then(() => console.log("Successful share"))
            .catch((error) => console.log("Error sharing", error));
        //alert("run this code");
    } else {
        console.log("Share not supported on this browser, do it the old way.");
        //alert("failed this code");
    }
});

$("#contactUsSubmit").dblclick(function () {
    console.log("Double click");
    return false;
});

$("#contactUsForm").on("click", "#contactUsSubmit", function () {
    $("#contactUsForm").find("#responseMsg").html("&nbsp;");
    $("#contactUsForm").find("span").html("");
    var flag = true;
    var first_name = $.trim($("#contactUsForm #first_name").val());
    var last_name = $.trim($("#contactUsForm #last_name").val());
    var enquiry_type = $.trim($("#contactUsForm #enquiry_type").val());
    var email = $.trim($("#contactUsForm #email").val());
    var emailExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var country_code = $.trim(
        parseInt($("#contactUsForm #country_code").val())
    );
    var phone_no = $.trim(parseInt($("#contactUsForm #phone_no").val()));
    var message = $.trim($("#contactUsForm #message").val());

    if (first_name == "") {
        $("#contactUsForm #first_name")
            .parent("div")
            .find("span")
            .html("Please enter first name");
        flag = false;
    }
    if (last_name == "") {
        $("#contactUsForm #last_name")
            .parent("div")
            .find("span")
            .html("Please enter last name");
        flag = false;
    }
    if (enquiry_type == "") {
        $("#contactUsForm #enquiry_type")
            .parent("div")
            .find("span")
            .html("Please select enquiry type");
        flag = false;
    }
    if (email == "") {
        $("#contactUsForm #email")
            .parent("div")
            .find("span")
            .html("Please enter a valid email");
        flag = false;
    }
    if (!email.match(emailExp)) {
        $("#contactUsForm #email")
            .parent("div")
            .find("span")
            .html("Please enter a valid email");
        flag = false;
    }
    if (country_code == "") {
        $("#contactUsForm #country_code")
            .parent("div")
            .parent("div")
            .find("span")
            .html("Please enter a valid phone no. with country code");
    }
    if (phone_no == "") {
        $("#contactUsForm #phone_no")
            .parent("div")
            .parent("div")
            .find("span")
            .html("Please enter a valid phone no. with country code");
        flag = false;
    }
    if (phone_no.length != "10") {
        $("#contactUsForm #phone_no")
            .parent("div")
            .parent("div")
            .find("span")
            .html("Please enter a valid phone no. with country code");
        flag = false;
    }
    if (/^[a-zA-Z0-9- ]*$/.test(phone_no) == false) {
        $("#contactUsForm #phone_no")
            .parent("div")
            .parent("div")
            .find("span")
            .html("Please enter a valid phone no. with country code");
        flag = false;
    }
    if (message == "") {
        $("#contactUsForm #message")
            .parent("div")
            .find("span")
            .html("Please enter your message");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/contactSave",
            data: new FormData($("#contactUsForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $("#contactUsSubmit").attr("disabled", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "error") {
                    $("#contactUsSubmit").attr("disabled", false);
                    notify(obj.res, obj.msg);
                } else if (obj.res == "success") {
                    $("#contactUsForm").trigger("reset");
                    $("#contactUsSubmit").attr("disabled", false);
                    notify(obj.res, obj.msg);
                } else {
                    $("#contactUsSubmit").attr("disabled", false);
                    $("#contactUsForm #" + obj.res)
                        .parent("div")
                        .find("span")
                        .html(obj.msg);
                    $("#contactUsForm #" + obj.res).focus();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#contactUsSubmit").attr("disabled", false);
                notify("error", "Something went wrong, please try later.");
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#newsletterSubmit").dblclick(function () {
    console.log("Double click");
    return false;
});

$("#newsletterForm").on("click", "#newsletterSubmit", function () {
    var email = $.trim($("#newsletterForm #email_address").val());
    var emailExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (email == "") {
        notify("error", "Please enter a valid email");
        $("#newsletterForm #email").focus();
        return false;
    }
    if (!email.match(emailExp)) {
        notify("error", "Please enter a valid email");
        $("#newsletterForm #email").focus();
        return false;
    }

    $.ajax({
        type: "POST",
        url: appUrl + "/newsletterSubscriptionSave",
        data: new FormData($("#newsletterForm")[0]),
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $("#newsletterSubmit").attr("disabled", true);
        },
        success: function (data) {
            var obj = JSON.parse(data);
            if (obj.res == "error") {
                $("#newsletterSubmit").attr("disabled", false);
                notify(obj.res, obj.msg);
            }
            if (obj.res == "success") {
                $("#newsletterForm").trigger("reset");
                $("#newsletterSubmit").attr("disabled", false);
                notify(obj.res, obj.msg);
            } else {
                $("#newsletterSubmit").attr("disabled", false);
                $("#responseMsg").html(obj.msg);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#newsletterSubmit").attr("disabled", false);
            notify("error", "Something went wrong, please try later.");
        },
    });
    return false;
});

$("#searchBox-d").on("keyup", "#searchDKey", function () {
    var searchQuery = $(this).val();
    if (searchQuery.length > 2) {
        $.ajax({
            type: "POST",
            url: appUrl + "/searchSuggestions",
            data: { searchQuery: searchQuery },
            success: function (data) {
                $("#searchBox-d").find("#search-results").html(data);
            },
        });
    } else $("#searchBox-d").find("#search-results").html("");
});

$("#searchBox-d").on("click", "#searchDSubmit", function () {
    var searchQuery = $("#searchBox-d").find("#searchDKey").val();
    if (searchQuery == "") {
        notify("error", "Please enter search query");
        $("#searchBox-d").find("#searchDKey").focus();
        return false;
    } else window.location = appUrl + "/search/" + searchQuery;
    return false;
});

$("#searchBox-r").on("keyup", "#searchKey", function () {
    var searchQuery = $(this).val();
    if (searchQuery.length > 2) {
        $.ajax({
            type: "POST",
            url: appUrl + "/searchSuggestions",
            data: { searchQuery: searchQuery },
            success: function (data) {
                $("#searchBox-r").find("#search-results").html(data);
            },
        });
    } else $("#searchBox-r").find("#search-results").html("");
});

$("#searchBox-r").on("click", "#searchSubmit", function () {
    var searchQuery = $("#searchBox-r").find("#searchKey").val();
    if (searchQuery == "") {
        notify("error", "Please enter search query");
        $("#searchBox-r").find("#searchKey").focus();
        return false;
    } else window.location = appUrl + "/search/" + searchQuery;
    return false;
});

$(document).on("click", function () {
    $(".productQtyBox").hide();
});

$(
    "#productListing, #productDetail, #wishlistProducts, #youMayLikeProducts, #recentlyViewedProducts"
).on("click", ".displayPrice", function (event) {
    event.stopPropagation();
    $(".productQtyBox").not($(this).next()).hide();
    $(this).next(".productQtyBox").toggle();
});

// $("#productListing, #wishlistProducts, #youMayLikeProducts, #recentlyViewedProducts").on("click",".variant", function(event)
// {
//   event.stopPropagation();
//   var product_id = $(this).attr('product-id');
//   var variant_id = $(this).attr('variant-id');
//   var variant_image = $(this).attr('variant-image');
//   $("#productListing, #wishlistProducts, #youMayLikeProducts, #recentlyViewedProducts").find("#productImage-"+product_id).attr('src', variant_image);

//   if($("#variant-"+product_id).hasClass("disabled")) return false;
//   var qty = $("#productQtyBox-"+product_id).find(".qtySelected").attr("qty");

//   $("#productBox-"+product_id).find(".variant").removeClass('selected');
//   $(this).addClass('selected');
//   $.ajax({
//     type: "POST",
//     url : appUrl+"/product/base_discount",
//     data:  { 'product_id': product_id, 'variant_id': variant_id, 'qty': qty },
//     beforeSend:function(){  },
//     success: function(data)
//     {
//       if(data.res=="success")
//       {
//         $("#price-"+product_id).html(data.html);
//         $("#productQtyBox-"+product_id).find("#qtyList-"+product_id).html(data.priceDropDown);
//       }
//       else
//         notify(data.res,data.msg);
//     }
//   });
// });

$(
    "#productListing, #wishlistProducts, #youMayLikeProducts, #recentlyViewedProducts"
).on("change", ".strength", function () {
    var variant_id = $(this).val();
    var product_id = $("option:selected", this).attr("product-id");
    var variant_image = $("option:selected", this).attr("variant-image");
    $(this).parents(".boxes").find("img").attr("src", variant_image);
    var productPrice = $(this).parents(".boxes").find(".productPrice");
    var productQtyPrice = $(this).parents(".boxes").find(".productQtyPrice");

    if ($(this).parents(".boxes").find("select").hasClass("disabled"))
        return false;

    var qty = $(this).parents(".boxes").find(".qtySelected").attr("qty");

    $.ajax({
        type: "POST",
        url: appUrl + "/product/base_discount",
        data: { product_id: product_id, variant_id: variant_id, qty: qty },
        beforeSend: function () {},
        success: function (data) {
            if (data.res == "success") {
                productPrice.html(data.html);
                productQtyPrice.html(data.priceDropDown);
            } else notify(data.res, data.msg);
        },
    });
    // $("#productListing, #wishlistProducts, #youMayLikeProducts").find("#product-variant-"+variant_id).trigger("click");
});

$(
    "#productListing, #wishlistProducts, #youMayLikeProducts, #recentlyViewedProducts"
).on("click", ".chooseQty", function () {
    var product_id = $(this).attr("product-id");
    var variant_id = $(this).attr("variant-id");
    var qty = $(this).attr("qty");

    $(this).parents(".boxes").find(".chooseQty").removeClass("qtySelected");
    $(this).addClass("qtySelected");

    $(this).parents(".boxes").find(".productQtyBox").hide();
    $(this)
        .parents(".boxes")
        .find(".productQtySel")
        .html(qty + " can");

    var productPrice = $(this).parents(".boxes").find(".productPrice");

    $.ajax({
        type: "POST",
        url: appUrl + "/product/base_discount",
        data: { product_id: product_id, variant_id: variant_id, qty: qty },
        beforeSend: function () {},
        success: function (data) {
            if (data.res == "success") productPrice.html(data.html);
            else notify(data.res, data.msg);
        },
    });
});

$(
    "#productListing, #wishlistProducts, #youMayLikeProducts, #recentlyViewedProducts"
).on("click", ".add_to_cart", function () {
    var product_id = $(this).attr("product-id");
    var variant = $(this).parents(".boxes").find("select").val();
    var qty = $(this).parents(".boxes").find(".qtySelected").attr("qty");

    if (variant === undefined) {
        notify("error", "Choose your preferred strength.");
        return false;
    }

    if (qty === undefined) {
        notify("error", "Choose your preferred quantity.");
        return false;
    }

    var productQtySection = $(this)
        .parents(".boxes")
        .find(".productQtySection");
    var strength = $(this).parents(".boxes").find(".strength");
    var viewCart = $(this).parents(".boxes").find(".viewCart");

    if (product_id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/cart",
            data: { product_id: product_id, variant: variant, qty: qty },
            beforeSend: function () {
                // dataSaving('#product-'+product_id, 'Add', true);
            },
            success: function (obj) {
                if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    $("#cartIcon").find("strong").html(obj.items);

                    // $('#productListing, #wishlistProducts').find("#variant-"+product_id).addClass('disabled');
                    // $('#productListing, #wishlistProducts').find("#productQtySection-"+product_id).html(obj.qtyBox);

                    // strength.addClass('disabled');
                    // productQtySection.html(obj.qtyBox);
                    viewCart.html(
                        "<a href='" + appUrl + "/cart'>View Cart >></a>"
                    );

                    $("#cartSection").load(appUrl + "/cart/reloadCart");
                    // dataSaving('#product-'+product_id, 'Add', false);
                } else {
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$(
    "#productListing, #wishlistProducts, #youMayLikeProducts, #recentlyViewedProducts"
).on("click", ".increase_qty", function () {
    var id = $(this).attr("cart-id");
    var product_id = $(this).attr("product-id");
    var productQtyInput = $(this).parents(".boxes").find(".productQtyInput");
    if (id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/cart/itemIncrease",
            data: { id: id },
            beforeSend: function () {},
            success: function (data) {
                if (data.res == "success") {
                    // $("#productQtySection-"+product_id).find("#item-qty-"+id).val(data.qty);
                    productQtyInput.val(data.qty);
                    // notify(data.res,data.msg);
                } else notify(data.res, data.msg);
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$(
    "#productListing, #wishlistProducts, #youMayLikeProducts, #recentlyViewedProducts"
).on("click", ".decrease_qty", function () {
    var id = $(this).attr("cart-id");
    var product_id = $(this).attr("product-id");
    var productQtyInput = $(this).parents(".boxes").find(".productQtyInput");
    if (id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/cart/itemDecrease",
            data: { id: id },
            beforeSend: function () {},
            success: function (data) {
                if (data.res == "success") {
                    // $("#productQtySection-"+product_id).find("#item-qty-"+id).val(data.qty);
                    productQtyInput.val(data.qty);
                    // notify(data.res,data.msg);
                } else notify(data.res, data.msg);
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#productListing, #wishlistProducts, #youMayLikeProducts, #recentlyViewedProducts").on("click", ".add_to_wishlist", function () {
    var product_id = $(this).attr("product-id");
    var productWishlist = $(this).parents(".boxes").find(".productWishlist");
    if (product_id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/itemWishlist",
            data: { product_id: product_id },
            beforeSend: function () {},
            success: function (data) {
                if (data.res == "success") {
                    if (data.wishlisted)
                        productWishlist.find("i").removeClass("fa-heart-o").addClass("fa-heart");
                    else
                        productWishlist.find("i").removeClass("fa-heart").addClass("fa-heart-o");
                    notify(data.res, data.msg);
                } else {
                    notify(data.res, data.msg);
                    setTimeout(function () {
                        window.location = appUrl + "/login";
                    }, 10);
                }
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#productDetail").on("click", ".variant", function () {
    var product_id = $(this).attr("product-id");
    var variant_id = $(this).attr("variant-id");
    // var qty = $("#qty").find(".selected").attr("qty");
    var qty = $("#productQtyBox").find(".qtySelected").attr("qty");

    $("#productDetail").find(".variant").removeClass("selected");
    $(this).addClass("selected");

    $.ajax({
        type: "POST",
        url: appUrl + "/product/incremental_discount",
        data: { product_id: product_id, variant_id: variant_id, qty: qty },
        beforeSend: function () {
            $("#overlay").fadeIn(300);
            $("#productMultiSlider")
                .find(".productMultiSlider")
                .addClass("hide");
        },
        success: function (data) {
            if (data.res == "success") {
                $("#discount").html(data.html);
                $("#productMultiSlider")
                    .find(".slider_" + product_id + "_" + variant_id)
                    .removeClass("hide")
                    .slick("refresh");
            } else notify(data.res, data.msg);
        },
        complete: function () {
            $("#overlay").fadeOut(300);
        },
    });
});

$("#productDetail").on("change", ".strength", function (event) {
    event.stopPropagation();
    var variant_id = $(this).val();
    var product_id = $("option:selected", this).attr("product-id");
    var qty = $("#productQtyBox").find(".qtySelected").attr("qty");
    // $("#productDetail").find("#productD-variant-"+variant_id).trigger("click");

    // $("#productDetail").find(".variant").removeClass('selected');
    // $(this).addClass('selected');

    $.ajax({
        type: "POST",
        url: appUrl + "/product/incremental_discount",
        data: { product_id: product_id, variant_id: variant_id, qty: qty },
        beforeSend: function () {
            $("#overlay").fadeIn(300);
            $("#productMultiSlider")
                .find(".productMultiSlider")
                .addClass("hide");
        },
        success: function (data) {
            if (data.res == "success") {
                $("#discount").html(data.html);
                $("#productMultiSlider")
                    .find(".slider_" + product_id + "_" + variant_id)
                    .removeClass("hide")
                    .slick("refresh");
            } else notify(data.res, data.msg);
        },
        complete: function () {
            $("#overlay").fadeOut(300);
        },
    });
});

$("#productDetail").on("click", ".chooseQty", function () {
    var product_id = $(this).attr("product-id");
    var variant_id = $(this).attr("variant-id");
    var qty = $(this).attr("qty");

    $("#productQtyBox").find(".chooseQty").removeClass("qtySelected");
    $(this).addClass("qtySelected");

    $("#productQtyBox").hide();
    $("#productQtySel").html(qty + " can");

    $.ajax({
        type: "POST",
        url: appUrl + "/product/incremental_discount",
        data: { product_id: product_id, variant_id: variant_id, qty: qty },
        beforeSend: function () {},
        success: function (data) {
            if (data.res == "success") {
                $("#discount").html(data.html);
            } else notify(data.res, data.msg);
        },
    });
});

$("#productDetail").on("click", ".add_to_cart", function () {
    var redirect = $(this).attr("cart");
    if (redirect == "true") {
        window.location = appUrl + "/cart";
        return false;
    }

    var product_id = $(this).attr("product-id");
    var variant = $("#productDetail").find(".strength").val();
    var qty = $("#productQtyBox").find(".qtySelected").attr("qty");

    if (variant === undefined) {
        notify("error", "Choose your preferred strength.");
        return false;
    }

    if (qty === undefined) {
        notify("error", "Choose your preferred quantity.");
        return false;
    }

    if (product_id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/cart",
            data: { product_id: product_id, variant: variant, qty: qty },
            beforeSend: function () {
                dataSaving("#product-" + product_id, "Add To Cart", true);
            },
            success: function (obj) {
                if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    $("#productListing, #productDetail")
                        .find("#product-" + product_id)
                        .attr("cart", "true");
                    $("#cartIcon").find("strong").html(obj.items);
                    dataSaving("#product-" + product_id, "Go To cart", false);
                } else {
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

// $("#productDetail").on("click",".qty", function()
// {
//   var qty = $(this).attr("qty");
//   var product_id = $(this).attr('product-id');
//   var variant_id = $("#variant").find(".selected").attr("variant-id");

//   $("#productDetail").find(".qty").removeClass('selected');
//   $(this).addClass('selected');

//   $.ajax({
//     type: "POST",
//     url : appUrl+"/product/incremental_discount",
//     data:  { 'product_id': product_id, 'variant_id': variant_id, 'qty': qty },
//     beforeSend:function(){  },
//     success: function(data)
//     {
//       if(data.res=="success")
//       {
//         $("#discount").html(data.html);
//       }
//       else
//         notify(data.res,data.msg);
//     }
//   });
// });

$("#productSortBy").on("click", ".sortBy", function () {
    var flavours = [];
    $("#productFilter")
        .find(".flavours:checkbox:checked")
        .each(function (i) {
            flavours[i] = $(this).val();
        });
    var strengths = [];
    $("#productFilter")
        .find(".strengths:checkbox:checked")
        .each(function (i) {
            strengths[i] = $(this).val();
        });
    var sort_by = $("#productSortBy")
        .find('input[name="sortby"]:checked')
        .val();

    $.ajax({
        type: "POST",
        url: appUrl + "/productFilter",
        data: { flavours: flavours, strengths: strengths, sort_by: sort_by },
        beforeSend: function () {
            $(".sortlistshow").hide();
        },
        success: function (obj) {
            $("#productListing").find(".totalitem").html(obj.productCount);
            $("#productListBox").html(obj.productHtml);
        },
        error: function (data, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
});

$("#productSortBy").on("click", "#applyProductSorting", function () {
    var flavours = [];
    $("#productFilter")
        .find(".flavours:checkbox:checked")
        .each(function (i) {
            flavours[i] = $(this).val();
        });
    var strengths = [];
    $("#productFilter")
        .find(".strengths:checkbox:checked")
        .each(function (i) {
            strengths[i] = $(this).val();
        });
    var sort_by = $("#productSortBy")
        .find('input[name="sortby"]:checked')
        .val();

    $.ajax({
        type: "POST",
        url: appUrl + "/productFilter",
        data: { flavours: flavours, strengths: strengths, sort_by: sort_by },
        beforeSend: function () {
            $(".sortlistshow").hide();
        },
        success: function (obj) {
            $("#productListing").find(".totalitem").html(obj.productCount);
            $("#productListBox").html(obj.productHtml);
        },
        error: function (data, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

$("#productFilter").on("click", "#clearProductFilter", function () {
    var flavours = [];
    var strengths = [];
    $("#productFilter").find(".flavours").prop("checked", false);
    $("#productFilter").find(".strengths").prop("checked", false);
    var sort_by = $("#productSortBy")
        .find('input[name="sortby"]:checked')
        .val();

    $.ajax({
        type: "POST",
        url: appUrl + "/productFilter",
        data: { flavours: flavours, strengths: strengths, sort_by: sort_by },
        beforeSend: function () {
            $(".sfdetailC").hide();
        },
        success: function (obj) {
            $("#productListing").find(".totalitem").html(obj.productCount);
            $("#productListBox").html(obj.productHtml);
        },
        error: function (data, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

$("#productFilter").on("click", ".flavours", function () {
    var flavours = [];
    $("#productFilter")
        .find(".flavours:checkbox:checked")
        .each(function (i) {
            flavours[i] = $(this).val();
        });
    var strengths = [];
    $("#productFilter")
        .find(".strengths:checkbox:checked")
        .each(function (i) {
            strengths[i] = $(this).val();
        });
    var sort_by = $("#productSortBy")
        .find('input[name="sortby"]:checked')
        .val();

    $.ajax({
        type: "POST",
        url: appUrl + "/productFilter",
        data: { flavours: flavours, strengths: strengths, sort_by: sort_by },
        beforeSend: function () {
            $(".sfdetailC").hide();
        },
        success: function (obj) {
            $("#productListing").find(".totalitem").html(obj.productCount);
            $("#productListBox").html(obj.productHtml);
        },
        error: function (data, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
});

$("#productFilter").on("click", ".strengths", function () {
    var flavours = [];
    $("#productFilter")
        .find(".flavours:checkbox:checked")
        .each(function (i) {
            flavours[i] = $(this).val();
        });
    var strengths = [];
    $("#productFilter")
        .find(".strengths:checkbox:checked")
        .each(function (i) {
            strengths[i] = $(this).val();
        });
    var sort_by = $("#productSortBy")
        .find('input[name="sortby"]:checked')
        .val();

    $.ajax({
        type: "POST",
        url: appUrl + "/productFilter",
        data: { flavours: flavours, strengths: strengths, sort_by: sort_by },
        beforeSend: function () {
            $(".sfdetailC").hide();
        },
        success: function (obj) {
            $("#productListing").find(".totalitem").html(obj.productCount);
            $("#productListBox").html(obj.productHtml);
        },
        error: function (data, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
});

$("#productFilter").on("click", "#applyProductFilter", function () {
    var flavours = [];
    $("#productFilter")
        .find(".flavours:checkbox:checked")
        .each(function (i) {
            flavours[i] = $(this).val();
        });
    var strengths = [];
    $("#productFilter")
        .find(".strengths:checkbox:checked")
        .each(function (i) {
            strengths[i] = $(this).val();
        });
    var sort_by = $("#productSortBy")
        .find('input[name="sortby"]:checked')
        .val();

    $.ajax({
        type: "POST",
        url: appUrl + "/productFilter",
        data: { flavours: flavours, strengths: strengths, sort_by: sort_by },
        beforeSend: function () {
            $(".sfdetailC").hide();
        },
        success: function (obj) {
            $("#productListing").find(".totalitem").html(obj.productCount);
            $("#productListBox").html(obj.productHtml);
        },
        error: function (data, textStatus, errorThrown) {
            notify("error", "Something wrong, try later.");
        },
    });
    return false;
});

$("#productDetail").on("click", ".add_to_wishlist", function () {
    var product_id = $(this).attr("product-id");
    if (product_id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/itemWishlist",
            data: { product_id: product_id },
            beforeSend: function () {},
            success: function (data) {
                if (data.res == "success") {
                    if (data.wishlisted)
                        $("#productDetail")
                            .find(".wishlist-item-" + product_id)
                            .find("i")
                            .removeClass("fa-heart-o")
                            .addClass("fa-heart");
                    else
                        $("#productDetail")
                            .find(".wishlist-item-" + product_id)
                            .find("i")
                            .removeClass("fa-heart")
                            .addClass("fa-heart-o");
                    notify(data.res, data.msg);
                } else {
                    notify(data.res, data.msg);
                    setTimeout(function () {
                        window.location = appUrl + "/login";
                    }, 50);
                }
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#wishlistProducts").on("click", ".delete_from_wishlist", function () {
    var id = $(this).attr("wishlist-id");
    if (id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/deleteWishlist",
            data: { id: id },
            beforeSend: function () {},
            success: function (data) {
                if (data.res == "success") {
                    $("#wishlistProducts").load(appUrl + "/reloadWishlist");
                    notify(data.res, data.msg);
                } else notify(data.res, data.msg);
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#profileSection").on("click", "#editProfile", function () {
    $("#displayProfile").removeClass("hide").addClass("show");
    $("#displayChangePassword").removeClass("show").addClass("hide");
    return false;
});

$("#profileForm").on("click", "#profileUpdate", function () {
    $("#profileForm").find("span").html("");
    var flag = true;
    var first_name = $.trim($("#profileForm").find("#first_name").val());
    var last_name = $.trim($("#profileForm").find("#last_name").val());
    if (first_name == "") {
        $("#profileForm")
            .find("#first_name")
            .parent("div")
            .find("span")
            .html("Please enter first name");
        flag = false;
    }
    if (last_name == "") {
        $("#profileForm")
            .find("#last_name")
            .parent("div")
            .find("span")
            .html("Please enter last name");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/my-profile/edit",
            data: new FormData($("#profileForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#profileUpdate", "Saving", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#profileForm")
                            .find("#" + key)
                            .parent("div")
                            .find("span")
                            .html(value);
                    });
                    dataSaving("#profileUpdate", "Save", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#profileUpdate", "Save", false);
                } else if (obj.res == "error") {
                    dataSaving("#profileUpdate", "Save", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#profileUpdate", "Save", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#profileSection").on("click", "#changePassword", function () {
    $("#displayChangePassword").removeClass("hide").addClass("show");
    $("#displayProfile").removeClass("show").addClass("hide");
    return false;
});

$("#changePasswordForm").on("click", "#changePasswordSave", function () {
    $("#changePasswordForm").find("span").html("");
    var flag = true;
    var current_password = $.trim($("#current_password").val());
    var password = $.trim($("#password").val());
    var password_confirm = $.trim($("#password-confirm").val());
    if (current_password == "") {
        $("#changePasswordForm")
            .find("#current_password")
            .parent("div")
            .find("span")
            .html("Please enter current password");
        flag = false;
    }
    if (password == "") {
        $("#changePasswordForm")
            .find("#password")
            .parent("div")
            .find("span")
            .html("Please enter new password");
        flag = false;
    }
    if (password != "" && password.length < 6) {
        $("#changePasswordForm")
            .find("#password")
            .parent("div")
            .find("span")
            .html("Please enter minimum 12 characters");
        flag = false;
    }
    if (password_confirm == "") {
        $("#changePasswordForm")
            .find("#password-confirm")
            .parent("div")
            .find("span")
            .html("Please enter confirm password");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/my-profile/change-password",
            data: new FormData($("#changePasswordForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#changePasswordSave", "Save", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#changePasswordForm")
                            .find("#" + key)
                            .parent("div")
                            .find("span")
                            .html(value);
                    });
                    notify("error", "Please fill all mandatory fields.");
                    dataSaving("#changePasswordSave", "Save", false);
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    $("#changePasswordForm").trigger("reset");
                    dataSaving("#changePasswordSave", "Save", false);
                } else if (obj.res == "error") {
                    notify(obj.res, obj.msg);
                    dataSaving("#changePasswordSave", "Save", false);
                } else {
                    notify("error", "Something wrong, try later.");
                    dataSaving("#changePasswordSave", "Save", false);
                }
            },
        });
    }
    return false;
});

$("#addressForm").on("change", "#country", function () {
    var country = $(this).val();
    if (country) {
        $.ajax({
            type: "POST",
            url: appUrl + "/getStates",
            data: { country_id: country },
            beforeSend: function () {},
            success: function (data) {
                $("#addressForm").find("#state").html(data);
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#addressSection").on("click", "div.radio", function () {
    var id = $(this).attr("address-id");
    if (id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/my-address/preferred",
            data: { id: id },
            beforeSend: function () {},
            success: function (obj) {
                if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    $("#addressSection").load(appUrl + "/my-address/reload");
                } else {
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    }
});

$("#addressSection").on("click", ".edit_address", function () {
    var id = $(this).attr("address-id");
    if (id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/my-address/edit",
            data: { id: id },
            beforeSend: function () {},
            success: function (data) {
                $("#addressForm").html(data);
                $("#addressForm").find("#first_name").focus();
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#addressForm").on("click", "#addressSave", function () {
    $("#addressForm").find("span").html("");
    var flag = true;
    var country = $.trim($("#addressForm").find("#country").val());
    var first_name = $.trim($("#addressForm").find("#first_name").val());
    var last_name = $.trim($("#addressForm").find("#last_name").val());
    var address = $.trim($("#addressForm").find("#address").val());
    var apartment = $.trim($("#addressForm").find("#apartment").val());
    var pincode = $.trim($("#addressForm").find("#pincode").val());
    var state = $.trim($("#addressForm").find("#state").val());
    var city = $.trim($("#addressForm").find("#city").val());
    var mobile = $.trim(parseInt($("#addressForm").find("#mobile").val()));

    if (country == "") {
        $("#addressForm #country")
            .parent("div")
            .find("span")
            .html("Please select your country");
        flag = false;
    }
    if (first_name == "") {
        $("#addressForm #first_name")
            .parent("div")
            .find("span")
            .html("Please enter first name");
        flag = false;
    }
    if (last_name == "") {
        $("#addressForm #last_name")
            .parent("div")
            .find("span")
            .html("Please enter last name");
        flag = false;
    }
    if (address == "") {
        $("#addressForm #address")
            .parent("div")
            .find("span")
            .html("Please enter your address");
        flag = false;
    }
    if (apartment == "") {
        $("#addressForm #apartment")
            .parent("div")
            .find("span")
            .html("Please enter your apartment.");
        flag = false;
    }
    if (pincode == "") {
        $("#addressForm #pincode")
            .parent("div")
            .find("span")
            .html("Please enter a valid pincode");
        flag = false;
    }
    if (/^[a-zA-Z0-9- ]*$/.test(pincode) == false) {
        $("#addressForm #pincode")
            .parent("div")
            .find("span")
            .html("Please enter a valid pincode");
        flag = false;
    }
    if (state == "") {
        $("#addressForm #state")
            .parent("div")
            .find("span")
            .html("Please select your state");
        flag = false;
    }
    if (city == "") {
        $("#addressForm #city")
            .parent("div")
            .find("span")
            .html("Please enter your city");
        flag = false;
    }
    if (mobile == "") {
        $("#addressForm #mobile")
            .parent("div")
            .find("span")
            .html("Please enter a valid mobile no.");
        flag = false;
    }
    if (mobile.length != "10") {
        $("#addressForm #mobile")
            .parent("div")
            .find("span")
            .html("Please enter a valid mobile no.");
        flag = false;
    }
    if (/^[a-zA-Z0-9- ]*$/.test(mobile) == false) {
        $("#addressForm #mobile")
            .parent("div")
            .find("span")
            .html("Please enter a valid mobile no.");
        flag = false;
    }

    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/my-address/store",
            data: new FormData($("#addressForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                dataSaving("#addressSave", "Saving", true);
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#" + key)
                            .parent()
                            .find("span.errorMsg")
                            .html(value);
                    });
                    dataSaving("#addressSave", "Save", false);
                    notify("error", "Please fill all mandatory fields.");
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    dataSaving("#addressSave", "Save", false);
                    $("#addressForm").load(appUrl + "/my-address/reset");
                    $("#addressSection").load(appUrl + "/my-address/reload");
                } else if (obj.res == "error") {
                    dataSaving("#addressSave", "Save", false);
                    notify(obj.res, obj.msg);
                } else {
                    dataSaving("#addressSave", "Save", false);
                    notify("error", "Something wrong, try later.");
                }
            },
        });
    } else notify("error", "Please fill all mandatory fields.");
    return false;
});

$("#addressSection").on("click", ".delete_address", function () {
    var id = $(this).attr("address-id");
    if (id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/my-address/delete",
            data: { id: id },
            beforeSend: function () {},
            success: function (data) {
                if (data.res == "success") {
                    $("#addressSection").load(appUrl + "/my-address/reload");
                    notify(data.res, data.msg);
                } else notify(data.res, data.msg);
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#cartSection").on("click", "#emptyCart", function () {
    $.ajax({
        type: "GET",
        url: appUrl + "/cart/empty",
        data: {},
        beforeSend: function () {},
        success: function (obj) {
            if (obj.res == "success") {
                $("#cartIcon").find("strong").html(obj.items);
                $("#cartSection").load(appUrl + "/cart/reloadCart");
                notify(obj.res, obj.msg);
            } else notify(obj.res, obj.msg);
        },
    });
    return false;
});

$("#cartSection").on("click", ".remove_from_cart", function () {
    var id = $(this).attr("cart-id");
    if (id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/cart/itemDelete",
            data: { id: id },
            beforeSend: function () {},
            success: function (obj) {
                if (obj.res == "success") {
                    $("#cartIcon").find("strong").html(obj.items);
                    $("#cartSection").load(appUrl + "/cart/reloadCart");
                    notify(obj.res, obj.msg);
                } else notify(obj.res, obj.msg);
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#cartSection").on("click", ".increase_qty", function () {
    var id = $(this).attr("cart-id");
    if (id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/cart/itemIncrease",
            data: { id: id },
            beforeSend: function () {},
            success: function (data) {
                if (data.res == "success") {
                    $("#cart-item-" + id)
                        .find("#item-qty-" + id)
                        .val(data.qty);
                    $("#cartSection").load(appUrl + "/cart/reloadCart");
                    notify(data.res, data.msg);
                } else notify(data.res, data.msg);
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#cartSection").on("click", ".decrease_qty", function () {
    var id = $(this).attr("cart-id");
    if (id) {
        $.ajax({
            type: "POST",
            url: appUrl + "/cart/itemDecrease",
            data: { id: id },
            beforeSend: function () {},
            success: function (data) {
                if (data.res == "success") {
                    $("#cart-item-" + id)
                        .find("#item-qty-" + id)
                        .val(data.qty);
                    $("#cartSection").load(appUrl + "/cart/reloadCart");
                    notify(data.res, data.msg);
                } else notify(data.res, data.msg);
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#cartSection").on("click", "#couponCodeBtn", function () {
    var couponCode = $("#cartSection").find("#couponCode").val();
    if (couponCode == "") {
        notify("error", "Please enter coupon code.");
        $("#cartSection").find("#couponCode").focus();
    } else {
        $.ajax({
            type: "POST",
            url: appUrl + "/cart/couponCode",
            data: { couponCode: couponCode },
            beforeSend: function () {},
            success: function (data) {
                console.log(data);
                if (data.res == "success") {
                    notify(data.res, data.msg);
                    $("#cartSection").load(appUrl + "/cart/reloadCart");
                } else notify(data.res, data.msg);
            },
        });
    }
    return false;
});

$("#checkoutForm").on("click", "#checkoutAddressBtn", function () {
    $("#checkoutForm").find("#checkoutAddressSection").toggle();
});

$("#checkoutForm").on("click", "#samebilling", function () {
    if ($("#checkoutForm").find("#samebilling").is(":checked")) {
        $("#billingDetailsSection").hide();
    } else {
        $("#billingDetailsSection").show();
    }
});

$("#checkoutForm").on("change", "#country", function () {
    var country = $(this).val();
    if (country) {
        $.ajax({
            type: "POST",
            url: appUrl + "/getStates",
            data: { country_id: country },
            beforeSend: function () {},
            success: function (data) {
                $("#checkoutForm").find("#state").html(data);
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#checkoutForm").on("change", "#billing_country", function () {
    var country = $(this).val();
    if (country) {
        $.ajax({
            type: "POST",
            url: appUrl + "/getStates",
            data: { country_id: country },
            beforeSend: function () {},
            success: function (data) {
                $("#checkoutForm").find("#billing_state").html(data);
            },
        });
    } else notify("error", "Something wrong, try later.");
    return false;
});

$("#dob").datepicker({
    format: "yyyy-mm-dd",
    startDate: "",
    endDate: "yes",
    autoclose: true,
});

$("#checkoutSubmit").click(function () {
    $("#checkoutForm").find("#responseMsg").html("&nbsp;");
    $("#checkoutForm").find("span").html("");
    var flag = true;
    var first_name = $.trim($("#checkoutForm").find("#first_name").val());
    var last_name = $.trim($("#checkoutForm").find("#last_name").val());
    var address = $.trim($("#checkoutForm").find("#address").val());
    var apartment = $.trim($("#checkoutForm").find("#apartment").val());
    var country = $.trim($("#checkoutForm").find("#country").val());
    var state = $.trim($("#checkoutForm").find("#state").val());
    var city = $.trim($("#checkoutForm").find("#city").val());
    var pincode = $.trim($("#checkoutForm").find("#pincode").val());
    var mobile = $.trim(parseInt($("#checkoutForm").find("#mobile").val()));
    var dob = $.trim($("#checkoutForm").find("#dob").val());

    var billing_first_name = $.trim($("#checkoutForm").find("#billing_first_name").val());
    var billing_last_name = $.trim($("#checkoutForm").find("#billing_last_name").val());
    var billing_address = $.trim($("#checkoutForm").find("#billing_address").val());
    var billing_apartment = $.trim($("#checkoutForm").find("#billing_apartment").val());
    var billing_country = $.trim($("#checkoutForm").find("#billing_country").val());
    var billing_state = $.trim($("#checkoutForm").find("#billing_state").val());
    var billing_city = $.trim($("#checkoutForm").find("#billing_city").val());
    var billing_pincode = $.trim($("#checkoutForm").find("#billing_pincode").val());
    var billing_mobile = $.trim(parseInt($("#checkoutForm").find("#billing_mobile").val()));
    if (first_name == "") {
        $("#checkoutForm #first_name").parent("div").find("span").html("Please enter first name");
        flag = false;
    }
    if (last_name == "") {
        $("#checkoutForm #last_name").parent("div").find("span").html("Please enter last name");
        flag = false;
    }
    if (address == "") {
        $("#checkoutForm #address").parent("div").find("span").html("Please enter your address");
        flag = false;
    }
    if (apartment == "") {
        $("#checkoutForm #apartment").parent("div").find("span").html("Please enter your apartment.");
        flag = false;
    }
    if (country == "") {
        $("#checkoutForm #country").parent("div").find("span").html("Please select your country");
        flag = false;
    }
    if (state == "") {
        $("#checkoutForm #state").parent("div").find("span").html("Please select your state");
        flag = false;
    }
    if (city == "") {
        $("#checkoutForm #city").parent("div").find("span").html("Please enter your city");
        flag = false;
    }
    if (pincode == "") {
        $("#checkoutForm #pincode").parent("div").find("span").html("Please enter a valid pincode");
        flag = false;
    }
    if (/^[a-zA-Z0-9- ]*$/.test(pincode) == false) {
        $("#checkoutForm #pincode").parent("div").find("span").html("Please enter a valid pincode");
        flag = false;
    }
    // if(pincode.length!='6')
    //   {$("#checkoutForm #pincode").parent("div").find("span").html('Please enter a valid pincode');flag = false;}
    if (mobile == "") {
        $("#checkoutForm #mobile").parent("div").find("span").html("Please enter a valid mobile no.");
        flag = false;
    }
    if (mobile.length != "10") {
        $("#checkoutForm #mobile").parent("div").find("span").html("Please enter a valid mobile no.");
        flag = false;
    }
    if (/^[a-zA-Z0-9- ]*$/.test(mobile) == false) {
        $("#checkoutForm #mobile").parent("div").find("span").html("Please enter a valid mobile no.");
        flag = false;
    }
    if (dob == "") {
        $("#checkoutForm #dob").parent("div").find("span").html("Please enter a valid DOB");
        flag = false;
    }

    // if(!$("#checkoutSection").find("input[name='privacy_policy']").is(':checked')) flag = false;
    // if(!$("#checkoutSection").find("input[name='tnc']").is(':checked')) flag = false;

    if (!$("#checkoutForm").find("#samebilling").is(":checked")) {
        if (billing_first_name == "") {
            $("#checkoutForm #billing_first_name").parent("div").find("span").html("Please enter first name");
            flag = false;
        }
        if (billing_last_name == "") {
            $("#checkoutForm #billing_last_name").parent("div").find("span").html("Please enter last name");
            flag = false;
        }
        if (billing_address == "") {
            $("#checkoutForm #billing_address").parent("div").find("span").html("Please enter your address");
            flag = false;
        }
        if (billing_apartment == "") {
            $("#checkoutForm #billing_apartment").parent("div").find("span").html("Please enter your apartment.");
            flag = false;
        }
        if (billing_country == "") {
            $("#checkoutForm #billing_country").parent("div").find("span").html("Please select your country");
            flag = false;
        }
        if (billing_state == "") {
            $("#checkoutForm #billing_state").parent("div").find("span").html("Please select your state");
            flag = false;
        }
        if (billing_city == "") {
            $("#checkoutForm #billing_city").parent("div").find("span").html("Please enter your city");
            flag = false;
        }
        if (billing_pincode == "") {
            $("#checkoutForm #billing_pincode").parent("div").find("span").html("Please enter a valid pincode");
            flag = false;
        }
        if (/^[a-zA-Z0-9- ]*$/.test(billing_pincode) == false) {
            $("#checkoutForm #billing_pincode").parent("div").find("span").html("Please enter a valid pincode");
            flag = false;
        }
        // if(pincode.length!='6')
        //   {$("#checkoutForm #pincode").parent("div").find("span").html('Please enter a valid pincode');flag = false;}
        if (billing_mobile == "") {
            $("#checkoutForm #billing_mobile").parent("div").find("span").html("Please enter a valid mobile no.");
            flag = false;
        }
        if (billing_mobile.length != "10") {
            $("#checkoutForm #billing_mobile").parent("div").find("span").html("Please enter a valid mobile no.");
            flag = false;
        }
        if (/^[a-zA-Z0-9- ]*$/.test(billing_mobile) == false) {
            $("#checkoutForm #billing_mobile").parent("div").find("span").html("Please enter a valid mobile no.");
            flag = false;
        }
    }
    var shipping_method = $("#deliveryMethodSection").find(".shippingMethod:checked").val();
    if (flag) {
        formData = new FormData($("#checkoutForm")[0]);
        formData.append("shipping_method", shipping_method);
        $.ajax({
            type: "POST",
            url: appUrl + "/checkout",
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $("#checkoutSubmit").attr("disabled", true);
            },
            success: function (data) {
                let obj;
                try {
                    obj = typeof data === "string" ? JSON.parse(data) : data;
                } catch (e) {
                    notify("error", "Invalid server response.");
                    return;
                }
                if (obj.res == "invalid") {
                    $.each(obj.msg, function (key, value) {
                        $("#checkoutForm #" + key).parent("div").find("span").html(value);
                    });
                    notify("error", "All the fields are mandatory.");
                } else if (obj.res == "denied") {
                    $(".invalidAge").find(".content").html(obj.msg);
                    $(".invalidAge").fadeIn();
                } else if (obj.res == "success") {
                    notify(obj.res, obj.msg);
                    $("#checkoutForm").find("#checkoutAddressSection").hide();
                    $("#deliveryMethod").find("#deliveryMethodSection").show();
                    $("#paymentMethod").find("#paymentMethodSection").hide();
                    /*$("#paymentMethod").find("#payment-element").load(appUrl + "/payment");*/
                    $("html, body").animate(
                        { scrollTop: $("#deliveryMethod").offset().top - 120 },
                        1000
                    );
                } else {
                    notify(obj.res, obj.msg);
                }
                dataSaving("#checkoutSubmit", "Deliver Here", false);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#checkoutSubmit").attr("disabled", false);
                notify("error", "Something went wrong, please try again.");
            },
        });
    } else {
        notify("error", "All the fields are mandatory.");
    }
    return false;
});

$("#deliveryMethod").on("click", "#deliveryMethodBtn", function () {
    $("#deliveryMethod").find("#deliveryMethodSection").toggle();
});

$("#deliveryMethodSection").on("click", ".shippingMethod", function () {
    var shipping_method = $(this).val();
    $.ajax({
        type: "POST",
        url: appUrl + "/shippingMethod",
        data: { shipping_method: shipping_method },
        beforeSend: function () {},
        success: function (obj) {
            if (obj.res == "success") {
                $("#priceSection").html(obj.priceHtml);
                // $("#paymentMethod").find("#payment-element").load(appUrl + "/payment");
                $("#deliveryMethod").find("#deliveryMethodSection").hide();
                $("#paymentMethod").find("#paymentMethodSection").show();
                $("html, body").animate(
                    { scrollTop: $("#paymentMethod").offset().top - 120 },
                    1000
                );
            } else {
                notify(obj.res, obj.msg);
                $("html, body").animate(
                    { scrollTop: $("#checkoutForm").offset().top - 120 },
                    1000
                );
                return false;
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            notify("error", "Something went wrong, please try later.");
            return false;
        },
    });
});

$("#paymentMethod").on("click", "#paymentMethodBtn", function () {
    $("#paymentMethod").find("#paymentMethodSection").toggle();
});

$("#paymentSection").on("click", "#placeOrder", function () {
    if ($("#paymentSection").find("input[name='payment']").is(":checked")) {
        var payment = $("input[name='payment']:checked").val();

        $.ajax({
            type: "POST",

            url: appUrl + "/payment",

            data: { payment: payment },

            beforeSend: function () {
                dataSaving("#placeOrder", "Place Order", true);
            },

            success: function (data) {
                if (data.res == "success") {
                    notify(data.res, data.msg);

                    setTimeout(function () {
                        window.location = data.url;
                    }, 50);

                    dataSaving("#placeOrder", "Place Order", false);
                } else {
                    notify(data.res, data.msg);

                    setTimeout(function () {
                        window.location = data.url;
                    }, 50);

                    dataSaving("#placeOrder", "Place Order", false);
                }
            },
        });
    } else {
        notify("error", "Please select payment method.");
    }

    return false;
});

$("#storeSearchForm").on("change", "#state", function () {
    var state = $.trim($(this).val());
    if (state != "") {
        $.ajax({
            type: "POST",
            url: appUrl + "/storeCities",
            data: { state: state },
            success: function (data) {
                $("#city").html(data);
            },
        });
    }
});

$("#storeSearchForm").on("click", "#storeSearch", function () {
    $("#storeSearchForm").find("#responseMsg").html("&nbsp;");
    var flag = true;
    var state = $.trim($("#storeSearchForm").find("#state").val());
    var city = $.trim($("#storeSearchForm").find("#city").val());
    var pincode = $.trim($("#storeSearchForm").find("#pincode").val());

    if (state == "" && city == "" && pincode == "") {
        $("#storeSearchForm")
            .find("#responseMsg")
            .html("Enter state, city or pincode");
        flag = false;
    }
    if (flag) {
        $.ajax({
            type: "POST",
            url: appUrl + "/storeSearch",
            data: new FormData($("#storeSearchForm")[0]),
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $("#storeList").html('<i class="fa fa-refresh fa-spin"></i>');
            },
            success: function (data) {
                $("#storeList").html(data);
                initMap(state, city, pincode);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#storeSearchForm")
                    .find("#responseMsg")
                    .html("Something went wrong, please try later.");
            },
        });
    }
    return false;
});

function initMap(state = "", city = "", pincode = "") {
    // Create the map centered at an arbitrary location
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 3,
        center: { lat: 41.850033, lng: -87.6500523 },
    });

    // Fetch locations from PHP
    fetch(
        appUrl +
            "/storeLocations?state=" +
            state +
            "&city=" +
            city +
            "&pincode=" +
            pincode
    )
        .then((response) => response.json())
        .then((locations) => {
            locations.forEach((location) => {
                // Create a marker for each location
                const marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(location.latitude),
                        lng: parseFloat(location.longitude),
                    },
                    map: map,
                    title: location.name,
                    // icon: "images/store-marker.png",
                });

                // Add an info window for each marker
                const infowindow = new google.maps.InfoWindow({
                    content: `<h3>${location.name}</h3><p>${location.address}</p>`,
                });

                marker.addListener("click", () => {
                    infowindow.open(map, marker);
                });
            });
        })
        .catch((error) => console.error("Error fetching locations:", error));
}

let map;
let marker;
let infoWindow;

// Initialize the map but keep it hidden initially
function initMapStore(lat, lng, storeName, storeAddress) {
    if (!map) {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat,
                lng,
            },
            zoom: 12,
        });
    } else {
        map.setCenter({
            lat,
            lng,
        });
        map.setZoom(12);
    }

    // Place a marker at the store location
    if (marker) {
        marker.setMap(null);
    }
    marker = new google.maps.Marker({
        position: {
            lat,
            lng,
        },
        map: map,
        title: storeName,
        //icon: "images/store-marker.png",
    });

    // Set up an info window with store details
    if (infoWindow) {
        infoWindow.close();
    }
    infoWindow = new google.maps.InfoWindow({
        content: `<h3>${storeName}</h3><p>${storeAddress}</p>`,
    });

    marker.addListener("click", () => infoWindow.open(map, marker));
    infoWindow.open(map, marker);

    // Show the map div if hidden
    document.getElementById("map").style.display = "block";
}

function dataSaving(id, text, status) {
    if (status)
        $(id)
            .attr("disabled", true)
            .html('<i class="fa fa-refresh fa-spin"></i> ' + text);
    else $(id).attr("disabled", false).html(text);
}

let icon = {
    success: '<i class="fa fa-check"></i>',
    error: '<span class="fa fa-exclamation"></span>',
    warning: '<span class="fa fa-warning"></span>',
    info: '<span class="fa fa-info"></span>',
};

const notify = (
    toastType = "error",
    message = "Something went wrong, please try later.",
    duration = 5000
) => {
    if (!Object.keys(icon).includes(toastType)) toastType = "info";

    let box = document.createElement("div");
    box.classList.add("toast", `toast-${toastType}`);
    box.innerHTML = ` <div class="toast-content-wrapper"><div class="toast-icon">${icon[toastType]}</div>
                    <div class="toast-message">${message}</div>
                    <div class="toast-progress"></div>
                    </div>`;
    duration = duration || 5000;
    box.querySelector(".toast-progress").style.animationDuration = `${
        duration / 1000
    }s`;

    let toastAlready = document.body.querySelector(".toast");
    if (toastAlready) {
        toastAlready.remove();
    }
    document.body.appendChild(box);
    setTimeout(function () {
        document.body.querySelector(".toast").remove();
    }, duration);
};

function numbersonly(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
}
function englishonly(evt) {
    var ew = evt.which;
    if (ew == 32) return true;
    if (48 <= ew && ew <= 57) return true;
    if (65 <= ew && ew <= 90) return true;
    if (97 <= ew && ew <= 122) return true;
    return false;
}

$("#togglePassword").on("click", function () {
    var passwordInput = document.getElementById("password");
    var toggleButton = document.getElementById("togglePassword");
    toggleButton.classList.toggle("phide");
    passwordInput.type =
        passwordInput.type === "password" ? "text" : "password";
});

$("#confirmTogglePassword").on("click", function () {
    var passwordInput = document.getElementById("password-confirm");
    var toggleButton = document.getElementById("confirmTogglePassword");
    toggleButton.classList.toggle("phide");
    passwordInput.type =
        passwordInput.type === "password" ? "text" : "password";
});

// document
//   .getElementById("togglePassword")
//   .addEventListener("click", function () {
//       var passwordInput = document.getElementById("password");
//       var toggleButton = document.getElementById("togglePassword");
//       toggleButton.classList.toggle("phide");
//       passwordInput.type =
//           passwordInput.type === "password" ? "text" : "password";
//   });
// document
//   .getElementById("confirmTogglePassword")
//   .addEventListener("click", function () {
//       var passwordInput = document.getElementById("password-confirm");
//       var toggleButton = document.getElementById("confirmTogglePassword");
//       toggleButton.classList.toggle("phide");
//       passwordInput.type =
//           passwordInput.type === "password" ? "text" : "password";
// });
