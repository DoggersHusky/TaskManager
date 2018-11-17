(function($){

    $(document).ready(function() {

        $('.tasks-toggle').click(function() {

            //toggle the task list
            $('.tasks').toggle('slow',function() {
                //check to see if this is open or closed
                if ($(this).hasClass('open')) {
                    $('.tasks-toggle').css('background-position','0px');
                    $(this).removeClass('open');
                }else{
                    $('.tasks-toggle').css('background-position','50px');
                    $(this).addClass('open');
                }
            });
            
        });
        
        
        $('.new-task-toggle').click(function() {

            //toggle the task list
            $('.new-task').toggle('slow',function() {
                //check to see if this is open or closed
                if ($(this).hasClass('open')) {
                    $('.new-task-toggle').css('background-position','0px');
                    $(this).removeClass('open');
                }else{
                    $('.new-task-toggle').css('background-position','50px');
                    $(this).addClass('open');
                }
            });
            
        });
        
        

    })



 })(jQuery); 