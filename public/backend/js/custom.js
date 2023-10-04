// const { random } = require("lodash");

$(function () {

function getRandom(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random()*(max-min+1)+min);
}

$('form.user a.btn-user-login').on('click', function (e) {
    e.preventDefault();
    $('form.admin-login').submit();
})
$('a.admin-btn').on('click', function (e) {
    e.preventDefault();
    $('form.admin-form').submit();
})
$('form#search-form button').on('click', function (e) {
    e.preventDefault();
    $('form#search-form').submit();
})
$('a.admin-btn-social').on('click', function (e) {
    e.preventDefault();
    $('form.admin-form-social').submit();
})
$('a.admin-btn-images').on('click', function (e) {
    e.preventDefault();
    $('form.admin-form-images').submit();
})
$('a.admin-btn-password').on('click', function (e) {
    e.preventDefault();
    $('form.admin-form-password').submit();
})

$('#alert-message').fadeIn(3000).delay(5000).fadeOut(1000);
$('#alert-message').hover( function() {
    $(this).stop().fadeIn(100);
}, function(){
    $(this).fadeIn(3000).delay(3000).fadeOut(1000);
});
$('#alert-message').on('click', function() {
    $(this).alert('close')
});

$('#add-email-setting').on('click', function() {
    $('#add-email-setting').prev().append('<div class="delete_input"><input type="email" name="site_email[]"  value="" class="mb-1 form-control" required><i class="fa fa-times "></i></div>');
});
$('#add-number-setting').on('click', function() {
    $('#add-number-setting').prev().append('<div class="delete_input"><input type="number" name="phone_number[]"  value="" class="mb-1 form-control" required><i class="fa fa-times "></i></div>');
});

/* add comment */
$('.comment .comment-options a.add-replay').on('click', function() {

    console.log('sd');
    $('ul li .add-replay-form').each(function(){
        $(this).removeClass('show');
    })
    $(this).parents('li').find('.add-replay-form').addClass('show');
    // console.log($(this).parents('li').find('.add-replay-form'));

});
/* add comment */

/* $('.area-chart-options a').on('click', function() {
    console.log( '/api/area-chart/' + $(this).data('time'));
}); */    

$('#add-post-image span').on('click', function() {
    var idNumber = getRandom(4,100);
    $('.add-post-images').append('<div class="custom-file mb-1"><input name="images[]"  type="file" class="custom-file-input" id="post-image-'+idNumber+'"><label for="post-image-'+idNumber+'" class="custom-file-label">Choose file...</label></div>');
});

$(document).on('click', '.delete_input i', function() {
    $(this).parent().html('');
});

});