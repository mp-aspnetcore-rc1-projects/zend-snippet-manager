/*
 * delete.js
 * affiche un popup quand on click sur un lien
 * require jQuery
 */
$(function(e){
  $.each($(".grid .created"),function(i,o){
    $(this).text(new Date(   Math.floor(parseInt($(this).text()*1000)   )).toUTCString() );
  });
});