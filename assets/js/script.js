function ReaderImageDisplay( files, class_box, w ) {
  var reader = new FileReader();
  w = (w) ? w : 100;
  reader.onload = function ( e ) {
    $('#' + class_box).html('<img style="width:' + w + 'px;" class="thumbnail" src="' + e.target.result + '">');
  };
  reader.readAsDataURL(files[0]);
}

function removeImage( id, tbl, col, e ) {
  if ( confirm('Are you sure') ) {
    $.ajax({
      type: 'POST',
      url: '/ajax/removeimage',
      data: {
        id: id,
        tbl: tbl,
        col: col
      },
      success: function ( data ) {
        if ( data ) {
          $(e).closest('#imageBox-' + col).html('');
        }
      }
    });
  }
}