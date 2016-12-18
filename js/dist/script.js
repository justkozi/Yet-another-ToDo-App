/**
 * Created by lukas on 03.12.2016.
 */
// Ripple effect
$(function(){
    $('.ripple').materialripple();
});
// End Ripple Effect

//Menu toggle

$(function () {
   $(".menu-toggle").click(function () {
       toggleNav();
   })
});

function toggleNav() {
    if($(".nav").hasClass("expanded")){
        $(".nav ul").slideUp();
        $(".nav").addClass("hidden");
        $(".nav").removeClass("expanded");
        $(".menu-toggle").removeClass("active");
    }
    else if($(".nav").hasClass("hidden")){
        $(".nav ul").slideDown();
        $(".nav").addClass("expanded");
        $(".nav").removeClass("hidden");
        $(".menu-toggle").addClass("active");
    }
}
$(window).resize(function(){
    resolutionCheck();
});

$(function () {
    resolutionCheck();
});

function resolutionCheck() {
    if ($(window).width() > 769){
        if($(".nav ul").hasClass("desktop")){

        }else{
            $(".nav ul").show()
            $(".nav ul").addClass("desktop")
            $(".nav .menu-toggle").hide()
            if($(".nav").hasClass("hidden")){
                $(".nav ul").slideDown();
                $(".nav").addClass("expanded");
                $(".nav").removeClass("hidden");
                $(".menu-toggle").addClass("active");
            }
        }

    }else{
        if($(".nav ul").hasClass("desktop")) {
            $(".nav ul").hide()
            $(".nav ul").removeClass("desktop")
            $(".nav .menu-toggle").show()
            if($(".nav").hasClass("expanded")){
                $(".nav ul").slideUp();
                $(".nav").addClass("hidden");
                $(".nav").removeClass("expanded");
                $(".menu-toggle").removeClass("active");
            }
        }
    }
}
// End Menu toggle

// typed.js
$(function () {
    if($(".invite-text")){
        $(".invite-text").typed({
            strings: ["Twórz notatki...", "Bądź bardziej produktywny...","Uporządkuj sobie życie...","Już nidy nie zapomnisz o zadaniach...","Dostęp do zadań z każdego miejsca...","Minimalistyczny design.."],
            typeSpeed: 50,
            startDelay: 500,
            backDelay: 3000,
            backSpeed: 50,
            loop: true,
            shuffle: true
        });
    }
})

// End typed.js

// Form animations
$(window, document, undefined).ready(function() {

    $('input').blur(function() {
        var $this = $(this);
        if ($this.val())
            $this.addClass('used');
        else
            $this.removeClass('used');
    });
});
// End form animations

// Login/Register toggle

    $(".register-toggle").click(function () {
        $("#login-form").toggle();
        $("#register-form").toggle();
    });

// end Login/Register toggle