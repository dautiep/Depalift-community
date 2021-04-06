var App = {
    logoSlider: function() {
        try {
        if ($(".logo-slider").length) {
            $(".logo-slider").slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true,
            autoplay: true,
            autoplaSpeed: 2000,
            infinity: true,
            responsive: [
                {
                breakpoint: 1366,
                settings: {
                    slidesToShow: 6,
                    slidesToScroll: 1,
                },
                },
                {
                breakpoint: 995,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
                },
                {
                breakpoint: 722,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
                },
                {
                breakpoint: 482,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
                },
            ],
            });
        }
        } catch (e) {
        console.log(e.message);
        }
    },
    clickAllMenu: function() {
        try {
        var x = document.getElementById("bars");
        var y = document.getElementById("times");
        var z = document.getElementById("all-menu");
        console.log(x.style.display);
        if (x.style.display == "inline-block") {
            x.style.display = "none";
            y.style.display = "inline-block";
            $("#all-menu").addClass("active");
        } else {
            x.style.display = "inline-block";
            y.style.display = "none";
            $("#all-menu").removeClass("active");
        }
        } catch (e) {
        console.log(e.message);
        }
    },
    showHeaderMenu: function() {
        try {

        if ($(".__js_show_menu").length) {
                $(".__js_show_menu").on("click", function() {
                let bars_icon = $(".__js_bars");
                let times_icon = $(".__js_times");
                let menu = $(".__js_all_menu");
                $(this).toggleClass("active");
                $("#ModuleContent").toggleClass("active");
                $("#ModuleContent_Mobile").toggleClass("active");
            });
        }
        } catch (e) {
        console.log(e.message);
        }
    },
    clickMenuSearch: function() {
        var x = document.getElementById("menu-search");
        x.style.visibility = "hidden";
        $("#form-search").addClass("show");
    },
    showHeaderSearch: function() {
        try {
        if ($(".__js_show_search").length) {
            $(".__js_show_search").on("click", function() {
            App.clickMenuSearch();
            });
        }
        } catch (e) {
        console.log(e.message);
        }
    },

    showDistrictInProvinceThuongTru: function(){
        var url = district_thuong_tru;
        $("select[name='pernament_main']").change(function () {
            var id_province = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url:url,
                method:'POST',
                data:{
                    pernament_main: id_province,
                    _token: token
                },
                success: function (data) {
                    $("select[name='district_main']").html('');
                    $("#contact_district").append('<option value="" selected="selected">-Chọn huyện-</option>');
                    $.each(data, function (key, value) {
                        $("select[name='district_main']").append('<option value="'+ value.name +'">' + value.name + '</option>');
                    });
                }
            });
        });
    },

    showDistrictInProvinceTamTru: function(){
        var url = district_tam_tru;
        $("select[name='pernament_sub']").change(function () {
            var id_province = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url:url,
                method:'POST',
                data:{
                    pernament_sub: id_province,
                    _token: token
                },
                success: function (data) {
                    $("select[name='district_sub']").html('');
                    $("#contact_district1").append('<option value="" selected="selected">-Chọn huyện-</option>');
                    $.each(data, function (key, value) {
                        $("select[name='district_sub']").append('<option value="'+ value.name +'">' + value.name + '</option>');
                    });
                }
            });
        });
    },



    downloadURI(uri, name) 
{
    var link = document.createElement("a");
    // If you don't know the name or want to use
    // the webserver default set name = ''
    link.setAttribute('download', name);
    link.href = uri;
    document.body.appendChild(link);
    link.click();
    link.remove();
}
};

const Tabs = {
    pushHistoryUrl(nameTab) {
        const url = new URL(window.location);
        url.searchParams.set('tab', nameTab);
        window.history.pushState({}, '', url);
    },
    switchUrlWhenClickableTabs() {
        $('#pills-tab .nav-link-tab').click(function () {
            let el = $(this)
            const nameTab = el.attr('aria-controls')
            if(!nameTab) return

            Tabs.pushHistoryUrl(nameTab)
        })
    }
}

$(document).ready(function() {
    App.logoSlider();
    App.showHeaderMenu();
    App.showHeaderSearch();
    App.showDistrictInProvinceThuongTru();
    App.showDistrictInProvinceTamTru();
    Tabs.switchUrlWhenClickableTabs()
    Components.init()
});

$(window).scroll(function(){
    if($(this).scrollTop() > 40){
        $('#icon').fadeIn();
    }else{
        $('#icon').fadeOut();
    }
});

$("#icon").click(function(){
    $('html, body').animate({scrollTop:0},"slow");
});

//resize window 
var mb = document.getElementById('mb-screen');
var pc = document.getElementById('pc-screen');
if(window.innerWidth <= 991){
    mb.style.display = "block";
    pc.style.display = "none";
}else{
    mb.style.display = "none";
    pc.style.display = "block";
}
window.onresize = function(){
    if(window.innerWidth <= 991){
        mb.style.display = "block";
        pc.style.display = "none";
    }else{
        mb.style.display = "none";
        pc.style.display = "block";
    }
};

const Components = {
    init: function() {
        const formYearTabs = {
            props: ['old'],
            data() {
                return {
                    year1: "",
                    year2: "",
                    year3: "",
                }
            },
            mounted() {
                const { old } = this
                if(!!old && old instanceof Object) {
                    const years = Object.keys(old)

                    years.forEach((el, key) => {
                        this.$data[`year${key + 1}`] = el
                    })
                } 
            },
        }

        new Vue({
            el: '#vue',
            components: {
                formYearTabs: formYearTabs 
            },
        });
    }
}
