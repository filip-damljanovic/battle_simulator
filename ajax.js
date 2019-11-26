// GET GAMES REQUEST
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('get_games').onclick = function () {

    var req;
    req = new XMLHttpRequest();
    req.open("GET", '/api/game/get_all.php', true);
    req.send();

    req.onload = function () {
      var json = JSON.parse(req.responseText);
      var html = "";

      //loop and display data
      json.forEach(function (val) {
        var keys = Object.keys(val);

        html += "<div class = 'cat'>";
        keys.forEach(function (key) {
          html += "<strong>" + key + "</strong>: " + val[key] + "<br>";
        });
        html += "</div><br>";
      });

      //append in message class
      document.getElementsByClassName('message')[0].innerHTML = html;
    }
  }
});

// GET GAME LOG REQUEST
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('get_game_log').onclick = function () {
    var $id = $('#game_id_1')[0].value;

    var req;
    req = new XMLHttpRequest();
    req.open("GET", '/api/game/get_log.php?id=' + $id, true);
    req.send();

    req.onload = function () {
      var json = JSON.parse(req.responseText);
      var html =  "";

      //display data
      var keys = Object.keys(json);

      html += "<div class = 'cat'>";
      keys.forEach(function (key) {
        html += "<strong>" + key + "</strong>: " + json[key] + "<br>";
      });
      html += "</div><br>";

      //append in message class
      document.getElementsByClassName('message')[1].innerHTML = html;
    }
  }
});

// CREATE GAME REQUEST
$(document).ready(function () {
  $('#create_game').click(function (e) {
    e.preventDefault();

    //get input
    var $game_name = $('#game_name');

    function getFormData($form) {
      var unindexed_array = $form.serializeArray();
      var indexed_array = {};

      $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];
      });

      return indexed_array;
    }

    //pass serialized data to function
    var game_data = getFormData($game_name);
    game_data = JSON.stringify(game_data);
    
    //post with ajax
    $.ajax({
      type: "POST",
      url: "/api/game/create.php",
      data: game_data,
      ContentType: "application/json",

      success: function (response) {
        // Check if response ID is undefined
        if (typeof response.id != 'undefined') {
          // Get created game ID
          var game_id = response.id;

          // Add newly created ID to options
          $("#game_id_1").append("<option selected value='" + game_id + "'>" + game_id + "</option>");
          $("#game_id_2").append("<option selected value='" + game_id + "'>" + game_id + "</option>");
          $("#game_id_3").append("<option selected value='" + game_id + "'>" + game_id + "</option>");
          $("#game_id_4").append("<option selected value='" + game_id + "'>" + game_id + "</option>");
        }
        alert(response.message);
      },
      error: function (xhr) {
        alert(xhr.responseText);
      }

    });
  });
});
    
// CREATE ARMY REQUEST
$(document).ready(function(){
  $('#create_army').click(function(e){
    e.preventDefault();

    //get form data
    var $form = $('#army_form');

    //serialize form data
    function getFormData($form) {
      var unindexed_array = $form.serializeArray();
      var indexed_array = {};

      $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];
      });

      return indexed_array;
    }

    //pass serialized data to function
    var army_data = getFormData($form);
    army_data = JSON.stringify(army_data);

    //post with ajax
    $.ajax({
      type:"POST",
      url: "/api/army/create.php",
      data: army_data,
      ContentType:"application/json",

      success:function(response){
        alert(response.message);
      },
      error:function(xhr){
        alert(xhr.responseText);
      }

    });
  });
});

// START A GAME REQUEST
$(document).ready(function () {
  $('#start_game').click(function (e) {
    e.preventDefault();

    //get form data
    var $id = $('#game_id_3')[0].value;

    //post with ajax
    $.ajax({
      type: "POST",
      url: "/api/game/start.php?id=" + $id,
      ContentType: "application/json",

      success: function (response) {
        // Update game log imediately
        var $id = $('#game_id_1')[0].value;

        var req;
        req = new XMLHttpRequest();
        req.open("GET", '/api/game/get_log.php?id=' + $id, true);
        req.send();

        req.onload = function () {
          var json = JSON.parse(req.responseText);
          var html = "";

          //display data
          var keys = Object.keys(json);

          html += "<div class = 'cat'>";
          keys.forEach(function (key) {
            html += "<strong>" + key + "</strong>: " + json[key] + "<br>";
          });
          html += "</div><br>";

          //append in message class
          document.getElementsByClassName('message')[1].innerHTML = html;
        }
        alert(response.message);
      },
      error: function (xhr) {
        alert(xhr.responseText);
      }

      
    });
  });
});

// RESET A GAME REQUEST
$(document).ready(function () {
  $('#reset_game').click(function (e) {
    e.preventDefault();

    //get form data
    var $id = $('#game_id_4')[0].value;

    //post with ajax
    $.ajax({
      type: "POST",
      url: "/api/game/reset.php?id=" + $id,
      ContentType: "application/json",

      success: function (response) {
        // Update game log imediately
        var $id = $('#game_id_1')[0].value;

        var req;
        req = new XMLHttpRequest();
        req.open("GET", '/api/game/get_log.php?id=' + $id, true);
        req.send();

        req.onload = function () {
          var json = JSON.parse(req.responseText);
          var html = "";

          //display data
          var keys = Object.keys(json);

          html += "<div class = 'cat'>";
          keys.forEach(function (key) {
            html += "<strong>" + key + "</strong>: " + json[key] + "<br>";
          });
          html += "</div><br>";

          //append in message class
          document.getElementsByClassName('message')[1].innerHTML = html;
        }
        
        alert(response.message);
      },
      error: function (xhr) {
        alert(xhr.responseText);
      }

    });
  });
});