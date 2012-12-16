/*
 * delete.js
 * affiche un popup quand on click sur un lien
 * require jQuery
 */

$("a.delete").click(function(e){
  $title = $(this).prev(".title");
  var query = window.confirm("Delete this item ?");
  return query;
});

