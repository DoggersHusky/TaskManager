(function($) {
    $(document).ready(function() {
        /*
         * handles opening and closing of the tabs
         */
        $(".tasks-container .toggle").click(function() {
            let parent = $(this);
            let target = "." + parent.attr("data-target");

            // remove the open class
            $('.task-holder .open').not(target).removeClass('open');
            $('.tasks-container .toggle.active').not(parent).removeClass('active');
            
            // add active classes
            parent.toggleClass('active');
            $(target).toggleClass('open');
        });

        /*
         * hide the open tabs so we can select everything
         */
        function hideTaskManager() {
            $('.tasks-container').css('display', 'none');
        }

        /**
         * show the task manager
         */
        function showTaskManager() {
            $('.tasks-container').css('display', '');
        }

        /*
         * start the element selector
         */
        $(".element-selector").click(function() {
            //prevent default
            $("a").click(function(e) {
                e.preventDefault();
            });

            //hide task manager
            hideTaskManager();

            var myExampleClickHandler = function(element) {
                //an array to store the selected element and parents
                var selector = new Array();
                var target = $(element);
                //element to display to user
                var targetElement;
                //use to store class
                var eleClass = "";
                var eleID = "";

                //does this have a class
                if (element.className) {
                    eleClass = "." + element.className.replace(/\s/g, ".");
                }

                //pass in the selected element
                selector.push(
                    "" +
                        target.get(0).nodeName.toLowerCase() +
                        eleClass +
                        ':contains("' +
                        $.trim(target.text()) +
                        '")'
                );
                
                //update target element
                targetElement = target.get(0).nodeName.toLowerCase() + eleClass  +
                ':contains("' +
                $.trim(target.text()) +
                '")';

                //get all the parents of the element so we make sure we are targeting the correct element
                $(element)
                    .parentsUntil("body")
                    .each(function() {
                        //clear the variable
                        eleClass = "";

                        //does this have a class
                        if ($(this).attr("class")) {
                            eleClass =
                                "." +
                                $(this)
                                    .attr("class")
                                    .replace(/\s/g, ".");
                        }

                        //push to array
                        selector.push(
                            "" +
                                $(this)
                                    .get(0)
                                    .nodeName.toLowerCase() +
                                eleClass
                        );
                    });

                //reverse the array
                selector = selector.reverse().join(" ");

                //update the display element and hidden field
                $("#Form_TaskManagerForm_Ele_Holder i").html(targetElement);
                $("#Form_TaskManagerForm_Element").val(selector);
                $("a").unbind("click");

                //check to see if it failed to find target
                if (!$(selector).length > 0) {
                    //output to console
                    console.log(
                        "Target could not be found. Trying second approach."
                    );

                    //try removing contains
                    selector = selector.substring(0, selector.indexOf(":"));

                    //check to see if it failed to find target
                    if (!$(selector).length > 0) {
                        //output to console
                        console.log("Odd case detected: " + selector);
                    }
                }

                //show hidden task manager
                showTaskManager();
            };

            var myDomOutline = DomOutline({ onClick: myExampleClickHandler });

            // Start outline:
            myDomOutline.start();
        });

        /*
         * show element for issue
         */
        $(".ele span").click(function() {
            //get target
            var target = $(this).attr("data-target");
            //replace br with ")
            target = target.replace("<br />", '")');
            //delete everything after the first ")
            target = target.substring(-1, target.indexOf('")') + '")'.length);

            //change background color
            $(target).addClass("task-manager-select");

            //scroll page to element
            $("html, body").animate(
                {
                    scrollTop: $(target)
                        .first()
                        .offset().top
                },
                500
            );

            setTimeout(function() {
                $(target).removeClass("task-manager-select");
            }, 1000);
        });

        /*
         * allows completion of a task
         */
        $(".tasks-container .complete a").click(function() {
            //show the green checkmark
            $(this).css("background-position-x", "-120px");
        });
    });
})(jQuery);
