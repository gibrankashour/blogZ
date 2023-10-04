$(function () {

    let commentLi;
    let commentContainer;
    let parentUl;
    let name;
    let email;
    let comment;
    let comment_id;
    let post_slug;

    let url;

    let addToAllCommentsContainer = false;

    function myCallback(result)  {
        console.log(result);
        if(result.errors != null) {

            //حتا لا يتكرر ظهور سالة الخطأ أكثر من مرة فإننا نحذف رسالة الخطأ السابقة
            commentContainer.find('input[name=name]').next().remove();
            commentContainer.find('input[name=email]').next().remove();
            commentContainer.find('textarea[name=comment]').next().remove();

            if(result.errors.name != null) {
               commentContainer.find('input[name=name]').addClass('is-invalid');               
               commentContainer.find('input[name=name]').after('<span class="error-input text-danger">' + result.errors.name + '</span>');
            }else{
                commentContainer.find('input[name=name]').removeClass('is-invalid');
            }
            if(result.errors.email != null) {
                commentContainer.find('input[name=email]').addClass('is-invalid');               
                commentContainer.find('input[name=email]').after('<span class="error-input text-danger">' + result.errors.email + '</span>');
            }else{
                commentContainer.find('input[name=email]').removeClass('is-invalid');
            }
            if(result.errors.comment != null) {
                commentContainer.find('textarea[name=comment]').addClass('is-invalid');               
                commentContainer.find('textarea[name=comment]').after('<span class="error-input text-danger">' + result.errors.comment + '</span>');
            }else{
                commentContainer.find('textarea[name=comment]').removeClass('is-invalid');
            }


        }else{
            // إذا لم يكن يوجد أحطاء في الفاليديشن
            commentLi = '<li><div class="wn__comment"><div class="thumb"><img src="http://localhost/blogz/public/assets/default/comment.jpeg" alt="comment images"></div><div class="content"><div class="comnt__author d-block d-sm-flex">';
            if(result.user == 1) {
                commentLi += '<span><a href="#">'+ result.name +'</a> <span class="text-success">Post author</span> </span>';
            }else {
                commentLi += '<span>'+ result.name +'</span>';
            }
            commentLi += '<span>'+ result.create_date +'</span><div class="reply__btn"><a href="javascript:void(0)" data-comment="'+ result.comment_id +'">Reply</a></div></div>';
            commentLi += '<p>'+ result.comment +'</p>';
            commentLi += '<div class="comment_respond replay-for-comment"><form class="comment__form" action="'+ url +'" method="GET">';
            commentLi += '<input type="hidden" value="'+ result.comment_id +'" name="comment_id" class="comment_id"/><div class="input__wrapper clearfix"><div class="input__box name one--third"><input class="shadow-2" name="name" type="text" placeholder="name" ';
            if(result.user == 1) {
                commentLi += ' value="'+ result.name +'" readonly ></div>';
            }else {
                commentLi +=  ' value="" ></div>';                  
            }
            commentLi += '<div class="input__box email one--third">';
            commentLi += '<input class="shadow-2" name="email" type="email" placeholder="email"  ';
            if (result.user == 1) {
                commentLi += '  value="'+ result.email +'" readonly ></div></div>';
            }else {
                commentLi +=  '  value="" ></div></div>';
            }
            commentLi += '<div class="input__box"><textarea class="shadow-2" name="comment" placeholder="Your comment here"></textarea></div><div class="submite__btn"><input type="submit" value="Post Comment"/></div></form></div></div></div></li>';
            
            if(addToAllCommentsContainer == true){    
                // إذا كان تعليق عام على البوست        
                $('.comments_area > .comment__list').prepend(commentLi);
                addToAllCommentsContainer = false;
            }else {
                // إذا كان رد على أحد التعليقات
                if(parentUl != undefined) {
                    // اذا كان يوجد ولد الإندكس له 1 هذا يدل على وجود ul
                    commentContainer.next().append(commentLi);
                }else {
                    commentContainer.after('<ul class="comment__list">' + commentLi + '</ul>');
                }
            }

            // حذف محوى التيكست إريا بعد إضافة التعليق
            commentContainer.find('textarea[name=comment]').val('');
            // حذف رسائل الحطأ السابقة بعد إضافة التعليق
            commentContainer.find('input[name=name]').next().remove();
            commentContainer.find('input[name=email]').next().remove();
            commentContainer.find('textarea[name=comment]').next().remove();
            // حذف الكلاس الخاص بتنسيق الفاليديشن بعد نجاح إضافة تعليق
            commentContainer.find('input[name=name]').removeClass('is-invalid');
            commentContainer.find('input[name=email]').removeClass('is-invalid');
            commentContainer.find('textarea[name=comment]').removeClass('is-invalid');

        }
    } // end success

    function addComment(e){

        e.preventDefault();

        if($(this).data('comment') == 'main'){ 
            commentContainer = $(this).parentsUntil('#comment_area', '.comment__form');
            addToAllCommentsContainer = true;
        }else{
            commentContainer = $(this).parentsUntil('li', '.wn__comment');
            parentUl = $(this).parentsUntil('ul', 'li').children()[1];
        }
        
        name = commentContainer.find('.name input').val() != '' ?commentContainer.find('.name input').val() : null;
        email = commentContainer.find('.email input').val();
        comment = commentContainer.find('textarea').val();
        comment_id = commentContainer.find('input.comment_id').val();
        post_slug = $('.post-slug').text();

        var data = {
            name        : name, 
            email       : email,
            comment    : comment,
            comment_id  : comment_id,
            post_slug   : post_slug,           
        };
        url = 'http://localhost/blogz/public/comment/' + post_slug;

        $.ajax({
            url: url,
            type : "GET",
            data: data,
            dataType : "json",
            success: myCallback,
          });// end ajax 
    }
    // إضافة رد على أحد التعليقات
    $('.blog-details .comments_area').on('click', '.replay-for-comment.comment_respond .comment__form .submite__btn', addComment);
    // إضافة رد على المقال
    $('.blog-details #comment_area.comment_respond .comment__form .submite__btn input').on('click', addComment);
    //أظهار الفورم لإضافة تعليق وإخفاء باقي الفورمز
    $('.blog-details .comments_area').on('click', '.wn__comment .content .comnt__author .reply__btn a', function() {
        $('.replay-for-comment.comment_respond').each(function() {
            $(this).css('display','none')
        });
        $(this).parentsUntil('.wn__comment', '.content').children('.replay-for-comment').css('display','block');
    });

});