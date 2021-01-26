//===== define global variable =====//
// application name
var app_name = "Mobile Application";

// define local storage shortcut
var storage = window.localStorage;

// set api server url
storage.setItem("apiServer", "/app/api/");
var apiServer = storage.getItem("apiServer");

// get api token, if api token not exists, define empty api_token
var api_token = storage.getItem("api_token");
if (api_token === undefined || api_token === null) {
    storage.setItem("api_token", "");
}

// get active page, if not exists, define new
var activePage = storage.getItem("activePage");
if (activePage === undefined || activePage === null) {
    route('login');
}

console.log("user_name", storage.getItem("user_name"));
console.log("activePage", activePage);
console.log("api_token", api_token);

// check for api token status and if empty, check for active page
if (api_token === "") {
    // if active page is not login/register
    // redirect to login page
    if (activePage !== "login" && activePage !== "register") {
        route('login');
    }
}

// catch page view redirect
function route(pageView, itemId) {
    storage.setItem("activePage", pageView); // selected page view
    storage.setItem("itemId", itemId); // item id if available
    location.href = "content.html";
}

// ajax setup for loading indicator when request is made
$.ajaxSetup({
    cache: true, // retrieve the latest version of an HTML page
    beforeSend: function () {
        $("#loading").show();

        // Reset error message if any
        $("#error-message").html("");
        $("#error-message").hide();
    },
    complete: function () {
        $("#loading").hide();
    },
    error: function () {
        $("#loading").hide();
    },
    headers: { "Authorization": "Bearer " + api_token },
});