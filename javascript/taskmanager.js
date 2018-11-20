(function($){

    $(document).ready(function() {

        $('.tasks-toggle').click(function() {

            //toggle the task list
            $('.tasks').toggle('slow',function() {
                //check to see if this is open or closed
                if ($(this).hasClass('open')) {
                    $('.tasks-toggle').css('background-position-x','0px');
                    $(this).removeClass('open');
                }else{
                    $('.tasks-toggle').css('background-position-x','-50px');
                    $(this).addClass('open');
                }
            });
            
        });
        
        
        $('.new-task-toggle').click(function() {

            //toggle the task list
            $('.new-task').toggle('slow',function() {
                //check to see if this is open or closed
                if ($(this).hasClass('open')) {
                    $('.new-task-toggle').css('background-position-x','0px');
                    $(this).removeClass('open');
                }else{
                    $('.new-task-toggle').css('background-position-x','-50px');
                    $(this).addClass('open');
                }
            });
            
        });
        
        
        /*
         * Allow divs to be selected and used to report problems
         */
        $('.element-selector').click(function() {
            
            //prevent default
            $('a').click(function(e) {
                e.preventDefault();
            });
            
            //handle hovering in and out of elements
            $('*:not(.tasks-container *):not(body):not(html)').hover(function() {
                $(this).css('background-color','yellow')
                
                //allow the page to be clicked
                $(this).click(function() {
                    
                    //does the element have a class? if not default to id
                    if ($(this).attr('class')) {
                        $('.display-element').html($(this).prop('nodeName').toLowerCase()+'.' +$(this).first().attr('class').split(' ').join('.'));
                        $('#Form_TaskManagerForm_Element').val($(this).prop('nodeName').toLowerCase()+'.' +$(this).first().attr('class').split(' ').join('.'));
                        
                    }else{
                        $('.display-element').html($(this).prop('nodeName').toLowerCase()+'#' +$(this).first().attr('id'));
                        $('#Form_TaskManagerForm_Element').val($(this).prop('nodeName').toLowerCase()+'#' +$(this).first().attr('id'));
                    }
                    
                    //remove hover effect
                    $('*:not(.tasks-container *)').unbind('mouseenter').unbind('mouseleave')
                    //remove color
                    $('*:not(.tasks-container *)').css('background-color','')
                    
                    $('a').unbind("click");
                });
                
            },function() {
                $(this).css('background-color','')
            });
        });
        
        /*
         * show element for issue
         */
        $('.ele span').click(function() {
            
            //get target
            var target = $(this).attr('data-target');
            //change background color
            $(target).css('background-color','yellow');
            
            setTimeout(function() {
                $(target).css('background-color','');
            }, 500);
            
        });


        /*
         * allows completion of a task
         */
        $('.tasks-container .complete a').click(function() {
            
            //show the green checkmark
            $(this).css('background-position-x','-120px');
            
        });



    });
 })(jQuery); 