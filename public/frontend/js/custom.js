// const { use } = require("vue/types/umd");

$(function () {

    $('#alert-message').fadeIn(3000).delay(5000).fadeOut(1000);
    $('#alert-message').hover( function() {
        $(this).stop().fadeIn(100);
    }, function(){
        $(this).fadeIn(3000).delay(3000).fadeOut(1000);
    });
    $('#alert-message').on('click', function() {
        $(this).alert('close')
    });
   
    $('.carousel').carousel();

    $('.minisearch .field__search .action a').on('click', function(event) {
        event.preventDefault();
        $('form.srearch-form').submit();
    })

    $('#add-post-image span').on('click', function() {
        $('.add-post-images').append('<input name="images[]"  type="file" class="form-control mb-1" >');
    })

    /* $('.blog-details .comments_area .comment__list li .wn__comment .content .comnt__author .reply__btn a').on('click', function() {
        // console.log($(this).parentsUntil('.wn__comment', '.content').children('.replay-for-comment'));
        $(this).parentsUntil('.wn__comment', '.content').children('.replay-for-comment').css('display','block');
    }); */
    
    /* $('.blog-details .replay-for-comment.comment_respond .comment__form .submite__btn').on('click', function(e){
        e.preventDefault();
        var commentContainer = $(this).parentsUntil('li', '.wn__comment');        
        var wn__comment = $(this).parentsUntil('ul', 'li').children()[0];
        var parentUl = $(this).parentsUntil('ul', 'li').children()[1];

        var name = commentContainer.find('.name input').val();
        var email = commentContainer.find('.email input').val();
        var textarea = commentContainer.find('textarea').val();
        var _token = commentContainer.find('input[name=_token]').val();
        var comment_id = commentContainer.find('input.comment_id').val();
        var post_slug = $('.post-slug').text();
        let commentLi = '';
        

        var data = {
            _token      : _token,
            name        : name, 
            email       : email,
            textarea    : textarea,
            comment_id  : comment_id,
            post_slug   : post_slug,           
        };
        var url = 'https://blogz.test/comment/' + post_slug;

        $.ajax({
            url: url,
            type : "POST",
            data: data,
            async: false,
            success: function(result)  {
                // console.log(result);

                commentLi += '<li><div class="wn__comment"><div class="thumb"><img src="" alt="comment images"></div><div class="content"><div class="comnt__author d-block d-sm-flex">';
                if(result.user == 1) {
                    commentLi += '<span><a href="#">'+ result.name +'</a> <span class="text-success">Post author</span> </span>';
                }else {
                    commentLi += '<span>'+ result.name +'</span>';
                }
                commentLi += '<span>date format</span><div class="reply__btn"><a href="#comment_areaa" data-comment="'+ result.comment_id +'">Reply</a></div></div>';
                commentLi += '<p>'+ result.comment +'</p>';
                commentLi += '<div class="comment_respond replay-for-comment"><form class="comment__form" action="'+ url +'" method="POST">';
                commentLi += '<input type="hidden" value="'+ _token +'" name="_token" /><input type="hidden" value="'+ result.comment_id +'" name="comment_id" class="comment_id"/><div class="input__wrapper clearfix"><div class="input__box name one--third"><input class="shadow-2" name="name" type="text" placeholder="name" value=""';
                if(result.user == 1) {
                    commentLi += 'readonly ></div>';
                }else {
                    commentLi +=  '></div>';                  
                }
                commentLi += '<div class="input__box email one--third">';
                commentLi += '<input class="shadow-2" name="email" type="email" placeholder="email"  value=""';
                if (result.user == 1) {
                    commentLi += 'readonly ></div></div>';
                }else {
                    commentLi +=  '></div></div>';
                }
                commentLi += '<div class="input__box"><textarea class="shadow-2" name="comment" placeholder="Your comment here"></textarea></div><div class="submite__btn"><input type="submit" value="Post Comment"/></div></form></div></div></div></li>';
                    

            } // end success
          });// end ajax
                    
        // اذا كان يوجد ولد الإندكس له 1 هذا يدل على وجود ul
        if(parentUl != undefined) {
            $(this).parentsUntil('ul', 'li .wn__comment').next().append(commentLi);
            // console.log($(this).parentsUntil('ul', 'li').children('ul'));
        }else {            
            $(this).parentsUntil('ul', 'li .wn__comment').after('<ul class="comment__list">' + commentLi + '</ul>');
        }
        
        // $(this).parentsUntil('li', '.wn__comment').after('<ul class="comment__list"><li><div class="wn__comment"><div class="thumb"><img src="" alt="comment images"></div><div class="content"><div class="comnt__author d-block d-sm-flex"><span>test nane</span><span>2020</span><div class="reply__btn"><a href="#comment_areaa" data-comment="">Reply</a></div></div><p></p></div></div></li></ul>');
    }); */
    
});