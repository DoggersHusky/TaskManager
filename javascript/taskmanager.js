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
        
        $('.all-tasks-toggle').click(function() {

            //toggle the task list
            $('.all-task').toggle('slow',function() {
                //check to see if this is open or closed
                if ($(this).hasClass('open')) {
                    $('.all-tasks-toggle').css('background-position-x','0px');
                    $(this).removeClass('open');
                }else{
                    $('.all-tasks-toggle').css('background-position-x','-50px');
                    $(this).addClass('open');
                }
            });
            
        });
        
        $('.element-selector').click(function() {
            
            //prevent default
            $('a').click(function(e) {
                e.preventDefault();
            });
            
            var myExampleClickHandler = function (element) {
                
                $('.display-element').html(element.outerHTML);
                $('#Form_TaskManagerForm_Element').val(element.outerHTML);
                $('a').unbind("click");

            }
            var myDomOutline = DomOutline({ onClick: myExampleClickHandler});

            // Start outline:
            myDomOutline.start();
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