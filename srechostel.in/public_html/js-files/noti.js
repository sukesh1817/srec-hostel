// const unreadNotification = document.querySelectorAll(".unreaded");
// const readedAllButton = document.querySelector(".header p");
// const unreadNotificationNumber = document.querySelector(
//   ".unread-notification-number"
// );
// const title = document.querySelector(
//   ".title"
// );
// var unreadNumber = 3;

// title.innerHTML = "Notifications";

// for (let i = 0; i < unreadNotification.length; i++) {
//   unreadNotification[i].onclick = () => {
//     unreadNotification[i].classList.add("notification-click");
//     unreadNotification[i].classList.add("readed");
//     unreadNotification[i].querySelector(
//       ".text .text-top p .unread-dot"
//     ).style.display = "none";
//     if(unreadNumber <= 2){
//       title.innerHTML = "Notification"
//     } 
//     if (unreadNumber == 0) {
//       unreadNumber = 0;
//       unreadNotificationNumber.innerHTML = unreadNumber;
//     } else {
//       unreadNumber -= 1;
//       unreadNotificationNumber.innerHTML = unreadNumber;
//     }
//     setTimeout(() => {
//       unreadNotification[i].classList.remove("notification-click");
//       unreadNotification[i].classList.add("readed");
//     });
//   };
// }

// readedAllButton.onclick = () => {
//   for (let i = 0; i < unreadNotification.length; i++) {
//     unreadNotification[i].classList.add("notification-click");
//     unreadNotification[i].classList.add("readed");
//     unreadNotification[i].querySelector(
//       ".text .text-top p .unread-dot"
//     ).style.display = "none";
//     unreadNumber = 0;
//     unreadNotificationNumber.innerHTML = unreadNumber;
//     title.innerHTML = "Notification"
//     setTimeout(() => {
//       unreadNotification[i].classList.remove("notification-click");
//       unreadNotification[i].classList.add("readed");
//     });
//   }
// };





$(document).ready(function (event) {

  $( ".posts" ).on( "click", function() {
      var id = $(this).attr('id');
      var classes = this.classList;
    for(let i=0 ; i<classes.length;i++){
      if(classes[i]=="unreaded"){
        $.ajax({
          type: "POST",
          url: "/stud-panel/post-checked/",
          data: {
            'post-id' : id
          },
          dataType : 'json',
    
          success: function (data) {
          
            // const dat = JSON.parse(data);

            if (data['message'] === "success") {
            var elm = document.getElementById(id);
            elm.classList.remove("unreaded");
            elm.classList.add("readed");
            elm.querySelector(
                  ".unread-dot"
            ).style.display = "none";


            } else {
              
            }
          },
          error: function (request, error) {
            console.log(error);
          },
        });
        
        break;
      }
      
    }
      // for(c in classes){
      // console.log(c[1])
      // }
  } );
  
});

