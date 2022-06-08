$(document).ready(function() {

  if(localStorage.getItem("panel") == "closed") {
    $("#kategoria").addClass("rejtett");
  }
  $("#panel-zaro").click(function() {
    $("#kategoria").animate({
      width: 0
    }, 700, function() {
      $("#kategoria").addClass("rejtett");
    })
    localStorage.setItem("panel", "closed")
  });

  $("#panel-nyito").click(function() {
    $("#kategoria").removeClass("rejtett");
    $("#kategoria").animate({
      width: "25%"
    }, 700, function() {
      localStorage.setItem("panel", "opened")
    })
  });

  $('input[name="search"]').click(function() {
    $('#cancel').show();
  });

  $('#search').click(function() {
    let str = $('input[name="search"]').val();
    let catArray = [];
    $.each($('.cat'),function(i, item) {
      if($(item).is(":checked")) {
        catArray[catArray.length] = $(item).attr("cat");
      };
    });
    if (catArray.length == 0) {

      $.ajax({
        method: "POST",
        url: "?library/searchBooks/",
        data: { 'title': str }
      })
      .done(function( msg ) {
        $("#table-content").html(msg);
        id = $("#table-content table td:first-child").attr("book");
        $.ajax({
          method: "POST",
          url: "?library/detail/",
          data: { 'book': id }
        })
        .done(function( msg ) {
          $("#detail-view").html(msg);
        });
      });
    } else {

      $.ajax({
        method: "POST",
        url: "?library/searchAndFilter/",
        data: { 'cat': 0, 'catArray': catArray, 'title': str}
      })
      .done(function( msg ) {
        $("#table-content").html(msg);
        id = $("#table-content table td:first-child").attr("book");
        $.ajax({
          method: "POST",
          url: "?library/detail/",
          data: { 'book': id }
        })
        .done(function( msg ) {
          $("#detail-view").html(msg);
        });
      });
    }
  });

  $('#cancel').click(function() {
    $('input[name="search"]').val('');
    let catArray = [];
    $.each($('.cat'),function(i, item) {
      if($(item).is(":checked")) {
        catArray[catArray.length] = $(item).attr("cat");
      };
    });
    if (catArray.length == 0) {
      $.ajax({
        method: "POST",
        url: "?library/allBooks/",
        data: null
      })
      .done(function( msg ) {
        $("#table-content").html(msg);
        id = $("#table-content table td:first-child").attr("book");
        $.ajax({
          method: "POST",
          url: "?library/detail/",
          data: { 'book': id }
        })
        .done(function( msg ) {
          $("#detail-view").html(msg);
        });
      });
    } else {
      $.ajax({
        method: "POST",
        url: "?library/searchCategories/",
        data: { 'cat': 0, 'catArray': catArray}
      })
      .done(function( msg ) {
        $("#table-content").html(msg);
        //$('input[name="search"]').val('');
        //$('#cancel').hide();
        id = $("#table-content table td:first-child").attr("book");
        $.ajax({
          method: "POST",
          url: "?library/detail/",
          data: { 'book': id }
        })
        .done(function( msg ) {
          $("#detail-view").html(msg);
        });

      });
    };
  });


  $('.book-row').click(function() {
    let id = $(this).attr('book');
    alert(id);
    $.ajax({
      method: "POST",
      url: "?library/detail/",
      data: { 'book': id }
    })
    .done(function( msg ) {
      $("#detail-view").html(msg);
    });
  });

  $('main').prepend("<img id='loading' style='width: 60%; z-index: 500; position: absolute; top:200px; left: 300px; opacity: 0.5;' src='Sources/img/spiner.gif'>");
  let loading = $('#loading').hide();
  $(document).ajaxStart(function() {
    loading.show();
  }).ajaxStop(function() {
    loading.hide();
  });


  $('.cat').click(function() {
    let catArray = [];
    let id = $(this).attr("cat");
    let check = $(this).is(":checked");
    $.each($('.cat'),function(i, item) {
      if($(item).is(":checked")) {
        catArray[catArray.length] = $(item).attr("cat");
      };
    });
    if($('input[name="search"]').val()=='') {
        $.ajax({
          method: "POST",
          url: "?library/searchCategories/",
          data: { 'cat': id, 'catArray': catArray}
        })
        .done(function( msg ) {
          $("#table-content").html(msg);
          //$('input[name="search"]').val('');
          //$('#cancel').hide();
          id = $("#table-content table td:first-child").attr("book");
          $.ajax({
            method: "POST",
            url: "?library/detail/",
            data: { 'book': id }
          })
          .done(function( msg ) {
            $("#detail-view").html(msg);
          });

        });
      } else {
        let str = $('input[name="search"]').val();
        $.ajax({
          method: "POST",
          url: "?library/searchAndFilter/",
          data: { 'cat': id, 'catArray': catArray, 'title': str}
        })
        .done(function( msg ) {
          $("#table-content").html(msg);
          id = $("#table-content table td:first-child").attr("book");
          $.ajax({
            method: "POST",
            url: "?library/detail/",
            data: { 'book': id }
          })
          .done(function( msg ) {
            $("#detail-view").html(msg);
          });
        });
      };
    });



  /* $("#search").click(function() {
    $("#megse").css("display", "inline-block");
  });

  $("#megse").click(function() {
    $("#megse").hide();
  }); */

/*  $(".cat").click(function() {
    //if(this.checked) {
      //$(this).attr("szamlalo", Number($(this).attr("szamlalo")) + 1);
      let szamlalo = sessionStorage.getItem($(this).attr("id"));
      szamlalo++;
      sessionStorage.setItem($(this).attr("id"), szamlalo);
      $(this).text($(this).attr("id") + " (" + sessionStorage.getItem($(this).attr("id")) + ")");
      //$(this).text($(this).attr("id") + " (" + $(this).attr("szamlalo") + ")");
    //}
  });*/

});
