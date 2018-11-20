/*
* Allow divs to be selected and used to report problems
*/
$('.element-selector').click(function() {

   //prevent default
   $('a').click(function(e) {
       e.preventDefault();
   });

   //handle hovering in and out of elements
   $('body *:not(.tasks-container *)').hover(function() {
       $(this).css('background-color','yellow')

       //allow the page to be clicked
       $(this).click(function() {

           //does the element have a class? if not default to id
           if ($(this).attr('class')) {
               $('.display-element').html($(this).prop('nodeName').toLowerCase()+'.' +$(this).last().attr('class').split(' ').join('.'));
               $('#Form_TaskManagerForm_Element').val($(this).prop('nodeName').toLowerCase()+'.' +$(this).last().attr('class').split(' ').join('.'));

           }else{
               $('.display-element').html($(this).prop('nodeName').toLowerCase()+'#' +$(this).last().attr('id'));
               $('#Form_TaskManagerForm_Element').val($(this).prop('nodeName').toLowerCase()+'#' +$(this).last().attr('id'));
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