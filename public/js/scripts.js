/*!
 * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
 * Copyright 2013-2023 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
 */
//
// Scripts
//

window.addEventListener("DOMContentLoaded", (event) => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector("#sidebarToggle");
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener("click", (event) => {
            event.preventDefault();
            document.body.classList.toggle("sb-sidenav-toggled");
            localStorage.setItem(
                "sb|sidebar-toggle",
                document.body.classList.contains("sb-sidenav-toggled")
            );
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const notification = document.getElementById("notification");
    if (notification) {
        // Show the notification
        notification.classList.add("show");

        // Automatically hide the notification after 5 seconds
        setTimeout(() => {
            notification.classList.remove("show");
        }, 5000);

        // Add event listener to the button to hide the notification
        const button = notification.querySelector(".button-box");
        button.addEventListener("click", () => {
            notification.classList.remove("show");
        });
    }
});

document.addEventListener('hide.bs.collapse', function (event) {
    console.log('Accordion ditutup:', event.target);
});
document.addEventListener('show.bs.collapse', function (event) {
    console.log('Accordion dibuka:', event.target);
});

