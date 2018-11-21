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
                
                var target = new Array();;
                
                //pass in the selected element
                target.push(""+$(element).get(0).nodeName.toLowerCase()+':contains("'+$(element).text()+'")');
                
                $(element).parentsUntil('html').each(function() {
                    target.push(""+$(this).get(0).nodeName.toLowerCase())
                });

                target = target.reverse().join(" ");

                
                $('.display-element').html(target);
                $('#Form_TaskManagerForm_Element').val(target);
                $('a').unbind("click");

            }
            
            var myDomOutline = DomOutline({ onClick: myExampleClickHandler});

            // Start outline:
            myDomOutline.start();
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