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
                
                //an array to store the selected element and parents
                var selector = new Array();;
                var target = $(element);
                var eleClass;
                var eleID;
                
                //does this have a class
                if (element.className) {
                    eleClass = "."+element.className.replace(" ", ".");
                }
                    
                //pass in the selected element
                selector.push(""+target.get(0).nodeName.toLowerCase()+eleClass+':contains("'+ $.trim( target.text() ) +'")');
                
                //get all the parents of the element so we make sure we are targeting the correct element
                $(element).parentsUntil('html').each(function() {

                    //does this have a class
                    if ($(this).attr("class")) {
                        eleClass = "."+$(this).attr("class").replace(" ", ".");
                    }
                    
                    selector.push(""+$(this).get(0).nodeName.toLowerCase()+eleClass)
                });
                
                //reverse the array
                selector = selector.reverse().join(" ");
                
                //update the display element and hidden field
                $('.display-element').html(target.text());
                $('#Form_TaskManagerForm_Element').val(selector);
                $('a').unbind("click");
                
                //check to see if it failed to find target
                if (!$(selector).length > 0) {
                    
                    //try removing contains
                    selector = selector.substring(0, selector.indexOf(':'));
                    
                    //check to see if it failed to find target
                    if (!$(selector).length > 0) {
                        alert('failed');
                    }
                    
                }
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
            //replace br with ")
            target = target.replace('<br />', '")');
            //delete everything after the first ")
            target = target.substring(-1, target.indexOf('")')+ '")'.length );

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