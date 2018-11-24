(function($){

    $(document).ready(function() {
        
        /*
         * handles opening and closing of the tabs
         */
        $('.tasks-container .toggle').click(function() {
            
            var target = '.'+$(this).attr('data-target');
            
            $(target).toggle('slow',function() {
                //check to see if this is open or closed
                if ($(this).hasClass('open')) {
                    $(target+'-toggle').css('background-position-x','0px');
                    $(this).removeClass('open');
                }else{
                    $(target+'-toggle').css('background-position-x','-50px');
                    $(this).addClass('open');
                }
            });
            
        });
        
        /*
         * start the element selector
         */
        $('.element-selector').click(function() {
            
            //prevent default
            $('a').click(function(e) {
                e.preventDefault();
            });
            
            //close new tab
            $('.new-task-toggle').click();
            
            var myExampleClickHandler = function (element) {
                
                //an array to store the selected element and parents
                var selector = new Array();;
                var target = $(element);
                //element to display to user
                var targetElement;
                //use to store class
                var eleClass = "";
                var eleID = "";
                
                //does this have a class
                if (element.className) {
                    eleClass = "."+element.className.replace(/\s/g,".");
                }
                    
                //pass in the selected element
                selector.push(""+target.get(0).nodeName.toLowerCase()+eleClass+':contains("'+ $.trim( target.text() ) +'")');
                //update target element
                targetElement = target.get(0).nodeName.toLowerCase()+eleClass;
                
                //get all the parents of the element so we make sure we are targeting the correct element
                $(element).parentsUntil('html').each(function() {
                    //clear the variable
                    eleClass = "";
                    
                    //does this have a class
                    if ($(this).attr("class")) {
                        eleClass = "."+$(this).attr("class").replace(/\s/g,".");
                    }
                    
                    //push to array
                    selector.push(""+$(this).get(0).nodeName.toLowerCase()+eleClass)
                });
                
                //reverse the array
                selector = selector.reverse().join(" ");
                
                //update the display element and hidden field
                $('#Form_TaskManagerForm_Ele_Holder i').html(targetElement);
                $('#Form_TaskManagerForm_Element').val(selector);
                $('a').unbind("click");
                
                //check to see if it failed to find target
                if (!$(selector).length > 0) {
                    
                    //output to console
                    console.log('Target could not be found. Trying second approach.');
                    
                    //try removing contains
                    selector = selector.substring(0, selector.indexOf(':'));
                    
                    //check to see if it failed to find target
                    if (!$(selector).length > 0) {
                        
                        //output to console
                        console.log('Odd case detected: '+selector);
                        
                    }
                    
                }
                
                //reopen new tab
                $('.new-task-toggle').click();
                
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
            $(target).addClass('task-manager-select');

            setTimeout(function() {
                $(target).removeClass('task-manager-select');
            }, 1000);
            
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