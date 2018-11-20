/*
* Allow divs to be selected and used to report problems
*/
$('.element-selector').click(function() {

   //prevent default
   $('a').click(function(e) {
       e.preventDefault();
   });

   $('body div:last-child:not(.tasks-container *)').each(function() {
       
        $(this).hover(function() {
           
            //highlight yellow 
            $(this).css('background-color','yellow');
           
        },function() {
            $(this).css('background-color','')
        });
       
       $(this).click(function() {
            var createdTarget;
            
            if ($(this).parent().attr('class')) {
                createdTarget = $(this).parent().prop('nodeName').toLowerCase()+'.' +$(this).parent().last().attr('class').split(' ').join('.');
            }else{
                createdTarget = $(this).parent().prop('nodeName').toLowerCase()+'#' +$(this).parent().last().attr('id');
            }
            
            if ($(this).attr('class')) {
                createdTarget += " " + $(this).prop('nodeName').toLowerCase()+'.' +$(this).last().attr('class').split(' ').join('.');
            }else{
                createdTarget += " " + $(this).prop('nodeName').toLowerCase()+'#' +$(this).last().attr('id');
            }
            
            
            $('.display-element').html(createdTarget);
            $('#Form_TaskManagerForm_Element').val(createdTarget);
            
            //remove hover effect
            $('*:not(.tasks-container *)').unbind('mouseenter').unbind('mouseleave')
            //remove color
            $('*:not(.tasks-container *)').css('background-color','');
            $('a').unbind("click");

       });
       
   });
   
   
});