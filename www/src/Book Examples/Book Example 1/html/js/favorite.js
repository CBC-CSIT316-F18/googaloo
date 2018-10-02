// favorite.js
// This script is created in Chapter 14.
// This script is included by page.php.
$(function() {

  $('#add_favorite_link').click(function(){
    manage_favorites('add');
    return false;
  });

  $('#remove_favorite_link').click(function(){
    manage_favorites('remove');
    return false;
  });

  function manage_favorites(action) {
    $.ajax({
      url: 'ajax/favorite.php',
      type: 'GET',
      dataType: 'text',
      data: {
        page_id: page_id,
        action: action
      },
      success: function(response) {
        if (response === 'true') {
          update_page(action);
        } else {
          // Do something!
        }
      } // Success function.
    }); // Ajax
  } // End of manage_favorites() function.

    function update_page(action) {
    if (action === 'add') {
      $('#favorite_h3').html('<img src="images/heart_32.png" width="32" height="32"> <span class="label label-info">This a favorite!</span> <a id="remove_favorite_link" href="remove_from_favorites.php?id=' + page_id + '"><img src="images/close_32.png" width="32" height="32"></a></h3>');
      $('#remove_favorite_link').click(function(){ manage_favorites('remove'); return false; });
    } else {
      $('#favorite_h3').html('<h3 id="favorite_h3"><span class="label label-info">Make this a favorite!</span> <a id="add_favorite_link" href="add_to_favorites.php?id=' + page_id + '"><img src="images/heart_32.png" width="32" height="32"></a></h3>');
      $('#add_favorite_link').click(function(){ manage_favorites('add'); return false; });
    }
  } // End of update_page() function.



}); // Main anonymous function   