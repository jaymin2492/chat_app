
  jQuery(document).ready(function() {
      jQuery(".list-group-item").on("click", function() {
          jQuery(".list-group-item").removeClass("active");
          jQuery(this).addClass("active");
          jQuery(".user_chat_panel").show();
          jQuery(".user_list_panel").removeClass("col-sm-12").addClass("col-sm-4");
          var curSelectedUSerID = jQuery(this).attr("data-user-id");
          jQuery.ajax({
              url: baseUrl+"/chat/user",
              method: 'get',
              data: {
                  user_id: curSelectedUSerID
              },
              success: function(result) {
                  if (result.success) {
                      var messagehtml = '';
                      jQuery.each(result.data, function(i, item) {
                          if (curAuthId == item.from_user_id) {
                              messagehtml = messagehtml + '<div class="current text-right bg-red-400 text-white float-right">' + item.message + '<a href="javascript:void(0);" data-id="' + item.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg></a></div>';
                          } else {
                              messagehtml = messagehtml + '<div class="float-left bg-blue-400 text-white">' + item.message + '</div>';
                          }
                      });
                      jQuery(".user_chat_panel .panel-body").html(messagehtml);
                  } else {
                      alert(result.message);
                  }
              }
          });
      });
      jQuery("#chat_form").on("submit", function(e) {
          e.preventDefault();
          if (jQuery(".list-group-item.active").length > 1) {
              alert('Something went wrong. Please reload the page and try again')
          }
          var message = jQuery("#message").val();
          message = message.trim();
          if (message == "") {
              return false;
          }
          var curSelectedUSerID = jQuery(".list-group-item.active").attr("data-user-id");
          jQuery.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          jQuery.ajax({
            url: baseUrl+"/chat/user",
              method: 'post',
              data: {
                  user_id: curSelectedUSerID,
                  message: message
              },
              success: function(result) {
                  if (result.success) {
                      jQuery("#message").val('');
                      jQuery(".list-group-item.active").trigger("click");
                  } else {
                      alert(result.message);
                  }
              }
          });
      })
      jQuery(document).on("click", ".user_chat_panel .panel-body div.current a", function(e) {
          var messageID = jQuery(this).attr("data-id");
          jQuery.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          jQuery.ajax({
              url: baseUrl+"/chat/delete",
              method: 'post',
              data: {
                  message_id: messageID
              },
              success: function(result) {
                  if (result.success){
                      jQuery(".list-group-item.active").trigger("click");
                  }
              }
          });
      })
      setInterval(function(){
          if(jQuery(".list-group-item.active").length == 1){
              jQuery(".list-group-item.active").trigger("click");
          }
      },1000);
  })