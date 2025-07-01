
/*
if ("serviceWorker" in navigator) {
  window.addEventListener("load", function () {
    navigator.serviceWorker
      .register("/service-workers.js")
      .then((res) => console.log("service worker registered"))
      .catch((err) => console.log("service worker not registered", err));
  });
}
*/

$(function(){

    window.onload = function() {
        $(".preload").hide();
        $.unblockUI();
        setTimeout(function(){
            console.log("Settime Out 1")
            unblockUI();
        }, 2000);
    };
})